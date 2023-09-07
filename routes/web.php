<?php

use App\Events\MessageSent;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('chat', function () {
    return view("chat");
});

Route::post('message', function (Request $request) {
    broadcast(new MessageSent(auth()->user(), $request->input('message')));
    // gửi Event đến redis
    return $request->input('message');
});

Route::get('login/{id}', function ($id) {
    Auth::loginUsingId($id);
    return back();
});

Route::get('logout', function () {
    Auth::logout();
    return back();
});

Route::get('users', [UserController::class, 'index']);
