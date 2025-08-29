<?php

namespace App\Http\Controllers\api\get;

use App\Helpers\GenerateRodmap;
use App\Helpers\GetTest;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Skill;
use App\Models\SkillStudent;
use App\Models\Step;
use App\Models\StepStudent;
use App\Models\StudentCourse;
use App\Models\Test;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    function skills(Request $request)
    {
        $skills = Skill::where('course_id', $request->id)
            ->get(['id', 'skill', 'score']);


        $skillStudent = SkillStudent::where('course_id', $request->id)
            ->where('user_id', Auth::id())
            ->pluck('score', 'skill_id');

        foreach ($skills as $skill) {
            if (isset($skillStudent[$skill->id])) {
                $skill->score = $skillStudent[$skill->id];
            }
        }

        return response()->json([
            'skills' => $skills->pluck('skill')->values(),
            'data' => $skills->pluck('score')->values()
        ]);

    }
    function user_info()
    {
        $user=Auth::user();

        $course=Course::where('user_id', $user->id)->get();
        $score=Skill::query()->where('user_id',$user->id)->where('score','>',0)->pluck('score');

        $skills=Skill::query()->where('user_id',$user->id)->where('score','>',0)->pluck('skill');

        $studentCourseIds = StudentCourse::where('user_id', $user->id)->pluck('course_id');
        $studentCourses = Course::whereIn('id', $studentCourseIds)
            ->where('user_id', '!=', $user->id)
            ->get();
        $action = UserActivity::query()
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                // превращаем date в Carbon и получаем день недели (0 = воскресенье, 1 = понедельник ...)
                $item->weekday = \Carbon\Carbon::parse($item->date)->dayOfWeek;
                return $item;
            });

        $allCourses = $course->merge($studentCourses);
        $data=[
            'user'=>$user,
            'courses'=>$allCourses,
            'action'=>$action,
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
        $steps = Step::query()
            ->whereNull('parent_id')
            ->where('course_id', $id)
            ->with(['links','step_heirs'=>function ($q) {
                $q->with('links')->orderBy('sort');
            }])
            ->orderBy('sort')
            ->get();

        $stepStatuses = StepStudent::query()
            ->where('course_id', $id)
            ->pluck('status', 'step_id');

        foreach ($steps as $step) {
            $step->status = $stepStatuses[$step->id] ?? null;

            foreach ($step->step_heirs as $child) {
                $child->status = $stepStatuses[$child->id] ?? null;
            }
        }




        return response()->json($steps,200);
    }
    public function status_step(Request $request)
    {
        $step=Step::query()->find($request->input('id'));

        $step->status=$request->input('status');
         $step->save();
        return $step;
    }
}
