<?php

namespace App\Http\Controllers;

use App\Models\StudentCourse;
use App\Models\Vocabulary_Student;
use App\Models\VocabularyStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    function show(Request $request)
    {
        $vocabularies = VocabularyStep::where('step_id', $request->id)
        ->with('links')
        ->get();

        // получаем статусы студента по словарям
        $statuses = Vocabulary_Student::where('step_id', $request->id)
            ->where('user_id', Auth::id()) // 👈 чтобы статус был только текущего юзера
            ->pluck('status', 'vocabulary_id') // [vocabulary_id => status]
            ->toArray();
        foreach ($vocabularies as $voc) {
            if(isset($statuses[$voc->id])){
                $voc->status=$statuses[$voc->id];
            }
        }
        return view('vocabolary.show',compact('vocabularies'));
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
