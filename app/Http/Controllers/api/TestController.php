<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function isset(Request $request)
    {
        $result = Test::query()->where('step_id', $request->id)->exists();

        return response()->json(['count'=>$result],200);

    }
}
