<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class SystemController extends Controller
{

    public function home(Request $request)
    {

        $teacher_count=0;
        $student_count=0;

        $courses=Course::query()->with(['teacher'])->where('type','public')->take(4)->get();
        $teachers = User::query()
            ->where('role', 'teacher')
            ->take(4)
            ->get();
return view('welcome',['courses'=>$courses,'teachers'=>$teachers]);


    }


}
