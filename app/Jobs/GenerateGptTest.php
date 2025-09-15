<?php

namespace App\Jobs;

use App\Helpers\GlobalMethods;
use App\Models\MatchingList1;
use App\Models\MatchingList2;
use App\Models\Step;
use App\Models\Test;
use App\Models\Variant;
use App\Models\VariantTrue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateGptTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    protected $stepId;
    protected $skills;

    public function __construct($stepId, $skills)
    {
        $this->stepId = $stepId;
        $this->skills = $skills;
    }

    public function handle()
    {
        // Получаем шаг
        $step = Step::with('course.steps')->find($this->stepId);

        if (!$step || !$step->course) {
            Log::error("Step или Course не найдены: step_id={$this->stepId}");
            return;
        }

        Log::info("Шаг и курс успешно получены для step_id={$this->stepId}");

        $course = $step->course;
        $progress = "{$step->course->step}/" . count($course->steps);
        Log::info("Прогресс курса: {$progress}");

        $prompt = "Создай ровно 10 тестов по теме '{$step->course->topic}' для шага '{$step->title}'.

### Требования к тестам:
1. **2 теста с одним правильным ответом**
   - Вопрос
   - 4 варианта ответа // variants
   - 1 правильный вариант // correct

2. **2 теста с несколькими правильными ответами**
   - Вопрос
   - 4 варианта ответа // variants
   - 2 или более правильных ответа // correct

3. **2 вопроса с открытым ответом**
   - Вопрос
   - Текстовый правильный ответ короткий ответ от до 10 символов. // correct

4. **2 теста с верно/неверно**
   - Вопрос
   - 1 правильный,0 не правильный // correct

5. **2 теста на соответствие**
   - Вопрос
   - Две колонки (левая – элементы list1 , правая – соответствующие им элементы list2)
   - В правильном порядке!!!

### Условия:
- Укажи, к какому навыку относится каждый тест (из списка: [$this->skills]). // id_skill
- Присвой каждому тесту баллы в зависимости от сложности в. // score
- В итоге 10 тестов!!!
-

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
]

Убедись, что ответ полностью соответствует этой структуре JSON.

";
        Log::info("Запрос к GPT для создания тестов: {$prompt}");

        // Генерация тестов через GPT
        $tests = GlobalMethods::gpt($prompt,9000);

        // Проверка наличия данных тестов
        if (empty($tests)) {
            Log::error("Ответ от GPT пуст или не получен для step_id={$this->stepId}");
            return;
        }

        Log::info("Тесты успешно получены от GPT для step_id={$this->stepId}");

        // Инициализация массивов для данных
        $create_data = [];
        $insert_variant = [];
        $insert_correct = [];
        $insert_list1 = [];
        $insert_list2 = [];

        foreach ($tests as $item) {
            $type = key($item);
            $test = $item[$type];

            // Создание теста в базе данных
            $create_data = [
                'course_id' => $step->course_id,
                'step_id' => $step->id,
                'skill_id' => $test['id_skill'],
                'text' => $test['text'],
                'type_test' => $type,
                'score' => $test['score']
            ];

            Log::info("Создание теста: {$create_data['text']}");

            $result_create = Test::query()->create($create_data);
            $create_data = []; // Очищаем массив для следующего теста
            $step->course->increment('ex', $test['score']);

            Log::info("Тест успешно создан для step_id={$step->id}, test_id={$result_create->id}");

            // Обработка типов тестов
            if ($type == "one_correct") {
                $insert_correct[] = [
                    "test_id" => $result_create->id,
                    "true" => $test['correct']
                ];
                foreach ($test['variants'] as $vr) {
                    $insert_variant[] = [
                        'test_id' => $result_create->id,
                        'variant' => $vr
                    ];
                }
            }

            if ($type == "list_correct") {
                foreach ($test['correct'] as $tr) {
                    $insert_correct[] = [
                        'test_id' => $result_create->id,
                        'true' => $tr
                    ];
                }

                foreach ($test['variants'] as $vr) {
                    $insert_variant[] = [
                        'test_id' => $result_create->id,
                        'variant' => $vr
                    ];
                }
            }

            if ($type == "question_answer") {
                $insert_correct[] = [
                    'test_id' => $result_create->id,
                    'true' => $test['correct']
                ];
            }

            if ($type == "true_false") {
                $insert_correct[] = [
                    'test_id' => $result_create->id,
                    'true' => $test['correct']
                ];
            }

            if ($type == "matching") {
                foreach ($test['list1'] as $list1) {
                    $insert_list1[] = [
                        'test_id' => $result_create->id,
                        'str' => $list1
                    ];
                }
                foreach ($test['list2'] as $list2) {
                    $insert_list2[] = [
                        'test_id' => $result_create->id,
                        'str' => $list2
                    ];
                }
            }
        }

        // Вставка данных в базы данных
        try {
            MatchingList1::query()->insert($insert_list1);
            MatchingList2::query()->insert($insert_list2);
            Variant::query()->insert($insert_variant);
            VariantTrue::query()->insert($insert_correct);

            Log::info("Все данные успешно вставлены в базу данных для step_id={$this->stepId}");
        } catch (\Exception $e) {
            Log::error("Ошибка при вставке данных в базу: " . $e->getMessage());
            return;
        }

        Log::info("Тесты успешно созданы для step_id={$this->stepId}");
    }
}
