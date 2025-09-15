<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\StudentCourse;
use App\Models\Vocabulary_Student;
use App\Models\VocabularyStep;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    function show(Request $request)
    {
        $vocabularies = VocabularyStep::where('step_id', $request->id)
        ->with('links')
        ->get();
        if(count($vocabularies)==0){
            return view('vocabolary.show',compact('vocabularies','request'));

        }
        $statuses = Vocabulary_Student::where('step_id', $request->id)
            ->where('user_id', Auth::id()) // 👈 чтобы статус был только текущего юзера
            ->pluck('status', 'vocabulary_id') // [vocabulary_id => status]
            ->toArray();
        foreach ($vocabularies as $voc) {
            if(isset($statuses[$voc->id])){
                $voc->status=$statuses[$voc->id];
            }
        }
        return view('vocabolary.show',compact('vocabularies','request'));
    }
    public function rd(Request $request)
    {

        $user = Auth::user();
        $voc = VocabularyStep::findOrFail($request->id);
        $studentStep = Vocabulary_Student::where('user_id', $user->id)
            ->where('vocabulary_id', $voc->id)
            ->first();
        if (!$studentStep) {
            Vocabulary_Student::create([
                'user_id'       => $user->id,
                'step_id'       => $voc->step_id,
                'vocabulary_id' => $voc->id,
                'status'        => '1',
            ]);

            StudentCourse::where('user_id', $user->id)
                ->where('course_id', $voc->course_id)
                ->increment('exp', $voc->exp);

            $progress = Progress::query()->firstOrNew([
                'user_id'   => $user->id,
                'course_id' => $voc->course_id ?? null,
                'date'      => Carbon::today(),
            ]);
            $progress->colum = ($progress->colum ?? 0) + $voc->exp;
            $progress->save();
            return response()->json([
                'status' => 'ok',
                'exp_added' => $voc->exp,
                'new' => true,
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'exp_added' => 0,
            'new' => false,
        ]);
    }

}
