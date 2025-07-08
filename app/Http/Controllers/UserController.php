<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
               $userr=User::query()->where('email',$userGoogle->email)->first();
$userr->google_id=$userGoogle->id;
$userr->save();
               return redirect()->route($userr->role.'.dashboard');

           }
           else{
               Auth::login($user);
           }
           return redirect()->route($user->role.'.dashboard');
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $courses = Course::where('user_id', $user->id)->with(['steps','progress'])->get();

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
        return view('dashboard', ['courses' => $courses]);

    }

    public function profile()
    {
        $user=Auth::user();

        return view('user.profile');


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
