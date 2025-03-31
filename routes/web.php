<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/test/create',[\App\Http\Controllers\api\create\CreateController::class,'c_test'])->name('t');

Route::get('/dashboard', function () {

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/vocabulary',[\App\Http\Controllers\VocabularyController::class,'show'])->name('vocabulary.show');
    Route::get('/gpt',[\App\Http\Controllers\api\create\CreateController::class,'c_test']);
    Route::get('/test',[\App\Http\Controllers\TestController::class,'show'])->name('test.show');
    Route::post('/api/get/steps/{id}',[\App\Http\Controllers\api\get\GetController::class,'steps'])->name('get.steps');
    Route::post('/api/create/description',[\App\Http\Controllers\api\create\CreateController::class,'create_description'])->name('api.create.description');
    Route::get('api/create/vocabulary',[\App\Http\Controllers\api\create\CreateController::class,'vocabulary'])->name('api.create.vocabulary');
    Route::get('/show',[\App\Http\Controllers\CourseController::class,'show'])->name('show');
    Route::post('/api/info',[\App\Http\Controllers\api\get\GetController::class,'user_info'])->name('user_info');
    Route::post('/api/create/test',[\App\Http\Controllers\api\create\CreateController::class,'test'])->name('api.create.test');
    Route::post('/api/get/test/{id}',[\App\Http\Controllers\api\get\GetController::class,'test'])->name('get.test');
    Route::post('/api/create/course',[\App\Http\Controllers\api\create\CreateController::class,'course'])->name('api.create.course');
    Route::post('/api/check/test',[\App\Http\Controllers\api\CheckTestController::class,'check'])->name('api.check.test');
    Route::resource('/course',\App\Http\Controllers\CourseController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
