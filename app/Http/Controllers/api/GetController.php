<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    function get()
    {
        $user=Auth::user();

        $course=Course::where('user_id', $user->id)->get();
        $data=[
            'user'=>$user,
            'courses'=>$course
        ];
       return response()->json($data);
    }
    function getmap($id)
    {
       $user=Auth::user();
        $course = Course::query()->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
       return response()->json($course,200);
    }
}
