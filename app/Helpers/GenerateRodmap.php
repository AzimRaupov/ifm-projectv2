<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\MatchingList1;
use App\Models\MatchingList2;
use App\Models\Step;
use App\Models\Test;
use App\Models\Variant;
use App\Models\VariantTrue;
use Illuminate\Support\Facades\Http;
use Orhanerday\OpenAi\OpenAi;

class GenerateRodmap
{
    public static function generateRodmap($req, $user)
    {
        $apiKey = env('GEMINI_API_KEY');

        // Создаем понятный запрос для модели Gemini
        $prompt = "Создай пошаговый план для человека, которому ".$user->old." лет, и который может уделить ".$req->freetime." часов в неделю на изучение. Тема для изучения: '".$req->topic."'. Мой уровень знания '".$req->topic."' равен '".$req->level."'

      Язык ответа должан быть ".$user->leng."!!

    Требование к курсу:
        1.topic_course={$req->topic} можеш только испровлять отпечатки
        2.Cумма experience всех шагов должен быть равным 100!!

    План должен состоять из 12-30 шагов, где:
    - Каждый шаг должен содержать:
        1. Краткое и понятное название темы шага,только название темы!!!.
        2. Количество опыта experience;
        3. Навыки, которые человек получит (минимум 7 навыков, максимум 12, только важные и нужные навыки, без лишней информации).
        4. Есть два типа шагов родитель,наследник.
        5. Родитель имеит макс 4 наследника,родитель не можеть быть наследником.
    Возвращай план в формате JSON со следующей структурой:

    {
        'topic_course': '',
        'skills': ['навык1', 'навык2', ..., 'навыкN'],  // Список навыков, которые человек изучит
        'map': [
            {
                'topic': 'Тема шага 1',
                'type':'parent' //Родитель parent и наследник  heir
                'heirs':[] //ID наследников начиная с 0
                'experience': 10,  // Опыт за выполнение этого шага
            },
            {
                'topic': 'Тема шага 2',
                'type':'heir' //Родитель parent и наследник  heir
                'experience': 15,
            },
            // Добавьте столько шагов, сколько нужно (от 12 до 30)
        ]
    }

    Пожалуйста, убедитесь, что темы шагов ясные и краткие, а каждый шаг логически связан с предыдущим.";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            // Отправка запроса к API Gemini
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

            // Обработка успешного ответа
            if ($response->successful()) {
                $result = $response->json();
                $text = $result['candidates'][0]['content']['parts'][0]['text'];
                $clean = str_replace(['```json', '```'], '', $text);
                $roadmap = trim($clean);
                return json_decode($roadmap, true);
            }

            // Возвращаем ошибку в случае неудачного запроса
            return response()->json(['error' => 'Ошибка API'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public static function generateTests($step,$skills)
    {


        $pr=$step->course->step."/".count($step->course->steps);
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
- Укажи, к какому навыку относится каждый тест (из списка: [$skills]).
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
                $text=$result['candidates'][0]['content']['parts'][0]['text'];
                $clean = str_replace(['```json', '```'], '', $text);
                $tests = json_decode(trim($clean),true);
                $create_data=[];
                $insert_variant=[];
                $insert_correct=[];
                $insert_list1=[];
                $insert_list2=[];
                foreach ($tests as $item) {
                    $type = key($item);
                    $test = $item[$type];



                    $create_data= [
                        'course_id' => $step->course_id,
                        'step_id' => $step->id,
                        'skill_id' => $test['id_skill'],
                        'text' => $test['text'],
                        'type_test' => $type,
                        'score' => $test['score']
                    ];
                    $result_create=Test::query()->create($create_data);
                    $create_data=[];


                    if($type=="one_correct"){
                        $insert_correct[]=[
                            "test_id"=>$result_create->id,
                            "true"=>$test['correct']
                        ];
                        foreach ($test['variants'] as $vr){
                            $insert_variant[]=[
                                'test_id'=>$result_create->id,
                                'variant'=>$vr
                            ];
                        }
                    }

                    if($type=="list_correct"){
                        foreach ($test['correct'] as $tr){
                            $insert_correct[]=[
                                'test_id'=>$result_create->id,
                                'true'=>$tr
                            ];
                        }

                        foreach ($test['variants'] as $vr){
                            $insert_variant[]=[
                                'test_id'=>$result_create->id,
                                'variant'=>$vr
                            ];
                        }
                    }
                    if($type=="question_answer"){
                        $insert_correct[]=[
                            'test_id'=>$result_create->id,
                            'true'=>$test['correct']
                        ];
                    }
                    if($type=="true_false"){
                        $insert_correct[]=[
                            'test_id'=>$result_create->id,
                             'true'=>$test['correct']
                        ];
                    }
                    if($type=="matching"){

                        foreach ($test['list1'] as $list1){
                            $insert_list1[]=[
                                'test_id'=>$result_create->id,
                                'str'=>$list1
                            ];
                        }
                        foreach ($test['list2'] as $list2){
                            $insert_list2[]=[
                                'test_id'=>$result_create->id,
                                'str'=>$list2
                            ];
                        }
                    }
                }
                MatchingList1::query()->insert($insert_list1);
                MatchingList2::query()->insert($insert_list2);
                Variant::query()->insert($insert_variant);
                VariantTrue::query()->insert($insert_correct);
                return "d";

            }

            return response()->json(['error' => 'Ошибка API'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    static public function generateVocabulary($step)
    {
        $apiKey = env('GEMINI_API_KEY1');

        $prompt = "Я изучаю '{$step->course->topic}' в шаге '{$step->title}' раздели шаг на несколько подшогов и без доб информатсии:
### Требования к подшагам:
1. **Заголовак каждому подшагу**
2. **Подробная информация с примерами и объяснениями в формате html**
3. **Количество подшагов зависет от сложности шага**.
4. **Несколько ссылок для изучения подшага**

### Формат ответа (JSON):
```json
[
    {   'title':str,
        'info': html,
        'links': [
            '/',
            '/',
            '/'
        ]
    }
]
```
 Пожалуйста, убедитесь,что формат json не ошибочный.
";

        // URL для запроса
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            // Отправляем запрос к API
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

            // Проверяем успешность запроса
            if ($response->successful()) {
                $result = $response->json();

                // Проверяем, что результат содержит кандидатов
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $text = $result['candidates'][0]['content']['parts'][0]['text'];

                    // Очищаем текст от лишних элементов
                    $clean = str_replace(['```json', '```'], '', $text);
                    $roadmap = trim($clean);

                    // Возвращаем распарсенный JSON
                    return json_decode($roadmap, true);
                }

                // Если текст не найден в ответе, возвращаем ошибку
                return response()->json(['error' => 'Не удалось найти нужные данные в ответе API'], 400);
            }

            // Если API вернуло ошибку, выводим ошибку
            return response()->json(['error' => 'Ошибка API', 'status' => $response->status(), 'message' => $response->body()], $response->status());

        } catch (\Exception $e) {
            // Логирование и обработка исключений
            return response()->json(['error' => 'Ошибка при подключении к API: ' . $e->getMessage()], 500);
        }
    }

    static public function generateDescriptionn($step)
    {
        $open_ai_key = env('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $chat = $open_ai->chat([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    "role" => "system",
                    "content" => "You are a helpful assistant."
                ],
                ['role' => 'user', 'content' => ' Создай описание на тему "' . $step->course->topic . '" шаг "' . $step->title . '" в формате HTML.
                Также предоставь минимум 5 внешних ссылок для изучения.

                ### Формат ответа (JSON):
                ```json
                {
                    "info": {
                        "description": "HTML-описание шага",
                        "links": [
                            "https://example.com",
                            "https://example.com",
                            "https://example.com",
                            "https://example.com",
                            "https://example.com"
                        ]
                    }
                }
                ```
                Убедись, что ответ полностью соответствует этой структуре JSON.

                '],

            ],
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        //  return response()->json($chat);

        $text=json_decode($chat,true)['choices'][0]['message']['content'];
        $clean = str_replace(['```json', '```'], '', $text);
        $data=json_decode(trim($clean),true);
        return $data;
    }
    function pr()
    {
        $pr='Создай план обучения для предмета "Технологияи иттилооти" на таджикском языке. План должен быть представлен в формате JSON и содержать следующие разделы:

1. **Компетенция**: Укажи, что ученики должны знать и уметь после изучения темы.
2. **Цели и требования**: Опиши основные цели урока и требования к знаниям учеников.
3. **Оборудование**: Перечисли необходимое оборудование или материалы для проведения урока.
4. **Вопросы**: Предложи ключевые вопросы, которые помогут ученикам лучше понять тему.
5. **Методика проведения**: Опиши методы и подходы, которые будут использоваться для проведения урока.
6. **Итог урока**: Укажи, как будет оцениваться результативность урока и что ученики должны усвоить.
7. **Домашнее задание**: Предложи задание для закрепления материала.

Ответ предоставь в формате JSON, где каждый раздел будет ключом объекта.

{
  "Компетенция": "Описание того, что ученики должны знать и уметь.",
  "Цели и требования": "Перечень целей и требований к знаниям учеников.",
  "Оборудование": ["Список оборудования и материалов."],
  "Вопросы": ["Ключевые вопросы для обсуждения."],
  "Методика проведения": "Описание методов и подходов к проведению урока.",
  "Итог урока": "Оценка результативности урока и ключевые выводы.",
  "Домашнее задание": "Описание домашнего задания для учеников."
}


';

    }
    static public function generateDescription($step)
    {
        $apiKey = env('GEMINI_API_KEY');

        $promt=' Создай описание на тему "' . $step->course->topic . '" шаг "' . $step->title . '" в формате HTML.
                Также предоставь минимум 5 внешних ссылок для изучения и қҷлки на видео уроки.

                ### Формат ответа (JSON):
                ```json
                {
                    "info": {
                        "description": "HTML-описание шага",
                        "links": [
                            "https://example.com",
                            "https://example.com",
                            "https://example.com",
                            "https://example.com",
                            "https://example.com"
                        ]
                    }
                }
                ```
                Убедись, что ответ полностью соответствует этой структуре JSON.

          ';

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            // Отправляем запрос к API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $promt]
                        ]
                    ]
                ]
            ]);

            // Проверяем успешность запроса
            if ($response->successful()) {
                $result = $response->json();

                // Проверяем, что результат содержит кандидатов
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $text = $result['candidates'][0]['content']['parts'][0]['text'];

                    // Очищаем текст от лишних элементов
                    $clean = str_replace(['```json', '```'], '', $text);
                    $roadmap = trim($clean);

                    // Возвращаем распарсенный JSON
                    return json_decode($roadmap, true);
                }

                // Если текст не найден в ответе, возвращаем ошибку
                return response()->json(['error' => 'Не удалось найти нужные данные в ответе API'], 400);
            }

            // Если API вернуло ошибку, выводим ошибку
            return response()->json(['error' => 'Ошибка API', 'status' => $response->status(), 'message' => $response->body()], $response->status());

        } catch (\Exception $e) {
            // Логирование и обработка исключений
            return response()->json(['error' => 'Ошибка при подключении к API: ' . $e->getMessage()], 500);
        }
    }
}
