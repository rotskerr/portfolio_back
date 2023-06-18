<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/desktop', [\App\Http\Controllers\ApiController::class, 'getDesktop'])->name('desktop');

Route::get('/mobile', [\App\Http\Controllers\ApiController::class, 'getMobile'])->name('mobile');

Route::get('/projects', [\App\Http\Controllers\ApiController::class, 'getProjects'])->name('project');

