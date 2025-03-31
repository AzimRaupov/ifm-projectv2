<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\GetController;

Route::middleware('auth:apii')->group(function () {
});
Route::get('/in', [GetController::class, 'get']);
