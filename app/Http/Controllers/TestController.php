<?php

namespace App\Http\Controllers;

use App\Helpers\TestClass;
use App\Http\Controllers\api\GetController;
use App\Models\Course;
use App\Models\Progress;
use App\Models\Step;
use App\Models\StepStudent;
use App\Models\Test;
use App\Models\TestStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use App\Helpers\GenerateRodmap;
class TestController extends Controller
{
    function check(Request $request,TestClass $testClass)
    {
        $step=Step::query()->with('course')->where('id',$request->id)->first();


        return $testClass->test1($request);
    }
    function test(Request $request)
    {
        $user=Auth::user();
        $course=Course::query()->where('id',$request->input("id"))
            ->where('user_id',$user->id)->firstOrFail();
//        dd($course);

        $tests=GenerateRodmap::generateTests($course);

        $correct="";
        $variants="";
        foreach ($tests as $item) {
            $variants="NONe";
            $testType = key($item);
            $testData = $item[$testType];

            if($testType!="question_answer"){
              $variants=$testData["variants"];
            }
               Test::create([
                   'course_id'=>$request->input('id'),
                   'text'=>$testData['text'],
                   'type_test'=>$testType,
                   'variants'=>$variants,
                   'correct'=>$testData['correct'],
                   'score'=>$testData['score']
               ]);


        }
dd($tests);
        }
        function index($id)
          {
            return view('test.index');
            $user=Auth::user();
            $tests=Test::query()->where('course_id',$id)->firstOrFail();
            $course=Course::query()->where('id',$id)->
            where('user_id',$user->id)->firstOrFail();
            dd($tests,$course);
        }
        function result(Request $request)
        {
            $test = Test::where('id', $request->input('id'))
                ->firstOrFail();
            $course=Course::where('id',$test->course_id)
            ->firstOrFail();

            if(Auth::user()->id != $course->id){
                echo "eror";

            }

            else{
                $correct=$request->input('correct');
                $type_test=$test->type_test;

                if($type_test=="one_correct" && $correct==$test->correct){
                    $course->ex+=$test->score;

                }
                else if($type_test=="list_correct"){
                    $correct=[0,2];
                    $test_correct=$test->correct;

                    foreach ($test_correct as $list){
                        foreach ($correct as $list1){
                            if($list==$list1){
                                $course->ex+=$test->score/count($test_correct);
                                break;
                            }

                        }
                    }

                }

                $test->view=true;
                $test->update();
                $course->update();
            }
        }
        function show(Request $request)
        {

            $user=Auth::user();
            $step=Step::query()->where('id',$request->input('id'))->first();
            return view('test.show',compact('step'));

        }
        function show2(Request $request)
        {   $step=Step::query()->with('course')->where('id',$request->id)->first();
            $user=Auth::user();
            $tests=Test::query()->where('step_id',$request->id)->with('variantss','lists1','lists2','corrects')->where('view',0)->get();


                $step_student=StepStudent::query()->where('step_id',$step->id)->where('user_id',$user->id)->first();
                $verdict=TestStudent::query()->where('step_id',$step->id)->get();
                if(!$step_student){
                    return view('test.show2',compact(['tests','request']));
                }
                else if($step_student->status==1){
                    return view('test.verdict_type1',compact(['tests','request','verdict']));

                }


            return view('test.show2',compact(['tests','request']));
        }
        function send(Request $request)
        {
            $course = Course::find($request->id);
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->get('https://www.googleapis.com/customsearch/v1', [
                'key' => env('ggapi'),
                'cx' => env('cx'),
                'q' => "{$course->topic} logo",
                'searchType' => 'image',
                'num' => 1,
            ]);

            if ($response->successful() && isset($response['items'][0]['link'])) {
                $course->logo = $response['items'][0]['link'];
                $course->save();
                return $response['items'][0]['link'];
            }
        }
}
