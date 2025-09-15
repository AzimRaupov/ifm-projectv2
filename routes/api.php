<?php
use Illuminate\Support\Facades\Route;



Route::post('/status/step',[\App\Http\Controllers\api\get\GetController::class,'status_step'])->name('status.step');
Route::post('/get/skills',[\App\Http\Controllers\api\get\GetController::class,'skills'])->name('get.skills');
Route::post('/rd/vocabulary',[\App\Http\Controllers\VocabularyController::class,'rd'])->name('vocabulary.rd');
Route::post('/get/steps/{id}',[\App\Http\Controllers\api\get\GetController::class,'steps'])->name('get.steps');
Route::post('/create/description',[\App\Http\Controllers\api\create\CreateController::class,'create_description'])->name('create.description');
Route::post('/check/test',[\App\Http\Controllers\api\CheckTestController::class,'check'])->name('check.test');
Route::post('/create/course',[\App\Http\Controllers\api\create\CreateController::class,'course'])->name('create.course');
Route::post('/create/test',[\App\Http\Controllers\api\create\CreateController::class,'test'])->name('create.test');
Route::post('/get/test/{id}',[\App\Http\Controllers\api\get\GetController::class,'test'])->name('test');
Route::post('/info',[\App\Http\Controllers\api\get\GetController::class,'user_info'])->name('user_info');
Route::post('/create/vocabulary',[\App\Http\Controllers\api\create\CreateController::class,'vocabulary'])->name('create.vocabulary');
Route::post('/upload',[\App\Http\Controllers\api\create\CreateController::class,'upload'])->name('upload');

Route::post('/user/ping',[\App\Http\Controllers\api\UserController::class,'ping'])->name('user.ping');

Route::prefix('/vocabulary')->group(function (){
       Route::post('/isset',[\App\Http\Controllers\api\VocabularyController::class,'isset'])->name('vocabulary.isset');
});


Route::prefix('/test')->group(function (){
    Route::get('/isset',[\App\Http\Controllers\api\TestController::class,'isset'])->name('test.isset');
});

Route::prefix('/step')->group(function (){
    Route::post('/statusEdit',[\App\Http\Controllers\api\ApiStepController::class,'statusEdit'])->name('step.statusEdit');
});

Route::prefix('/teacher')->group(function (){

    Route::post('/step/sort',[\App\Http\Controllers\teacher\StepController::class,'sort'])->name('teacher.step.sort');

});
