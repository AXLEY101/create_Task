<?php

use Illuminate\Support\Facades\Route;
//テスト用
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;




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

//タスク管理システム
Route::get('/',[AuthController::class,'index'])->name('front.index');
Route::post('/login',[AuthController::class,'login']);
//認可処理
Route::middleware(['auth'])->group(function (){
    Route::prefix('/task')->group(function (){
        Route::get('/list',[TaskController::class, 'list']);
        Route::post('/register',[TaskController::class,'register']);
        Route::get('/detail/{task_id}',[TaskController::class,'detail'])->whereNumber('task_id')->name('detail');
        Route::get('/edit/{task_id}',[TaskController::class, 'edit'])->whereNumber('task_id')->name('edit');
        Route::put('/edit/{task_id}',[TaskController::class, 'editSave'])->whereNumber('task_id')->name('edit_save');
        Route::delete('/delete/{task_id}',[TaskController::class,'delete'])->whereNumber('task_id')->name('delete');
        Route::post('/complete/{task_id}',[TaskController::class,'complete'])->whereNumber('task_id')->name('complete');
    });
    
    Route::get('/logout',[AuthController::class,'logout']);
});


//テスト
Route::get('/welcome',[WelcomeController::class,'index']);
Route::get('/welcome/second',[WelcomeController::class, 'second']);
Route::get('/welcome/tree3',[WelcomeController::class, 'tree3']);
Route::get('/welcome/for4',[WelcomeController::class, 'for4']);

//formテスト
Route::post('/test/input',[TestController::class,'input']);
Route::get('/test',[TestController::class,'index']);