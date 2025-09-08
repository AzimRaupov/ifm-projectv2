<?php

namespace App\Http\Controllers\api;

use App\Helpers\GlobalMethods;
use App\Http\Controllers\Controller;
use App\Models\Step;
use App\Models\StepStudent;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiStepController extends Controller
{
    public function statusEdit(Request $request)
    {
        $user = Auth::user();
        $step=Step::query()->find($request->id);

        if($request->status=='1'){
            StudentCourse::where('user_id', $user->id)
                ->where('course_id', $step->course_id)
                ->update([
                    'exp' => \DB::raw("exp + {$step->experience}"),
                    'complete' => \DB::raw("complete + 1")
                ]);
        }
        StepStudent::updateOrCreate(
            [
                'user_id' => $user->id,
                'step_id' => $request->id,
                'course_id'=>$step->course_id,
                'status'=>$request->status
            ],
            [
                'status' => $request->status
            ]
        );
        GlobalMethods::course_cm($step->course_id,$user->id);
        return response()->json($request->all(),200);
    }
}
