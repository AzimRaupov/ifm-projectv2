<?php

namespace App\Http\Controllers;

use App\Models\VocabularyStep;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    function show(Request $request)
    {    $vocabularies=VocabularyStep::query()->where('step_id',$request->id)->with('links')->get();
         return view('vocabolary.show',compact('vocabularies'));
    }
    function rd(Request $request)
    {

        VocabularyStep::where('id',$request->id)->update(['status'=>'1']);
        return response()->json(['status'=>'ok'],200);
    }
}
