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
        $test=Test::query()->where('step_id',$id)->where('view',0)->first();

        return response()->json($test,200);

    }
    function steps($id)
    {
        $course=Course::query()->where('id',$id)->
        with('steps')->firstOrFail();
        return response()->json($course->steps,200);
    }
}
