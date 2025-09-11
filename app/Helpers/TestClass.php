<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\Progress;
use App\Models\Skill;
use App\Models\SkillStudent;
use App\Models\Step;
use App\Models\StepStudent;
use App\Models\StudentCourse;
use App\Models\Test;
use App\Models\TestStudent;
use App\Models\Variant;
use App\Models\VariantTrue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TestClass
{
    public function test0($request)
   {

           $tests = Test::query()
               ->where('step_id', $request->id)
               ->with(['skill', 'variantss', 'lists1', 'lists2', 'corrects'])
               ->get();

           $i = 0;
           $answer = $request->answer;
           $ok = '1';
           $colum = 0;

           foreach ($tests as $test) {
               $ok = '1';

               if (!isset($answer[$i]['answer'])) {
                   $i++;
                   $test->verdict = $ok;
                   $test->save();
                   continue;
               }

               if ($test->type_test == "one_correct" || $test->type_test == "true_false") {
                   if (isset($test->corrects[0]) && $test->corrects[0]->true == $answer[$i]['answer']) {
                       if ($test->skill) {
                           $test->skill->score += $test->score;
                       }
                       $ok = '2';
                   }
               }

               else if ($test->type_test == "list_correct") {
                   $test_correct = $test->corrects;
                   $answerList = is_array($answer[$i]['answer']) ? $answer[$i]['answer'] : [];

                   foreach ($test_correct as $list) {
                       foreach ($answerList as $list1) {
                           if ($list->true == $list1) {
                               if ($test->skill) {
                                   $test->skill->score += $test->score / count($test_correct);
                               }
                               $ok = '2';
                               break;
                           }
                       }
                   }
               }

               else if ($test->type_test == "matching") {
                   $correctList = $test->lists2->pluck('str')->toArray();
                   if ($answer[$i]['answer'] == $correctList) {
                       if ($test->skill) {
                           $test->skill->score += $test->score;
                       }
                       $ok = '2';
                   }
               }

               else if ($test->type_test == "question_answer") {
                   $req = strtolower(preg_replace('/\s+/', '', $answer[$i]['answer']));
                   $correctAnswer = strtolower(preg_replace('/\s+/', '', $test->corrects[0]->true));
                   if (!empty($req) && $req === $correctAnswer) {
                       if ($test->skill) {
                           $test->skill->score += $test->score;
                       }
                       $ok = '2';
                   }
               }

               if ($ok === '2') {
                   $colum += $test->score;
               }

               $test->verdict = $ok;
               $test->save();

               if ($test->skill) {
                   $test->skill->save();
               }

               $i++;
           }

           Step::where('id', $request->id)->update(['status' => '1']);

           $progress = Progress::query()
               ->where('course_id', $course_id ?? null)
               ->whereDate('date', Carbon::now())
               ->first();

           if ($progress) {
               $progress->colum += $colum;
               $progress->save();
           } else {
               Progress::query()->create([
                   'course_id' => $course_id ?? null,
                   'date' => Carbon::now(),
                   'colum' => $colum,
               ]);
           }

           return $tests;


   }
    public function test1($request)
    {
        $tests = Test::query()
            ->where('step_id', $request->id)
            ->with(['skill', 'variantss', 'lists1', 'lists2', 'corrects'])
            ->get();

        $i = 0;
        $answer = $request->answer;
        $ok = '1';
        $colum = 0;
        $user = Auth::user();
        $course_id = Step::find($request->id)->course_id ?? null;

        foreach ($tests as $test) {
            $ok = '1';

            $tskill = SkillStudent::firstOrCreate(
                [
                    'skill_id' => $test->skill->id,
                    'user_id' => $user->id,
                ],
                [
                    'course_id' => $course_id,
                    'score' => 0
                ]
            );


            if (!isset($answer[$i]['answer'])) {
                TestStudent::query()->create([
                    'step_id'=>$test->step_id,
                    'test_id' => $test->id,
                    'user_id' => $user->id,
                    'verdict' => $ok
                ]);
                $i++;
                continue;
            }

            if ($test->type_test === "one_correct" || $test->type_test === "true_false") {
                if (isset($test->corrects[0]) && $test->corrects[0]->true == $answer[$i]['answer']) {
                    $tskill->score += $test->score;
                    $ok = '2';
                }
            }

            elseif ($test->type_test === "list_correct") {
                $test_correct = $test->corrects;
                $answerList = is_array($answer[$i]['answer']) ? $answer[$i]['answer'] : [];

                foreach ($test_correct as $list) {
                    foreach ($answerList as $list1) {
                        if ($list->true == $list1) {
                            $tskill->score += $test->score / count($test_correct);
                            $ok = '2';
                            break 2;
                        }
                    }
                }
            }

            elseif ($test->type_test === "matching") {
                $correctList = $test->lists2->pluck('str')->toArray();
                if ($answer[$i]['answer'] == $correctList) {
                    $tskill->score += $test->score;
                    $ok = '2';
                }
            }

            elseif ($test->type_test === "question_answer") {
                $req = strtolower(preg_replace('/\s+/', '', $answer[$i]['answer']));
                $correctAnswer = strtolower(preg_replace('/\s+/', '', $test->corrects[0]->true));
                if (!empty($req) && $req === $correctAnswer) {
                    $tskill->score += $test->score;
                    $ok = '2';
                }
            }

            if ($ok === '2') {
                $colum += $test->score;
            }

            TestStudent::query()->create([
                'step_id'=>$test->step_id,
                'test_id' => $test->id,
                'user_id' => $user->id,
                'ex'=>$colum,
                'verdict' => $ok
            ]);

            $tskill->save();
            $i++;
        }
        $step = StepStudent::firstOrCreate(
            ['step_id' => $request->id, 'user_id' => $user->id],
            [
                'ex' => $tskill->score,
                'course_id' => $course_id,
                'status' => '1',
            ]
        );


        $progress = Progress::query()->firstOrNew([
            'user_id'   => $user->id,
            'course_id' => $course_id ?? null,
            'date'      => Carbon::today(),
        ]);

        $progress->colum = ($progress->colum ?? 0) + $colum;
        $progress->save();

        StudentCourse::where('user_id', $user->id)
            ->where('course_id', $course_id)
            ->update([
                'exp' => \DB::raw("exp + {$colum}"),
                'complete' => \DB::raw("complete + 1")
            ]);


        GlobalMethods::course_cm($course_id,$user->id);

return response()->json(['l'=>$course_id,'p'=>$user->id]);
    }



    public function fd()
    {

    }


}
