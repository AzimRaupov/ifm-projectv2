<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Models\Course;
use App\Models\Step;
use Carbon\Carbon;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GenerateRodmap;
use function Pest\Laravel\json;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCourseRequest $request)
    {
       $user=Auth::user();
        $date_start=Carbon::today();
      $map=GenerateRodmap::generateRodmap($request,$user);
      dd($map);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user=Auth::user();
        $course = Course::query()->where('user_id', $user->id)
            ->where('id', $request->input('id'))
            ->firstOrFail();

        return view('course.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
