<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\GetController;
use App\Models\Course;
use App\Models\Step;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use App\Helpers\GenerateRodmap;
class TestController extends Controller
{
    function check(Request $request)
    {
        $tests=Test::query()->where('step_id',$request->id)->with('skill')->get();
        $i=0;

        $answer=$request->answer;
        $ok='1';
        foreach ($tests as $test){
            $ok='1';
            if (!isset($answer[$i]['answer'])) {
                $i++;
                $test->verdict = $ok;
                $test->save();

                continue;
            }
            if($test->type_test=="one_correct" || $test->type_test=="true_false") {
                if ($test->correct == $answer[$i]['answer']) {

                    $test->skill->score += $test->score;
                    $ok = '2';
                }
            }
            else if($test->type_test=="list_correct"){
                $test_correct=$test->correct;

                foreach ($test_correct as $list){
                    foreach ($answer[$i]['answer'] as $list1){
                        if($list==$list1){
                            $test->skill->score+=$test->score/count($test_correct);
                            $ok='2';

                            break;
                        }
                    }
                }
            }
            else if($test->type_test=="matching" && $answer[$i]['answer']==$test->list2){
                $test->skill->score+=$test->score;
                $ok='2';
            }
            else if($test->type_test=="question_answer"){
                $req = strtolower(preg_replace('/\s+/', '', $answer[$i]['answer']));
                $correctAnswer = strtolower(preg_replace('/\s+/', '', $test->correct));
                if (!empty($req) && $req === $correctAnswer) {
                    $test->skill->score += $test->score;
                    $ok = '2';
                }

            }
            $test->verdict=$ok;
            $test->save();
            $test->skill->save();;
            $i++;
        }
        $step=Step::where('id',$request->id)->update(['status'=>'1']);
        return $tests;
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
        {   $step=Step::query()->where('id',$request->id)->first();
            $test=Test::query()->where('step_id',$request->id)->where('view',0)->get();

            if($step->status==1){
                return view('test.verdict',compact(['test','request']));
            }
            foreach ($test as $item){
                if($item->type_test=="matching"){
                    $item->list2 = collect($item->list2)->shuffle()->all();
                }
            }
            return view('test.show2',compact(['test','request']));
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
