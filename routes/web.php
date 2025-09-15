<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/',[\App\Http\Controllers\SystemController::class,'home'])->name('home');


Route::get('/test/create',[\App\Http\Controllers\api\create\CreateController::class,'c_test'])->name('t');


Route::get('/dashboard',[\App\Http\Controllers\UserController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/fg',[\App\Http\Controllers\TestController::class,'send']);
Route::get('/google/auth',[\App\Http\Controllers\UserController::class,'google_auth'])->name('google.auth');
Route::get('/google-calback',[\App\Http\Controllers\UserController::class,'google_callback'])->name('google.callback');



Route::get('/courses',[\App\Http\Controllers\CourseController::class,'index'])->name('courses.index');




Route::middleware('auth')->group(function () {

    Route::prefix('course')->group(function (){
        Route::get('/create',[\App\Http\Controllers\CourseController::class,'create'])->name('course.create');
        Route::get('/progress',[\App\Http\Controllers\CourseController::class,'progress'])->name('course.progress');
        Route::get('/certificate',[\App\Http\Controllers\CourseController::class,'certificate'])->name('course.certificate');
        Route::get('/subscribe',[\App\Http\Controllers\teacher\CourseController::class,'subscribe'])->name('course.subscribe');
        Route::get('/tutorial',[\App\Http\Controllers\CourseController::class,'tutorial'])->name('course.tutorial');
        Route::get('/book',[\App\Http\Controllers\CourseController::class,'pdf_book'])->name('course.pdf_book');


    });

    Route::prefix('account')->group(function (){

        Route::post('/updateBasic',[\App\Http\Controllers\AccountController::class,'updateBasic'])->name('account.updateBasic');
        Route::post('/updatePass',[\App\Http\Controllers\AccountController::class,'updatePass'])->name('account.updatePass');
        Route::post('deleteAcc',[\App\Http\Controllers\AccountController::class,'deleteAcc'])->name('account.deleteAcc');
    });

    Route::get('profile/settings',[\App\Http\Controllers\UserController::class,'profile_settings'])->name('profile.settings');

    Route::post('/user/update',[\App\Http\Controllers\UserController::class,'update'])->name('user.update');
    Route::post('/test/check',[\App\Http\Controllers\TestController::class,'check'])->name('test.check');
    Route::get('/vocabulary',[\App\Http\Controllers\VocabularyController::class,'show'])->name('vocabulary.show');
    Route::get('/gpt',[\App\Http\Controllers\api\create\CreateController::class,'c_test']);
    Route::get('/test',[\App\Http\Controllers\TestController::class,'show2'])->name('test.show');
    Route::get('/show',[\App\Http\Controllers\CourseController::class,'show'])->name('show');
//    Route::resource('/course',\App\Http\Controllers\CourseController::class);
    Route::get('/profile/courses',[\App\Http\Controllers\AccountController::class,'courses'])->name('profile.courses');
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
