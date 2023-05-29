<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[AuthController::class,'index']);




Route::get('/welcome',[WelcomeController::class,'index']);
Route::get('/welcome/second',[WelcomeController::class, 'second']);
Route::get('/welcome/tree3',[WelcomeController::class, 'tree3']);
Route::get('/welcome/for4',[WelcomeController::class, 'for4']);
