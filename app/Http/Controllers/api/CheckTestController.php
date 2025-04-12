<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTestController extends Controller
{
    function check(Request $request)
    {
        $ok=false;
        $user=Auth::user();
        $correct=$request->input('correct');
        $test=Test::query()->where('id',$request->input('test_id'))
            ->with('skill')
        ->first();

        if($test->type_test=="one_correct" || $test->type_test=="true_false") {
            if ($test->correct == $correct) {

                $test->skill->score += $test->score;
                $ok = true;
            }
        }
        else if($test->type_test=="list_correct"){
            $test_correct=$test->correct;

            foreach ($test_correct as $list){
                foreach ($correct as $list1){
                    if($list==$list1){
                        $test->skill->score+=$test->score/count($test_correct);
                        $ok=true;
                        break;
                    }
                }
            }

        }
        else if($test->type_test=="matching" && $correct==$test->list2){
            $test->skill->score=$test->score;
            $ok=true;
        }
        else if($test->type_test=="question_answer"){
            $req=strtolower(preg_replace('/\s+/', '', $correct));
            $answer=strtolower(preg_replace('/\s+/', '', $test->correct));
            if($req===$answer){
                $test->skill->score=$test->score;
                $ok=true;

            }

        }
            $test->view=1;
        $test->update();
            $test->skill->update();


        return response()->json(['response'=>$ok]);

    }
}
