<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post("/chat",[ChatController::class,'store']);
Auth::routes();

Route::get('/oldmessages',function(Request $request){
// $request->session()->forget('chat');
     return $request->session()->get('chat');
});

Route::post('/storechatmsg',[ChatController::class,"storechatmsg"]);
Route::get('/home', [HomeController::class,'index'])->name('home');
