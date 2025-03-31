<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    function show(Request $request)
    {
         return view('vocabolary.show',compact('request'));
    }
}
