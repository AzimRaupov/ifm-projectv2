<?php

namespace App\Http\Controllers\teacher;

use App\Helpers\TeacherHelpers;
use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Step;
use App\Models\VocabularyStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VocabularyController extends Controller
{
    public function edit(Request $request)
    {
        $step=Step::query()->where('id',$request->id)->with(['test','course','vocabularies'=>function ($q) {
            $q->with('links');
        }])->first();
       return view('teacher.vocabulary.editv2',['step'=>$step,'request'=>$request]);
    }
    public function generate(Request $request)
    {


        $user=Auth::user();
        $step=Step::query()->where('id',$request->input('id'))->with(['course','vocabularies'])->first();

        $result=TeacherHelpers::generateVocabulary($step,$request,$user);
        $v=VocabularyStep::query()->create([
            'step_id'=>$step->id,
            'course_id'=>$step->course_id,
            'title'=>$result['title'],
            'text'=>$result['info'],
            'exp'=>$result['exp'],
        ]);
        foreach ($result['links'] as $link){
            Link::query()->create([
                'vocabulary_step_id'=>$v->id,
                'link'=>$link
            ]);
        }
        return response($v,200);

    }
    public function update(Request $request)
    {
        $vocabulary=VocabularyStep::query()->where('id',$request->id)->with('links')->first();
        $vocabulary->title=$request->title;
        $vocabulary->text=$request->content;
        $vocabulary->links()->delete();
        foreach ($request->links as $link){
            if($link) {
                Link::query()->create([
                    'vocabulary_step_id' => $vocabulary->id,
                    'link' => $link
                ]);
            }
        }
        $vocabulary->save();
        return response(['success' => true]);

    }

    public function img(Request $request)
    {
        if ($request->hasFile('file')) {
            // Сохраняем файл в storage/app/public/uploads
            $path = $request->file('file')->store('uploads', 'public');

            // Получаем публичный URL

            $url = Storage::url($path); // → /storage/uploads/filename.jpg
            $url=asset($url);
            return response()->json(['location' => $url]);
        }

        return response()->json(['error' => 'Файл не найден'], 400);
    }

}
