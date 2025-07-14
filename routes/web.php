<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/test/create',[\App\Http\Controllers\api\create\CreateController::class,'c_test'])->name('t');

Route::get('/dashboard',[\App\Http\Controllers\UserController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/fg',[\App\Http\Controllers\TestController::class,'send']);
Route::get('/google/auth',[\App\Http\Controllers\UserController::class,'google_auth'])->name('google.auth');
Route::get('/google-calback',[\App\Http\Controllers\UserController::class,'google_callback'])->name('google.callback');
Route::middleware('auth')->group(function () {

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
