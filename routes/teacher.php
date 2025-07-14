<?php

use Illuminate\Support\Facades\Route;

Route::get('/course/subscribe',[\App\Http\Controllers\teacher\CourseController::class,'subscribe'])->name('course.subscribe');

Route::middleware(['auth', 'is_teacher'])->group(function () {
    Route::get('/course',[\App\Http\Controllers\teacher\CourseController::class,'show'])->name('course.show');
    Route::get('/course/create',[\App\Http\Controllers\teacher\CourseController::class,'create'])->name('course.create');
    Route::post('/course',[\App\Http\Controllers\teacher\CourseController::class,'store'])->name('course.store');
    Route::get('/course/gen',[\App\Http\Controllers\teacher\CourseController::class,'gen'])->name('gen');
    Route::get('/dashboard', [\App\Http\Controllers\teacher\TeacherController::class,'dashboard'])->name('dashboard');
    Route::prefix('test')->group(function (){
        Route::get('/edit',[\App\Http\Controllers\teacher\TestController::class,'edit'])->name('test.edit');

    });

    Route::prefix('vocabulary')->group(function (){
        Route::get('/edit',[\App\Http\Controllers\teacher\VocabularyController::class,'edit'])->name('vocabulary.edit');
    });

});
