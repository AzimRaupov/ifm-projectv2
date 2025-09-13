<?php

namespace App\Jobs;

use App\Helpers\GlobalMethods;
use App\Models\Link;
use App\Models\Step;
use App\Models\VocabularyStep;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateGptVocabulary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

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
        // Получаем шаг с курсом
        $step = Step::with('course')->find($this->step_id);
        if (!$step || !$step->course) {
            Log::error("Step or course not found for step_id: {$this->step_id}");
            return;
        }

        // Формируем prompt для GPT
        $prompt = "I am studying \"$step->course->topic\" in the step \"$step->title\". Break this step into several logically complete sub-steps and write for each of them a **detailed educational explanation**, similar to a university lecture or textbook.

### Requirements for each sub-step:
1. A clear and concise **title**.
2. The **response must be in Russian** language.
3. For each sub-step, provide a **minimum of 300-500 words** of detailed, high-quality educational content in **HTML format**, but include **only content inside the `<body>` tag**.
4. Include **multiple examples, analogies, or code** (if applicable).
5. Add **2–4 relevant and useful links** for deeper learning.
6. Rate the **complexity** of each sub-step with an `exp` field from 1 to 10.
7. The total number of sub-steps should depend on the complexity of the original step.

### Output format:
Respond **only** with a valid JSON array, where each object has the following structure:

```json
[
    {
        \"title\": \"Название подшага\",
        \"exp\": 6,
        \"info\": \"<p>HTML-контент внутри тега body, минимум 300 слов, с объяснениями, примерами и т.п.</p>\",
        \"links\": [
            \"https://example.com/1\",
            \"https://example.com/2\"
        ]
    },
    {
        \"title\": \"Название подшага 2\",
        \"exp\": 4,
        \"info\": \"<p>Ещё один подробный блок лекционного материала.</p>\",
        \"links\": [
            \"https://example.com/3\",
            \"https://example.com/4\"
        ]
    }
]
";

        // Получаем ответ от GPT
        $decoded = GlobalMethods::gpt($prompt,9000);

        if ($decoded === null) {
            Log::error("Failed to get valid response from GPT for step_id: {$this->step_id}");
            return;
        }

        // Инициализация массива для ссылок
        $linksToInsert = [];

        foreach ($decoded as $item) {
            $vocabulary = VocabularyStep::create([
                'step_id' => $step->id,
                'course_id' => $step->course_id,
                'title' => $item['title'] ?? 'Без названия',
                'text' => $item['info'] ?? '',
                'exp' => $item['exp']
            ]);

            // Увеличиваем опыт на уровне курса
            $step->course->increment('ex', $item['exp']);

            if (!empty($item['links']) && is_array($item['links'])) {
                foreach ($item['links'] as $link) {
                    $linksToInsert[] = [
                        'vocabulary_step_id' => $vocabulary->id,
                        'link' => $link,
                        'step_id' => null,  // Это поле выглядит подозрительным, возможно, его стоит изменить на step_id
                    ];
                }
            }
        }

        // Вставляем ссылки в базу, если они есть
        if (!empty($linksToInsert)) {
            Link::insert($linksToInsert);
        }

        // Загружаем связанные данные
        $step->load('vocabularies.links');

        Log::info("Vocabulary successfully generated for step_id: {$step->id}");
    }

}
