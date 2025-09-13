<?php

namespace App\Helpers;

use App\Models\MatchingList1;
use App\Models\MatchingList2;
use App\Models\Skill;
use App\Models\Step;
use App\Models\Test;
use App\Models\Variant;
use App\Models\VariantTrue;
use Illuminate\Support\Facades\Http;

class TeacherHelpers
{


    static public function generateVocabulary($step,$request,$user)
    {

        $prompt = "Я изучаю '{$step->course->topic}' в шаге '{$step->title}'.Создай лексию
Тема лексии от учителя: '{$request->topic}'

Требования учителя:
'{$request->promt}'

### Требования к лексии:
1. Заголовок title.
2. Подробная информация с примерами и объяснениями в формате HTML — **только содержимое внутри тега <body>**, без самого тега <body> и без тега <html>.
4. Несколько ссылок для изучения теми.
5. Если нет предпочтеня учителя сам подбери.
6. Очко опыта по 10 бальнойсистеме
7. Язык ответа на '{$user->leng}'

### Формат ответа (JSON):
{
       \"title\": \"строка\",
       \"exp\": \"опыт за прочитание\",
        \"info\": \"HTML-код, только содержимое внутри <body>, без <body> и <html>\",
        \"links\": [
            \"/\",
            \"/\",
            \"/\"
        ]
}

Пожалуйста, не возвращай полный HTML-документ, только содержимое тега <body>.
";



                    $roadmap = GlobalMethods::gpt($prompt);

                    return $roadmap;


    }
    static function one_correct($request)
    {

        $step=Step::query()->with('course')->find($request->id);
        $skills=Skill::query()->where('course_id',$step->course->id)->pluck('skill','id');

        $othertest=Test::query()->where('step_id',$step->id)->where('type_test','one_correct')->pluck('text','id')->toArray();
        $existingQuestions = implode("; ", $othertest);
        $prompt = "Создай 1 тест по теме '{$step->course->topic}' для шага '{$step->title}'.
Заголовок теста от учителя '{$request->title}' по этому заголовку создай тест.
### Требования к тесту:
1. **1 теста с одним правильным ответом**
   - Вопрос
   - 4 варианта ответа
   - 1 правильный вариант
   - Требование учителя закон


### Дополнительные условия:
- Важно: вопрос не должен быть похожим на: {$existingQuestions} — избегай дубликатов и переформулировок.
- Укажи, к какому навыку относится тест (из списка: [$skills]).
- Присвой  тесту баллы в зависимости от сложности по 10 балӣной системе.
- В итоге 1 тест!!!
- И пожелание учителя '{$request->promt}'
### Формат ответа (JSON):
```json
[
    \"one_correct\": {
      \"text\": \"Текст вопроса\",
      \"variants\": [\"Вариант 1\", \"Вариант 2\", \"Вариант 3\", \"Вариант 4\"],
      \"correct\": 1,
      \"score\": 10,
      \"id_skill\": 2
    }
]";



                $tests = GlobalMethods::gpt($prompt);
                $rt=$tests[0]["one_correct"];
                $test=Test::query()->create([
                    'step_id'=>$step->id,
                    'skill_id'=>$rt["id_skill"],
                    'course_id'=>$step->course_id,
                    'text'=>$rt["text"],
                    'type_test'=>"one_correct",
                    'view'=>0,
                    'verdict'=>'0',
                    'score'=>$rt["score"],
                ]);
                VariantTrue::query()->create([
                    'test_id'=>$test->id,
                    'true'=>$rt["correct"]
                ]);

                foreach ($rt['variants'] as $vr){
                    $insert_variant[]=[
                        'test_id'=>$test->id,
                        'variant'=>$vr
                    ];
                }

                Variant::query()->insert($insert_variant);

                 return $test;



    }
    static function list_correct($request)
    {

        $step=Step::query()->with('course')->find($request->id);
        $apiKey = env('GEMINI_API_KEY1');
        $skills=Skill::query()->where('course_id',$step->course->id)->pluck('skill','id');

        $othertest=Test::query()->where('step_id',$step->id)->where('type_test','one_correct')->pluck('text','id')->toArray();
        $existingQuestions = implode("; ", $othertest);
        $prompt = "Создай 1 тест по теме '{$step->course->topic}' для шага '{$step->title}'.
Заголовок теста от учителя '{$request->title}' по этому заголовку создай тест.
### Требования к тесту:
Теста с несколькими правильными ответами**
   - Вопрос
   - 4 варианта ответа
   - 2 или более правильных ответа


### Дополнительные условия:
- Важно: вопрос не должен быть похожим на: {$existingQuestions} — избегай дубликатов и переформулировок.
- Укажи, к какому навыку относится тест (из списка: [$skills]).
- Присвой  тесту баллы в зависимости от сложности по 10 балӣной системе.
- В итоге 1 тест!!!
- И пожелание учителя '{$request->promt}'
### Формат ответа (JSON):
```json
[
  \"list_correct\": {
      \"text\": \"Текст вопроса\",
      \"variants\": [\"Вариант 1\", \"Вариант 2\", \"Вариант 3\", \"Вариант 4\"],
      \"correct\": [0, 2],
      \"score\": 15,
      \"id_skill\": 3
    }
]";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";



        $tests = GlobalMethods::gpt($prompt);

                $rt=$tests[0]["list_correct"];
                $test=Test::query()->create([
                    'step_id'=>$step->id,
                    'skill_id'=>$rt["id_skill"],
                    'course_id'=>$step->course_id,
                    'text'=>$rt["text"],
                    'type_test'=>"list_correct",
                    'view'=>0,
                    'verdict'=>'0',
                    'score'=>$rt["score"],
                ]);

                foreach ($rt['variants'] as $vr){
                    $insert_variant[]=[
                        'test_id'=>$test->id,
                        'variant'=>$vr
                    ];
                }

                foreach ($rt['correct'] as $tr){
                    $insert_correct[]=[
                        'test_id'=>$test->id,
                        'true'=>$tr
                    ];
                }


                Variant::query()->insert($insert_variant);
                VariantTrue::query()->insert($insert_correct);
                return $test;




    }

    static function true_false($request)
    {
        $step=Step::query()->with('course')->find($request->id);

        $apiKey = env('GEMINI_API_KEY1');

        $skills=Skill::query()->where('course_id',$step->course->id)->pluck('skill','id');

        $othertest=Test::query()->where('step_id',$step->id)->where('type_test','one_correct')->pluck('text','id')->toArray();

        $existingQuestions = implode("; ", $othertest);

        $prompt = "Создай 1 тест по теме '{$step->course->topic}' для шага '{$step->title}'.
Заголовок теста от учителя '{$request->title}' по этому заголовку создай тест ветно не верно.
### Требования к тесту:
Теста верно/неверно**
   - Вопрос
   - 1 правильный,0 не правильный


### Дополнительные условия:
- Важно: тест не должен быть похожим на: {$existingQuestions} — избегай дубликатов и переформулировок.
- Укажи, к какому навыку относится тест (из списка: [$skills]).
- Присвой  тесту баллы в зависимости от сложности по 10 балӣной системе.
- В итоге 1 тест!!!
- И пожелание учителя '{$request->promt}'
### Формат ответа (JSON):
```json
[
     \"true_false\": {
      \"text\": \"Текст вопроса\",
      \"correct\": \"1 или 0\",
      \"score\": 20,
      \"id_skill\": 1
    }
]";





                $tests = GlobalMethods::gpt($prompt);
                $rt=$tests[0]["true_false"];
                $test=Test::query()->create([
                    'step_id'=>$step->id,
                    'skill_id'=>$rt["id_skill"],
                    'course_id'=>$step->course_id,
                    'text'=>$rt["text"],
                    'type_test'=>"true_false",
                    'view'=>0,
                    'verdict'=>'0',
                    'score'=>$rt["score"],
                ]);
                VariantTrue::query()->create([
                    'test_id'=>$test->id,
                    'true'=>$rt["correct"]
                ]);



                return $test;




    }

    static function question_answer($request)
    {

        $step=Step::query()->with('course')->find($request->id);
        $skills=Skill::query()->where('course_id',$step->course->id)->pluck('skill','id');

        $othertest=Test::query()->where('step_id',$step->id)->where('type_test','one_correct')->pluck('text','id')->toArray();
        $existingQuestions = implode("; ", $othertest);
        $prompt = "Создай 1 тест по теме '{$step->course->topic}' для шага '{$step->title}'.
Заголовок теста от учителя '{$request->title}' по этому заголовку создай тест.
### Требования к тесту:
Вопроса с открытым ответом**
   - Вопрос короткой вотпрос чтобы понять тест
   - Текстовый правильный ответ
   - Короткий ответ от до 10 символов.


### Дополнительные условия:
- Важно: Тест не должен быть похожим на: {$existingQuestions} — избегай дубликатов и переформулировок.
- Укажи, к какому навыку относится тест (из списка: [$skills]).
- Присвой  тесту баллы в зависимости от сложности по 10 балӣной системе.
- В итоге 1 тест!!!
- И пожелание учителя '{$request->promt}'
### Формат ответа (JSON):
```json
[
     \"question_answer\": {
      \"text\": \"Текст вопроса\",
      \"correct\": \"Правильный ответ\",
      \"score\": 20,
      \"id_skill\": 1
    }
]";



                $tests = GlobalMethods::gpt($prompt);
                $rt=$tests[0]["question_answer"];
                $test=Test::query()->create([
                    'step_id'=>$step->id,
                    'skill_id'=>$rt["id_skill"],
                    'course_id'=>$step->course_id,
                    'text'=>$rt["text"],
                    'type_test'=>"question_answer",
                    'view'=>0,
                    'verdict'=>'0',
                    'score'=>$rt["score"],
                ]);
                VariantTrue::query()->create([
                    'test_id'=>$test->id,
                    'true'=>$rt["correct"]
                ]);


                return $test;




    }

    static function matching($request)
    {

        $step=Step::query()->with('course')->find($request->id);
        $skills=Skill::query()->where('course_id',$step->course->id)->pluck('skill','id');

        $othertest=Test::query()->where('step_id',$step->id)->where('type_test','one_correct')->pluck('text','id')->toArray();
        $existingQuestions = implode("; ", $othertest);
        $prompt = "Создай 1 тест по теме '{$step->course->topic}' для шага '{$step->title}'.
Заголовок теста от учителя '{$request->title}' по этому заголовку создай тест.

### Требования к тесту:
тест на соответствие**
   - Вопрос
   - Две колонки (левая – элементы, правая – соответствующие им элементы)
   - В правильном порядке!!!


### Дополнительные условия:
- Важно: Тест не должен быть похожим на: {$existingQuestions} — избегай дубликатов и переформулировок.
- Укажи, к какому навыку относится тест (из списка: [$skills]).
- Присвой  тесту баллы в зависимости от сложности по 10 балӣной системе.
- В итоге 1 тест!!!
- И пожелание учителя '{$request->promt}'
### Формат ответа (JSON):
```json
[
    \"matching\": {
      \"text\": \"Текст вопроса\",
      \"list1\": [\"Элемент 1\", \"Элемент 2\", \"Элемент 3\"],
      \"list2\": [\"Соответствие 1\", \"Соответствие 2\", \"Соответствие 3\"],
      \"score\": 25,
      \"id_skill\": 4
    }
]";




                $tests =GlobalMethods::gpt($prompt);
                $rt=$tests[0]["matching"];
                $test=Test::query()->create([
                    'step_id'=>$step->id,
                    'skill_id'=>$rt["id_skill"],
                    'course_id'=>$step->course_id,
                    'text'=>$rt["text"],
                    'type_test'=>"matching",
                    'view'=>0,
                    'verdict'=>'0',
                    'score'=>$rt["score"],
                ]);


                foreach ($rt['list1'] as $list1){
                    $insert_list1[]=[
                        'test_id'=>$test->id,
                        'str'=>$list1
                    ];
                }
                foreach ($rt['list2'] as $list2){
                    $insert_list2[]=[
                        'test_id'=>$test->id,
                        'str'=>$list2
                    ];
                }
                MatchingList1::query()->insert($insert_list1);
                MatchingList2::query()->insert($insert_list2);

                return $test;


    }


}
