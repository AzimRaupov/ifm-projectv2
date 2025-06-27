<?php

namespace App\Jobs;


use App\Models\Step;
use App\Models\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stepId;
    protected $skills;

    public function __construct($stepId, $skills)
    {
        $this->stepId = $stepId;
        $this->skills = $skills;
    }
    public function handle()
    {
        $step = Step::with('course.steps')->find($this->stepId);

        if (!$step || !$step->course) {
            Log::error("Step или Course не найдены: step_id={$this->stepId}");
            return;
        }

        $course = $step->course;
        $progress = "{$step->course->step}/" . count($course->steps);
        $apiKey = env('GEMINI_API_KEY1');

        $prompt = "Создай 8 тестов по теме '{$step->course->topic}' для шага '{$step->title}'.

### Требования к тестам:
1. **2 теста с одним правильным ответом**
   - Вопрос
   - 4 варианта ответа
   - 1 правильный вариант

2. **2 теста с несколькими правильными ответами**
   - Вопрос
   - 4 варианта ответа
   - 2 или более правильных ответа

3. **2 вопроса с открытым ответом**
   - Вопрос
   - Текстовый правильный ответ
   - Короткий ответ от до 10 символов.

4. **2 теста с верно/неверно**
   - Вопрос
   - 1 правильный,0 не правильный

5. **2 теста на соответствие**
   - Вопрос
   - Две колонки (левая – элементы, правая – соответствующие им элементы)
   - В правильном порядке!!!

### Дополнительные условия:
- Укажи, к какому навыку относится каждый тест (из списка: [$this->skills]).
- Присвой каждому тесту баллы в зависимости от сложности.
- У меня {$step->course->ex} баллов из 1000.
- В итоге 10 тестов!!!

### Формат ответа (JSON):
```json
[
  {
    \"one_correct\": {
      \"text\": \"Текст вопроса\",
      \"variants\": [\"Вариант 1\", \"Вариант 2\", \"Вариант 3\", \"Вариант 4\"],
      \"correct\": 1,
      \"score\": 10,
      \"id_skill\": 2
    },
    \"list_correct\": {
      \"text\": \"Текст вопроса\",
      \"variants\": [\"Вариант 1\", \"Вариант 2\", \"Вариант 3\", \"Вариант 4\"],
      \"correct\": [0, 2],
      \"score\": 15,
      \"id_skill\": 3
    },
    \"question_answer\": {
      \"text\": \"Текст вопроса\",
      \"correct\": \"Правильный ответ\",
      \"score\": 20,
      \"id_skill\": 1
    },
     \"true_false\": {
      \"text\": \"Текст вопроса\",
      \"correct\": \"1 или 0\",
      \"score\": 20,
      \"id_skill\": 1
    },
    \"matching\": {
      \"text\": \"Текст вопроса\",
      \"list1\": [\"Элемент 1\", \"Элемент 2\", \"Элемент 3\"],
      \"list2\": [\"Соответствие 1\", \"Соответствие 2\", \"Соответствие 3\"],
      \"score\": 25,
      \"id_skill\": 4
    }
  }
]";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
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
                $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $clean = str_replace(['```json', '```'], '', $text);
                $tests = json_decode(trim($clean), true);

                if (!is_array($tests)) {
                    Log::error("Неверный JSON от Gemini: " . $text);
                    return;
                }
                \Log::info('Received tests:', $tests);

                $create_data = [];

                foreach ($tests as $item) {
                    $type = key($item);
                    $test = $item[$type];

                    $create_data[] = [
                        'course_id' => $step->course_id,
                        'step_id' => $step->id,
                        'skill_id' => $test['id_skill'],
                        'text' => $test['text'],
                        'type_test' => $type,
                        'variants' => isset($test['variants']) ? json_encode($test['variants']) : null,
                        'correct' => isset($test['correct']) ? json_encode($test['correct']) : null,
                        'score' => $test['score'],
                        'list1' => isset($test['list1']) ? json_encode($test['list1']) : null,
                        'list2' => isset($test['list2']) ? json_encode($test['list2']) : null,
                    ];
                }

                Test::insert($create_data);
                Log::info("Тесты успешно созданы для step_id={$this->stepId}");
                return;
            }

            Log::error("Gemini API ошибка: " . $response->status() . " — " . $response->body());

        } catch (\Exception $e) {
            Log::error("GenerateTestJob exception: " . $e->getMessage());
        }
    }
}
