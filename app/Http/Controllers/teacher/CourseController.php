<?php

namespace App\Http\Controllers\teacher;

use App\Helpers\GenerateRodmap;
use App\Helpers\TestClass;
use App\Http\Controllers\Controller;
use App\Jobs\DownloadLogoJob;
use App\Models\Course;
use App\Models\MatchingList1;
use App\Models\MatchingList2;
use App\Models\Skill;
use App\Models\Step;
use App\Models\StudentCourse;
use App\Models\TeacherCourse;
use App\Models\Test;
use App\Models\User;
use App\Models\Variant;
use App\Models\VariantTrue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{

    public function update(Request $request)
    {
        $user = Auth::user();

        $course=Course::query()->with('skills')->find($request->id);
        if($request->hasFile('logo-course')){
            $path=$request->file('logo-course')->store('course/logo','public');
            $course->logo=$path;
        }
        if($request->input('topic')){
            $course->topic=$request->input('topic');
        }
        foreach ($request->skills as $index => $skill) {
            if (isset($course->skills[$index])) {
                $existingSkill = $course->skills[$index];

                if(strlen($skill)>0){
                $existingSkill->skill = $skill;
                    $existingSkill->save();

                }
                else{
                    $existingSkill->delete();
                }

            } elseif($skill) {
                Skill::query()->create([
                    'course_id' => $course->id,
                    'user_id'   => $user->id,
                    'skill'     => $skill,
                ]);
            }
        }
       if($request->input('description')){
           $course->description=$request->description;
       }
        $course->save();
        return response()->json([ 'success' => true,'re'=>$request->all()],200);
    }
    public function index($id)
    {
        $user=Auth::user();
        $course=Course::query()->where('id',$id)->with(['students'=>function ($q) {
            $q->orderBy(DB::raw('exp + complete'), 'desc');
        }])
            ->first();
        $certificate = $course->students->where('pivot.status', 1)->count();

        $progressByMonth = DB::table('progress')
            ->select(
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(colum) as total')
            )
            ->where('course_id', $course->id)
            ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('teacher.course.dashboard',['course'=>$course,'certificate'=>$certificate,'progressByMonth'=>$progressByMonth]);

    }
    public function create()
    {
        return view('teacher.course.create');
    }
    public function store(Request $request)
    {
        $user=Auth::user();
        $date_start=Carbon::today();
        $map=GenerateRodmap::generateDescriptionn($request,$user);
        $data=$map["map"];

        $course=Course::query()->create([
            'user_id'=>$user->id,
            'topic'=>$map['topic_course'],
            'type'=>'public',
            'step'=>count($data),
            'freetime'=>$request->input('freetime'),
            'level'=>$request->input('level'),
            'date_start'=>$date_start
        ]);
        dispatch(new DownloadLogoJob((object)['id' => $course->id]));

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

        foreach ($data as $index=>$list){

            if($list['type']=='parent'){
                $create=[
                    'parent_id'=>null,
                    'course_id'=>$course->id,
                    'title'=>$list['topic'],
                    'experience'=>$list['experience'],
                    'type'=>$list['type'],
                    'heirs' => isset($list['heirs']) ? json_encode($list['heirs']) : null,
                    'sort'=>$index
                ];
                $st=Step::query()->create($create);
            }
            if($list['type']=='heir'){

                Step::query()->create([
                    'parent_id'=>$st->id,
                    'course_id'=>$course->id,
                    'title'=>$list['topic'],
                    'experience'=>$list['experience'],
                    'type'=>$list['type'],
                    'heirs' => isset($list['heirs']) ? json_encode($list['heirs']) : null,
                    'sort'=>$index
                ]);
            }

        }
        return response()->json([
            'redirect_url' => route('teacher.course.show', ['id' => $course->id])
        ]);
    }

    public function gen(Request $request,TestClass $testClass){
        $testClass->one_correct($request,"");
    }

    public function show(Request $request)
    {
        $user=Auth::user();
        $course = Course::query()->where('user_id', $user->id)
            ->where('id', $request->input('id'))
            ->firstOrFail();
        return view('teacher.course.show',['course'=>$course]);

    }
public function edit(Request $request)
{
    $user=Auth::user();
    $course=Course::query()->where('type','public')->
        where('user_id',$user->id)->
        where('id',$request->id)->
        with(['steps','skills'])->
        first();

        return view('teacher.course.edit',['course'=>$course]);
}

    public function subscribe(Request $request)
    {
        $student = Auth::user();
        $course = Course::find($request->id);
        if (!$course) {
            return redirect()->route('courses.index')->with('error', 'Курс не найден.');
        }

        $existingSubscription = StudentCourse::where('course_id', $course->id)
            ->where('user_id', $student->id)
            ->exists();

        if ($existingSubscription) {
            return redirect()->route('show', ['id' => $course->id])
                ->with('info', 'Вы уже подписаны на этот курс.');
        }

        StudentCourse::create([
            'course_id' => $course->id,
            'user_id' => $student->id
        ]);

        return redirect()->route('show', ['id' => $course->id])
            ->with('success', 'Вы успешно подписались на курс!');
    }

}
