<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\json;

class StepController extends Controller
{

    public function new_parent(Request $request)
    {
          $step=Step::query()->create([
              'course_id'=>$request->id,
              'parent_id'=>null,
              'type'=>'parent',
              'title'=>$request->title,
              'experience'=>$request->experience,
              'status'=>0,
              'sort'=>0
          ]);
        return response(['status'=>1],200);

    }

    public function new_child(Request $request)
    {
        $step=Step::query()->where('id',$request->id)->with('step_heirs')->first();
        $t=Step::query()->create([
            'course_id'=>$step->course_id,
            'parent_id'=>$step->id,
            'type'=>'heir',
            'title'=>$request->title,
            'experience'=>$request->experience,
            'status'=>0,
            'sort'=>$step->sort+1
        ]);

        return response(['status'=>1],200);
    }

    public function sort(Request $request)
    {

        $steps = Step::whereIn('id', $request->list)
            ->orderBy('sort')
            ->get();
        foreach ($steps as $step){
            $p=0;
            for($i=0;$i<count($request->list);$i++){
                if($step->id==$request->list[$i]){
                    $step->sort=$i;
                    $step->save();
                    break;
                }
            }
        }
        return $steps;

    }
    public function update(Request $request)
    {
     $step=Step::query()->where('id',$request->id)->with(['links'])->first();
     $step->description=$request->content;
     $step->title=$request->topic;
     $step->save();
     $step->links()->delete();
        foreach ($request->links as $link){
            if($link) {
                Link::query()->create([
                    'step_id' => $step->id,
                    'link' => $link
                ]);
            }
        }
        return response(['status'=>1],200);
      }
    public function edit(Request $request)
    {
        $step=Step::query()->where('id',$request->id)->with(['test','course','vocabularies'])->first();
//        dd($step);
     return view('teacher.course.edit',['step'=>$step]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $step = Step::with('course')->find($request->id);

        if (!$step) {
            return response(['status' => 0, 'message' => 'Step not found'], 404);
        }

        $course = $step->course;

        if ($course->type === "public" && $course->user_id === $user->id) {
            $step->delete();
            return response(['status' => 1], 200);
        }

        return response(['status' => 0, 'message' => 'Unauthorized or invalid course type'], 403);
    }
}
