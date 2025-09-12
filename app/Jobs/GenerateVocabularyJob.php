<?php

namespace App\Jobs;

use App\Models\Link;
use App\Models\Step;
use App\Models\Test;
use App\Models\VocabularyStep;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateVocabularyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $step_id;
    public function __construct($step_id)
    {
        $this->step_id=$step_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $step = Step::with('course')->find($this->step_id);
        if (!$step || !$step->course) {
            Log::error("Step or course not found for step_id: {$this->step_id}");
            return;
        }

        $apiKey = env('GEMINI_API_KEY1');

        // Формируем prompt с динамическими значениями
        $prompt = "Я изучаю '{$step->course->topic}' в шаге '{$step->title}'. Раздели шаг на несколько подшагов без лишней информации.

### Требования к подшагам:
1. Заголовок для каждого подшага
2. Подробная информация с примерами и объяснениями в формате HTML — **только содержимое внутри тега <body>**.
3. Количество подшагов зависит от сложности шага.
4. Несколько ссылок для изучения подшага.
5. Опыт за прочитания лексии по сложности лексии макст 10.
### Формат ответа (JSON):
[
    {
        \"title\": \"строка\",
        \"exp\": \"очко опыта\",
        \"info\": \"HTML-код, только содержимое внутри <body>, без <body> и <html>\",
        \"links\": [
            \"/\",
            \"/\",
            \"/\"
        ]
    }
]

Пожалуйста, не возвращай полный HTML-документ, только содержимое тега <body>.
";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $text = $result['candidates'][0]['content']['parts'][0]['text'];

                    $clean = str_replace(['```json', '```'], '', $text);
                    $decoded = json_decode($clean, true);

                    if (!is_array($decoded)) {
                        Log::error('Невозможно декодировать JSON: ' . $clean);
                        return;
                    }

                    $linksToInsert = [];

                    foreach ($decoded as $item) {
                        $vocabulary = VocabularyStep::create([
                            'step_id' => $step->id,
                            'course_id'=>$step->course_id,
                            'title' => $item['title'] ?? 'Без названия',
                            'text' => $item['info'] ?? '',
                            'exp'=>$item['exp']
                        ]);
                       $step->course->increment('ex',$item['exp']);
                        if (!empty($item['links']) && is_array($item['links'])) {
                            foreach ($item['links'] as $link) {
                                $linksToInsert[] = [
                                    'vocabulary_step_id' => $vocabulary->id,
                                    'link' => $link,
                                    'step_id' => null,
                                ];
                            }
                        }
                    }

                    if (!empty($linksToInsert)) {
                        Link::insert($linksToInsert);
                    }

                    $step->load('vocabularies.links');
                    Log::info("Vocabulary successfully generated for step_id: {$step->id}");
                    return;
                } else {
                    Log::error('Не удалось найти нужные данные в ответе API');
                }
            } else {
                Log::error('Ошибка API', [
                    'status' => $response->status(),
                    'body' => $step->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Ошибка при подключении к API: ' . $step->id);
        }

    }
}
