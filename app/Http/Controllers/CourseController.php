<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Models\Course;
use App\Models\Step;
use App\Models\StudentCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GenerateRodmap;
use Illuminate\Support\Str;
use function Pest\Laravel\json;
use setasign\Fpdi\Fpdi;
use tFPDF;
class CourseController extends Controller
{


    public function tutorial()
    {
        return view('course.tutorial');
    }
    public function certificate(Request $request)
    {

        $user=Auth::user();
        $course=Course::with('skills')->find($request->id);
        $course_s=StudentCourse::query()->where('user_id',$user->id)->where('course_id',$course->id)->first();
        return view('course.certificate.template2',['user'=>$user,'course'=>$course,'course_s'=>$course_s]);

    }
    public function index()
    {
return view('course.index');
    }

    public function create()
    {
        return view('course.create');
    }

    public function store(CreateCourseRequest $request)
    {
       $user=Auth::user();
        $date_start=Carbon::today();
      $map=GenerateRodmap::generateDescriptionn($request,$user);
      dd($map);

    }
function progress(Request $request)
{
    $complete=0;
    $course = Course::where('id', $request->id)
        ->with([
            'skills',
            'steps',
            'step_student'=>function ($q) {
                $q->where('status','1');
            }
        ])
        ->first();
    $complete=count($course->step_student);
    $complete = count($course->steps) > 0 ? round(($complete / count($course->steps)) * 100, 2) : 0;
    return view('course.progress',compact(['course','complete']));

}

 public function pdf_book(Request $request)
 {
     $course=Course::query()->where('id',$request->id)->with(['steps'=>function ($q) {
         $q->with('vocabularies');
     }])->first();
//        dd($course);



     $html = view('course.pdf', ['course'=>$course])->render();

     $pdf = Pdf::loadHTML($html);

     return $pdf->download(Str::slug($course->topic) . '.pdf');
 }
    public function show(Request $request)
    {
        $user=Auth::user();
        $course = Course::query()
            ->where('id', $request->input('id'))
            ->firstOrFail();
        $student_course=StudentCourse::query()->where('user_id',$user->id)->where('course_id',$course->id)->first();

            return view('course.show_rodmap',compact('course','student_course'));


    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
