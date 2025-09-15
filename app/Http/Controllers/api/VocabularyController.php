<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VocabularyStep;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function isset(Request $request)
    {
        $result = VocabularyStep::query()->where('step_id', $request->id)->exists();

        return response()->json(['count'=>$result],200);

    }
}
