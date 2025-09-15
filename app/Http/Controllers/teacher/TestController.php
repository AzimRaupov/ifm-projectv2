<?php

namespace App\Http\Controllers\teacher;

use App\Helpers\TeacherHelpers;
use App\Http\Controllers\Controller;
use App\Models\Step;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function edit(Request $request)
    {
        $step=Step::query()->where('id',$request->id)->with(['test'])->first();
return view('teacher.test.edit',['step'=>$step,'request'=>$request]);
    }

    public function generate(Request $request)
    {

            $method=$request->type;
            $result=TeacherHelpers::$method($request);
        return response()->json(['success' => true], 200);

            }

}
