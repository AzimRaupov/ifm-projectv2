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
        $prompt = "Создай учебный план для человека, которому ".$user->old." лет.
Он может уделять ".$req->freetime." часов в неделю.
Тема курса: '".$req->topic."'.
Уровень знаний: '".$req->level."'.
Язык ответа: ".$user->leng.".

Правила:
1. topic_course = {$req->topic} (можно только исправить опечатки).
2. Количество шагов от 12 до 30.
   - Если уровень = beginner → начинать с основ и идти до конца темы.
   - Если уровень = intermediate → пропустить простые основы и продолжить с середины.
   - Если уровень = advanced → пропустить начало и дать только продвинутые шаги.
3. Каждый шаг содержит:
   - Название темы (только название).
   - experience (опыт).
   - Минимум 7 ключевых навыков.
   - type: parent или heir.
   - parent может иметь до 4 heirs. parent не может быть heir.

Ответ строго в JSON:

{
    'topic_course': '',
    'skills': ['навык1','навык2',...],
    'map': [
        {
            'topic': 'Тема шага 1',
            'type': 'parent',
            'heirs': [1,2],
            'experience': 10
        },
        {
            'topic': 'Тема шага 2',
            'type': 'heir',
            'experience': 15
        }
    ]
}";


        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($url, [
                'contents' => [[
                    'parts' => [['text' => $prompt]]
                ]]
            ]);

            if ($response->successful()) {
                $result = $response->json();

                $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if (!$text) {
                    return null;
                }
                $clean = str_replace(['```json', '```'], '', $text);
                $tests = json_decode(trim($clean), true);





                    return $tests;

            }

            // Логируем статус ошибки от API
            \Log::error('Gemini API error: ' . $response->status());
            return null;

        } catch (\Exception $e) {
            \Log::error('Gemini exception: ' . $e->getMessage());
            return null;
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

        $prompt = "Я изучаю '{$step->course->topic}' в шаге '{$step->title}'. Раздели шаг на несколько подшагов без лишней информации.

### Требования к подшагам:
1. Заголовок для каждого подшага
2. Подробная информация с примерами и объяснениями в формате HTML — **только содержимое внутри тега <body>**, без самого тега <body> и без тега <html>.
3. Количество подшагов зависит от сложности шага.
4. Несколько ссылок для изучения подшага.

### Формат ответа (JSON):
[
    {
        \"title\": \"строка\",
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

    static public function generateDescriptionn($req, $user)
    {

        $prompt = "Создай учебный план для человека, которому ".$user->old." лет.
Тема курса: '".$req->topic."'.
Уровень знаний: '".$req->level."'.
Язык ответа: ".$user->leng.".

Правила:
1. Проверь правильность темы если не возмажный курс то status='fail'
2. Провер чтобы все шаги были для полного понимания курса и професии!!
3. topic_course = {$req->topic} (можно только исправить опечатки).
4. Количество шагов по болше
   - Если уровень = beginner → начинать с основ и идти до конца темы.
   - Если уровень = intermediate → пропустить простые основы и продолжить с середины.
   - Если уровень = advanced → пропустить начало и дать только продвинутые шаги.
5. Каждый шаг содержит:
   - Название темы (только название).
   - experience (опыт).
   - Минимум 7 ключевых навыков.
   - type: parent или heir.
   - parent может иметь до 4 heirs. parent не может быть heir.

Ответ строго в JSON:

{
    'topic_course': '',
    'status': 'accept',
    'skills': ['навык1','навык2',...],
    'map': [
        {
            'topic': 'Тема шага 1',
            'type': 'parent',
            'heirs': [1,2],
            'experience': 10
        },
        {
            'topic': 'Тема шага 2',
            'type': 'heir',
            'experience': 15
        }
    ]
}";


       $decoded=GlobalMethods::gpt($prompt);


        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['map'])) {
            return $decoded;
        }

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
    static public function generateDescriptiongemini($step)
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
    static public function generateDescription($step)
    {


        $prompt = 'Создай подробное, насыщенное HTML-описание на тему курса "' . $step->course->topic . '" в шаге "' . $step->title . '". Это должно быть похоже на мини-лекцию или статью, содержащую структурированный материал.

### Требования к описанию:
1. Используй полноценную HTML-разметку: заголовки (`<h2>`, `<h3>`), параграфы (`<p>`), списки (`<ul>`, `<ol>`), примеры (`<pre>`, `<code>`), цитаты (`<blockquote>`), выделения (`<strong>`, `<em>`).
2. Контент должен быть **только внутри тега `<body>`**, но сам тег писать не нужно.
3. Тема должна быть раскрыта **глубоко**, минимум 400 слов.
4. Избегай воды и общих фраз — пиши по делу, объясняя тему с примерами и аналогиями.
5. Обязательно добавь **не менее 5 внешних ссылок** в поле `links`, включая ссылки на видеоуроки, если доступны.
6. Все ссылки должны быть релевантными и полезными для дальнейшего изучения темы "' . $step->title . '".
7. Ответ должен быть строго в JSON-формате, как в примере ниже. Никаких пояснений, комментариев, заголовков и т.п.

### Формат ответа (JSON):
```json
{
    "info": {
        "description": "<h2>Заголовок</h2><p>Подробное описание...</p><ul><li>Пункт</li></ul><pre><code>пример кода</code></pre>",
        "links": [
            "https://example.com/1",
            "https://example.com/2",
            "https://example.com/3",
            "https://example.com/4",
            "https://example.com/5"
        ]
    }
}
```';


        return GlobalMethods::gpt($prompt,3000,"system","Ты учител и наставник");
    }
}
