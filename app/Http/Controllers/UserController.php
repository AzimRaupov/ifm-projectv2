<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function google_auth()
    {
        return Socialite::driver('google')->redirect();

    }
    public function google_callback()
    {
        $userGoogle=Socialite::driver('google')->user();
           $user=User::query()->where('google_id',$userGoogle->id)->first();

           if(!$user){
               $user=User::query()->where('email',$userGoogle->email)->first();
$user->google_id=$userGoogle->id;
$user->save();
               return redirect()->route($user->role.'.dashboard');

           }
           else{
               Auth::login($user);
           }

           return redirect()->route($user->role.'.dashboard');
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $courses_student=StudentCourse::query()->where('user_id', $user->id)->pluck('id');
        $courses=Course::query()->whereIn('id',$courses_student)->with(['steps',
            'progress'=>function ($q) use ($user) {
               $q->where('user_id',$user->id);
            }
            ]
        )->get();
         foreach ($courses as $course) {
            $complete = 0;
            $sr=0;
            $ps=0;
            $i=0;
            foreach ($course->steps as $step) {
                if ($step->status==1) {
                    $complete += $step->experience;
                }
            }
            if($course->progress){
                foreach ($course->progress as $list) {
                    if ($i<count($course->progress)-1) {
                        $sr+=$list->colum;
                    } else {
                        $ps+=$list->colum;
                    }
                    $i++;
                }
                $course->sr=count($course->progress)-1>0?($sr/(count($course->progress)-1)):0;
                $course->ps=$ps;
                if ($course->sr!= 0){
                    $course->pr=round((($ps-$course->sr)/$course->sr)*100,1);
                }
                else{
                    $course->pr=0;
                }
            }
            $course->complete=$complete;
        }
        return view('student.dashboard', ['courses' => $courses]);

    }

    public function profile_settings()
    {
        $user=Auth::user();

        return view('user.profile');


    }
    public function profile(Request $request)
    {

        $user=User::query()->find($request->id);
        return view('user.public_profile',compact('user'));

    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'lang' => 'required|in:tj,ru,en',
            'type_user' => 'required|in:schoolboy,student,worker',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->leng = $request->input('lang');
        $user->user_type = $request->input('type_user');
        $user->save();

   return redirect()->back();
    }

}
