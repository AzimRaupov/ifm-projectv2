<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\StudentCourse;

class GlobalMethods
{
    static public function course_cm($course_id,$user_id)
    {
        $student_course=StudentCourse::query()->where('course_id',$course_id)
            ->where('user_id',$user_id)->first();
        $course=Course::find($course_id);

        if($course->step==$student_course->complete){
            $student_course->status=1;
            $student_course->save();
        }

    }
}
