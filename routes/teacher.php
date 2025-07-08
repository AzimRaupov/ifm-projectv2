<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_teacher'])->group(function () {
    Route::get('/course',[\App\Http\Controllers\teacher\CourseController::class,'show'])->name('course.show');
    Route::get('/course/create',[\App\Http\Controllers\teacher\CourseController::class,'create'])->name('course.create');
    Route::post('/course',[\App\Http\Controllers\teacher\CourseController::class,'store'])->name('course.store');
    Route::get('/dashboard', [\App\Http\Controllers\teacher\TeacherController::class,'dashboard'])->name('dashboard');
});
