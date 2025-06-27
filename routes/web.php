<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/test/create',[\App\Http\Controllers\api\create\CreateController::class,'c_test'])->name('t');

Route::get('/dashboard',[\App\Http\Controllers\UserController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/fg',[\App\Http\Controllers\TestController::class,'send']);
Route::middleware('auth')->group(function () {
    Route::prefix('api')->group(function (){
        Route::post('/status/step',[\App\Http\Controllers\api\get\GetController::class,'status_step'])->name('api.status.step');
        Route::post('/get/skills',[\App\Http\Controllers\api\get\GetController::class,'skills'])->name('api.get.skills');
        Route::post('/rd/vocabulary',[\App\Http\Controllers\VocabularyController::class,'rd'])->name('vocabulary.rd');
        Route::post('/get/steps/{id}',[\App\Http\Controllers\api\get\GetController::class,'steps'])->name('get.steps');
        Route::post('/create/description',[\App\Http\Controllers\api\create\CreateController::class,'create_description'])->name('api.create.description');
        Route::post('/check/test',[\App\Http\Controllers\api\CheckTestController::class,'check'])->name('api.check.test');
        Route::post('/create/course',[\App\Http\Controllers\api\create\CreateController::class,'course'])->name('api.create.course');
        Route::post('/create/test',[\App\Http\Controllers\api\create\CreateController::class,'test'])->name('api.create.test');
        Route::post('/get/test/{id}',[\App\Http\Controllers\api\get\GetController::class,'test'])->name('get.test');
        Route::post('/info',[\App\Http\Controllers\api\get\GetController::class,'user_info'])->name('user_info');
        Route::post('/create/vocabulary',[\App\Http\Controllers\api\create\CreateController::class,'vocabulary'])->name('api.create.vocabulary');

    });
    Route::prefix('course')->group(function (){
        Route::get('/create',[\App\Http\Controllers\CourseController::class,'create'])->name('course.create');
        Route::get('progress',[\App\Http\Controllers\CourseController::class,'progress'])->name('course.progress');
    });
    Route::post('/user/update',[\App\Http\Controllers\UserController::class,'update'])->name('user.update');
    Route::post('/test/check',[\App\Http\Controllers\TestController::class,'check'])->name('test.check');
    Route::get('/vocabulary',[\App\Http\Controllers\VocabularyController::class,'show'])->name('vocabulary.show');
    Route::get('/gpt',[\App\Http\Controllers\api\create\CreateController::class,'c_test']);
    Route::get('/test',[\App\Http\Controllers\TestController::class,'show2'])->name('test.show');
    Route::get('/show',[\App\Http\Controllers\CourseController::class,'show'])->name('show');
//    Route::resource('/course',\App\Http\Controllers\CourseController::class);
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
