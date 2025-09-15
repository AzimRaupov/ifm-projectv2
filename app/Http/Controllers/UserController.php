<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\User;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use function Pest\Laravel\freezeTime;

class UserController extends Controller
{
    public function google_auth()
    {
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function google_callback()
    {
        $userGoogle=Socialite::driver('google')->user();
           $user=User::query()->where('google_id',$userGoogle->id)->first();

           if(!$user){
               $user=User::query()->where('email',$userGoogle->email)->first();
$user->google_id=$userGoogle->id;
$user->save();
               return redirect()->route('dashboard');

           }
           else{
               Auth::login($user);
           }

           return redirect()->route('dashboard');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

       if($user->role=="student"){
           $courses_student=StudentCourse::query()->where('user_id', $user->id)->get();

           $courses=Course::query()->whereIn('id',$courses_student->pluck('course_id'))->with(['steps',
                   'progress'=>function ($q) use ($user) {
                       $q->where('user_id',$user->id);
                   }
               ]
           )->get();
           foreach ($courses as $course) {
               $course->complete = 0;
               $course->sr = 0;
               $course->ps = 0;
               $course->pr = 0;

               // Найти студента для данного курса
               $student_course = collect($courses_student)->firstWhere('course_id', $course->id);

               if ($student_course && count($course->steps) > 0) {
                   $course->complete = round(($student_course->complete / $course->step) * 100, 2);
               }

               if (!empty($course->progress)) {
                   $sr = 0;
                   $ps = 0;
                   $count_progress = count($course->progress);

                   foreach ($course->progress as $i => $list) {
                       if ($i < $count_progress - 1) {
                           $sr += $list->colum;
                       } else {
                           $ps += $list->colum;
                       }
                   }

                   $course->sr = ($count_progress - 1) > 0 ? ($sr / ($count_progress - 1)) : 0;
                   $course->ps = $ps;
                   $course->pr = $course->sr != 0 ? round((($ps - $course->sr) / $course->sr) * 100, 1) : 0;
               }
           }
           return view('student.dashboard', ['courses' => $courses]);
       }

       elseif ($user->role=="teacher"){
           $courses = Course::query()->where('user_id', $user->id)->with('students')->get();

           $totalStudents = 0;
           $totalCertificate = 0;
           $students_t = collect();
           $ff=0;
           foreach ($courses as $course) {
               foreach ($course->students as $student) {
                   if ($student->pivot->status == 1) {
                       $totalCertificate++;
                   }
                   $student->name_course=$course->topic;
                   $student->step_course=$course->step;
                   $students_t->push($student); // сохраняет pivot
               }
               $ff=$totalCertificate;
               $course->certificate=$ff;
               $ff=0;

           }
//           dd($courses, $totalStudents, $totalCertificate);
           return view('teacher.dashboard',[
               'courses'=>$courses,
               'totalStudents'=>$totalStudents,
               'totalCertificate'=>$totalCertificate,
               'students'=>$students_t
               ]);
       }
    }

    public function profile_settings()
    {
        $user=Auth::user();
        if($user->role=='student') {
            return view('user.profile', ['user' => $user]);
        }
        elseif($user->role=="teacher"){
            return view('teacher.account.settings', ['user' => $user]);
        }

    }

    public function profile(Request $request)
    {

        $user=User::query()->with('courses')->find($request->id);
        if($user->role=="student") {
//        dd($user);
            return view('user.public_profile', compact('user'));
        }
        elseif($user->role=="teacher"){
            return view('teacher.account.public_profile', compact('user'));
        }
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
