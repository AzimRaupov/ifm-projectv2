<?php

namespace App\Http\Controllers\api\create;

use App\Helpers\GenerateRodmap;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCourseRequest;
use App\Jobs\DownloadLogoJob;
use App\Jobs\GenerateGptTest;
use App\Jobs\GenerateGptVocabulary;
use App\Jobs\GenerateTestJob;
use App\Jobs\GenerateVocabularyJob;
use App\Models\Course;
use App\Models\Link;
use App\Models\Skill;
use App\Models\Step;
use App\Models\StepHeir;
use App\Models\StudentCourse;
use App\Models\Test;
use App\Models\VocabularyStep;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orhanerday\OpenAi\OpenAi;

class CreateController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            // Сохраняем файл в storage/app/public/uploads
            $path = $request->file('file')->store($request->dir, 'public');

            // Получаем публичный URL

            $url = Storage::url($path); // → /storage/uploads/filename.jpg
            $url=asset($url);
            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'Файл не найден'], 400);
    }

    public function pdf(Request $request)
    {
        $course=Course::query()->where('id',$request->id)->with(['steps'=>function ($q) {
            $q->with('vocabularies');
        }])->first();
//        dd($course);



        $html = view('course.pdf', ['course'=>$course])->render();

        $pdf = Pdf::loadHTML($html);

        return $pdf->download(Str::slug($course->topic) . '.pdf');
    }
    function course(CreateCourseRequest $request)
    {
        $user=Auth::user();
        $date_start=Carbon::today();
        $map=GenerateRodmap::generateDescriptionn($request,$user);
        $data=$map["map"];

        $course=Course::query()->create([
            'user_id'=>$user->id,
            'topic'=>$map['topic_course'],
            'type'=>'private',
            'step'=>count($data),
            'freetime'=>$request->input('freetime'),
            'level'=>$request->input('level'),
            'date_start'=>$date_start
        ]);
        dispatch(new DownloadLogoJob((object)['id' => $course->id]));

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
        foreach ($data as $index=>$list){
            $course->increment('ex',$list['experience']);
            if($list['type']=='parent'){
                $create=[
                    'parent_id'=>null,
                    'course_id'=>$course->id,
                    'title'=>$list['topic'],
                    'experience'=>$list['experience'],
                    'type'=>$list['type'],
                    'heirs' => isset($list['heirs']) ? json_encode($list['heirs']) : null,
                    'sort'=>$index

                ];
                $st=Step::query()->create($create);
            }
            if($list['type']=='heir'){

                Step::query()->create([
                    'parent_id'=>$st->id,
                    'course_id'=>$course->id,
                    'title'=>$list['topic'],
                    'experience'=>$list['experience'],
                    'type'=>$list['type'],
                    'heirs' => isset($list['heirs']) ? json_encode($list['heirs']) : null,
                    'sort'=>$index

                ]);
            }

        }
        StudentCourse::query()->create([
            'user_id'=>$user->id,
            'course_id'=>$course->id
        ]);
        return response()->json([
            'redirect_url' => route('show', ['id' => $course->id])
        ]);
    }
    function test(Request $request)
    {
    $step=Step::query()->where('id',$request->input('id'))->with(['test','course'])->first();

    if(!isset($step->test[0]->id)) {
        $skills = Skill::query()->select(['id','skill'])->where('course_id', $step->course_id)->get();


        GenerateGptTest::dispatch($step->id, json_encode($skills));

    }

        return response()->json(['status'=>'ok']);


    }
    function vocabulary(Request $request)
    {
        $step=Step::query()->where('id',$request->input('id'))->with(['course','vocabularies'])->first();
        if($step->vocabularies->isEmpty()){

//        $response=GenerateRodmap::generateVocabulary($step);
//        $vocabulary=[];
//        $links=[];
//
//        $res=[];
//        foreach ($response as $item){
//             $vocabulary=VocabularyStep::query()->create([
//                 'step_id'=>$step->id,
//                 'title'=>$item['title'],
//                 'text'=>$item['info']
//             ]);
//             if(isset($item['links'])){
//                 foreach ($item['links'] as $link) {
//                     $links[]=[
//                         'vocabulary_step_id'=>$vocabulary->id,
//                         'link'=>$link,
//                         'step_id'=>null
//                     ];
//                 }
//             }
//        }
//        Link::insert($links);
//            $step->load('vocabularies.links');
            GenerateGptVocabulary::dispatch($request->input('id'));
            return  response()->json(['status'=>'ok']);
        }


            return  response()->json(['status'=>'ok']);


    }
    function create_description(Request $request)
    {
        // Найти шаг с его курсом и ссылками по ID
        $step = Step::query()->where('id', $request->input('id'))->with(['course', 'links'])->first();

        // Если шаг не найден, возвращаем ошибку
        if (!$step) {
            return response()->json(['error' => 'Step not found'], 404);
        }

        // Если описание шага ещё не создано
        if (!$step->description) {
            // Генерация описания через метод GenerateRodmap
            $data = GenerateRodmap::generateDescription($step);

            // Создание массива для вставки ссылок
            $create_link = [];
            foreach ($data['info']['links'] as $link) {
                $create_link[] = [
                    'vocabulary_step_id' =>null,
                    'step_id' => $step->id,
                    'link' => $link
                ];
            }

            // Вставляем ссылки в базу данных
            $l = Link::query()->insert($create_link);

            // Сохраняем описание шага
            $step->description = $data['info']['description'];

            // Сохраняем изменения в модели Step
            $step->save(); // Используем save() вместо update()
            $step = Step::query()->where('id', $request->input('id'))->with(['course', 'links'])->first();
            // Возвращаем успешный ответ с данными
            return response()->json([
                'description' => $step->description,
                'links' => $step->links,
                'data' => $data,
                'create_link' => $create_link,
                'l' => $l
            ]);
        }

        // Если описание уже существует, просто возвращаем его
        return response()->json([
            'description' => $step->description,
            'links' => $step->links
        ]);
    }


    public function c_test(Request $request)
    {
        $step=Step::query()->where('id',$request->input('id'))->with(['test','course'])->first();

        if(!isset($step->test[0]->id)) {
            $skills = Skill::query()->select(['id', 'skill'])->where('course_id', $step->course_id)->get();
              $d=GenerateRodmap::generateTests($step,$skills);
dd($d);
        }

    }



}
