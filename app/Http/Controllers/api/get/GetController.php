<?php

namespace App\Http\Controllers\api\get;

use App\Helpers\GenerateRodmap;
use App\Helpers\GetTest;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Skill;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    function user_info()
    {
        $user=Auth::user();

        $course=Course::where('user_id', $user->id)->get();
        $score=Skill::query()->where('user_id',$user->id)->where('score','>',0)->pluck('score');

        $skills=Skill::query()->where('user_id',$user->id)->where('score','>',0)->pluck('skill');
        $data=[
            'user'=>$user,
            'courses'=>$course,
            'skills'=>[
                'title'=>$skills,
                'score'=>$score
            ]
        ];
        return response()->json($data);
    }
    function test($id)
    {
        $test=Test::query()->where('step_id',$id)->get();
        if(!$test->isEmpty()){

        foreach ($test as $index=>$item){
            if($item->view===0){
                return response()->json(['test'=>$item,'kl'=>$index+1,'status'=>'ok'],200);

            }
        }
        return response()->json(['status'=>'over'],200);
        }

    }
    function steps($id)
    {
        $course=Course::query()->where('id',$id)->
        with('steps')->firstOrFail();
        return response()->json($course->steps,200);
    }
}
