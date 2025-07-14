<?php

namespace App\Http\Controllers\teacher;

use App\Helpers\GenerateRodmap;
use App\Http\Controllers\Controller;
use App\Jobs\DownloadLogoJob;
use App\Models\Course;
use App\Models\MatchingList1;
use App\Models\MatchingList2;
use App\Models\Skill;
use App\Models\Step;
use App\Models\StudentCourse;
use App\Models\TeacherCourse;
use App\Models\Test;
use App\Models\User;
use App\Models\Variant;
use App\Models\VariantTrue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{
    public function create()
    {
        return view('teacher.course.create');
    }
    public function store(Request $request)
    {
        $user=Auth::user();
        $date_start=Carbon::today();
        $map=GenerateRodmap::generateRodmap($request,$user);

        $course=Course::query()->create([
            'user_id'=>$user->id,
            'topic'=>$map['topic_course'],
            'type'=>1,
            'freetime'=>$request->input('freetime'),
            'level'=>$request->input('level'),
            'date_start'=>$date_start
        ]);
        dispatch(new DownloadLogoJob((object)['id' => $course->id]));

        $data=$map["map"];
        $skills=[];
        foreach ($map['skills'] as $list){
            $skills[] = [
                'skill' => $list,
                'course_id' => $course->id,
                'user_id' => $user->id,
            ];
        }
        Skill::insert($skills);
        $create=[];
        foreach ($data as $list){
            $create[]=[
                'course_id'=>$course->id,
                'title'=>$list['topic'],
                'experience'=>$list['experience'],
                'type'=>$list['type'],
                'heirs' => isset($list['heirs']) ? json_encode($list['heirs']) : null
            ];
        }
        Step::insert($create);
        return response()->json([
            'redirect_url' => route('teacher.course.show', ['id' => $course->id])
        ]);
    }

    public static function gen(Request $request)
    {

        $step=Step::query()->with('course')->find($request->id);
        $apiKey = env('GEMINI_API_KEY1');
        $skills=Skill::query()->where('course_id',$step->course->id)->pluck('skill','id');

        $othertest=Test::query()->where('step_id',$step->id)->where('type_test','one_correct')->pluck('text','id')->toArray();
        $existingQuestions = implode("; ", $othertest);
        $prompt = "Создай 1 тест по теме '{$step->course->topic}' для шага '{$step->title}'.

### Требования к тесту:
1. **1 теста с одним правильным ответом**
   - Вопрос
   - 4 варианта ответа
   - 1 правильный вариант


### Дополнительные условия:
- Важно: вопрос не должен быть похожим на: {$existingQuestions} — избегай дубликатов и переформулировок.
- Укажи, к какому навыку относится тест (из списка: [$skills]).
- Присвой  тесту баллы в зависимости от сложности.
- У меня {$step->course->ex} баллов из 1000.
- В итоге 1 тест!!!

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
                dd($tests);

            }

            return response()->json(['error' => 'Ошибка API'], $response->status());

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function show(Request $request)
    {
        $user=Auth::user();
        $course = Course::query()->where('user_id', $user->id)
            ->where('id', $request->input('id'))
            ->firstOrFail();
        return view('teacher.course.show',['course'=>$course]);

    }


    public function subscribe(Request $request)
    {
        $student=Auth::user();
        StudentCourse::query()->create([
            'course_id'=>$request->id,
            'user_id'=>$student->id
        ]);
    }

}
