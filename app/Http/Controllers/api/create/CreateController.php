<?php

namespace App\Http\Controllers\api\create;

use App\Helpers\GenerateRodmap;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCourseRequest;
use App\Models\Course;
use App\Models\Link;
use App\Models\Skill;
use App\Models\Step;
use App\Models\Test;
use App\Models\VocabularyStep;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Orhanerday\OpenAi\OpenAi;

class CreateController extends Controller
{
    function course(CreateCourseRequest $request)
    {
        $user=Auth::user();

        $date_start=Carbon::today();
        $map=GenerateRodmap::generateRodmap($request,$user);

        $course=Course::query()->create([
            'user_id'=>$user->id,
            'topic'=>$map['title'],
            'freetime'=>$request->input('freetime'),
            'date_start'=>$date_start
        ]);
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
            'redirect_url' => route('show', ['id' => $course->id])
        ]);
    }
    function test(Request $request)
    {
    $step=Step::query()->where('id',$request->input('id'))->with(['test','course'])->first();

    if(!isset($step->test[0]->id)) {
        $skills = Skill::query()->select(['id','skill'])->where('course_id', $step->course_id)->get();

        $tests = GenerateRodmap::generateTests($step,json_encode($skills));


    }

        return response()->json(['status'=>'ok']);


    }
    function vocabulary(Request $request)
    {
        $step=Step::query()->where('id',$request->input('id'))->with(['course','vocabularies'])->first();
        if($step->vocabularies->isEmpty()){

        $response=GenerateRodmap::generateVocabulary($step);
        $vocabulary=[];
        $links=[];

        $res=[];
        foreach ($response as $item){
             $vocabulary=VocabularyStep::query()->create([
                 'step_id'=>$step->id,
                 'title'=>$item['title'],
                 'text'=>$item['info']
             ]);
             if(isset($item['links'])){
                 foreach ($item['links'] as $link) {
                     $links[]=[
                         'vocabulary_step_id'=>$vocabulary->id,
                         'link'=>$link,
                         'step_id'=>null
                     ];
                 }
             }
        }
        Link::insert($links);
            $step->load('vocabularies.links');

        }


            return  response()->json(['status'=>'ok']);


    }
    function create_description(Request $request)
    {

        $step=Step::query()->where('id',$request->input('id'))->with(['course'])->first();
        if(!$step->description){
        $data=GenerateRodmap::generateDescription($step);

        $create_link=[];
        foreach ($data['info']['links'] as $link){
            $create_link[]=[
                'step_id'=>$step->id,
                'link'=>$link
            ];
        }
        Link::query()->insert($create_link);
        $step->description=$data['info']['description'];
        $step->update();
        }

            return response()->json(['description'=>$step->description,'links'=>$step->links]);

    }

   public function c_test(Request $request)
    {         $user=Auth::user();
        $step=Step::query()->where('id',$request->input('id'))->with(['course','description'])->first();
        $data=GenerateRodmap::generateRodmap($request,$user);
        dd($data);
    }

}
