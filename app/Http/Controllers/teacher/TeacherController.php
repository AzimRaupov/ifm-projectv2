<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $user=Auth::user();
        $courses=TeacherCourse::query()->where('user_id',$user->id)->with('course')->get();
        return view('teacher.dashboard',['courses'=>$courses]);
    }
}
