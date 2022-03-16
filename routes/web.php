<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {
    $credentials = [
        'email' => 'boyd54@example.com',
        'password' => 'password'
    ];

    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();

        return auth()->user();
    }

    abort(401);
});


Route::get('/users', function () {
    return  User::all();
})->middleware('auth:sanctum');

