<?php

namespace App\Http\Controllers\teacher;

use App\Helpers\GenerateRodmap;
use App\Http\Controllers\Controller;
use App\Jobs\DownloadLogoJob;
use App\Models\Course;
use App\Models\Skill;
use App\Models\Step;
use App\Models\TeacherCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function create()
    {
        return view('teacher.course.create');
    }
    public function store(Request $request)
    {
        $user=Auth::user();
        $date_start=Carbon::today();
        $map=GenerateRodmap::generateRodmap($request,$user);

        $course=Course::query()->create([
            'user_id'=>$user->id,
            'topic'=>$map['topic_course'],
            'freetime'=>$request->input('freetime'),
            'level'=>$request->input('level'),
            'date_start'=>$date_start
        ]);
        dispatch(new DownloadLogoJob((object)['id' => $course->id]));

        $data=$map["map"];
        $skills=[];
        foreach ($map['skills'] as $list){
            $skills[] = [
                'skill' => $list,
                'course_id' => $course->id,
                'user_id' => $user->id,
            ];
        }
        Skill::insert($skills);
        $create=[];
        foreach ($data as $list){
            $create[]=[
                'course_id'=>$course->id,
                'title'=>$list['topic'],
                'experience'=>$list['experience'],
                'type'=>$list['type'],
                'heirs' => isset($list['heirs']) ? json_encode($list['heirs']) : null
            ];
        }
        Step::insert($create);
        return response()->json([
            'redirect_url' => route('teacher.course.show', ['id' => $course->id])
        ]);
    }
    public function show(Request $request)
    {
        $user=Auth::user();
        $course = Course::query()->where('user_id', $user->id)
            ->where('id', $request->input('id'))
            ->firstOrFail();
        return view('teacher.course.show',['course'=>$course]);

    }
}
