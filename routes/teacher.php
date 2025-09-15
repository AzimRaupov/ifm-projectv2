<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'is_teacher'])->group(function () {
   Route::get('/dashboard', [\App\Http\Controllers\teacher\TeacherController::class,'dashboard'])->name('dashboard');
    Route::prefix('test')->group(function (){
        Route::get('/edit',[\App\Http\Controllers\teacher\TestController::class,'edit'])->name('test.edit');
        Route::post('/generate',[\App\Http\Controllers\teacher\TestController::class,'generate'])->name('test.generate');

    });
     Route::prefix('course')->group(function (){

        Route::post('/update',[\App\Http\Controllers\teacher\CourseController::class,'update'])->name('course.update');
        Route::get('/edit/',[\App\Http\Controllers\teacher\CourseController::class,'edit'])->name('course.edit');
        Route::get('/show',[\App\Http\Controllers\teacher\CourseController::class,'show'])->name('course.show');
        Route::get('/create',[\App\Http\Controllers\teacher\CourseController::class,'create'])->name('course.create');
        Route::post('/',[\App\Http\Controllers\teacher\CourseController::class,'store'])->name('course.store');
        Route::get('/gen',[\App\Http\Controllers\teacher\CourseController::class,'gen'])->name('gen');
         Route::get('/{id}',[\App\Http\Controllers\teacher\CourseController::class,'index'])->name('course.index');

    });
    Route::prefix('step')->group(function (){
        Route::post('/update',[\App\Http\Controllers\teacher\StepController::class,'update'])->name('step.update');
        Route::post('/new/child',[\App\Http\Controllers\teacher\StepController::class,'new_child'])->name('step.new.child');
        Route::post('/new/parent',[\App\Http\Controllers\teacher\StepController::class,'new_parent'])->name('step.new.parent');
        Route::get('/edit',[\App\Http\Controllers\teacher\StepController::class,'edit'])->name('step.edit');
        Route::post('/destroy',[\App\Http\Controllers\teacher\StepController::class,'destroy'])->name('step.destroy');

    });
    Route::prefix('vocabulary')->group(function (){
        Route::post('/update',[\App\Http\Controllers\teacher\VocabularyController::class,'update'])->name('vocabulary.update');
        Route::post('/generate',[\App\Http\Controllers\teacher\VocabularyController::class,'generate'])->name('vocabulary.generate');

        Route::get('/edit',[\App\Http\Controllers\teacher\VocabularyController::class,'edit'])->name('vocabulary.edit');
    });

});
