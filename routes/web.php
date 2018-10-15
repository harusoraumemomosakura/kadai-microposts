<?php

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

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');//views/auth/register.blade.phpを表示する
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
//nameメソッド｢->name('●●');｣は名前つきルー、特定のルートへのURLを生成したり、リダイレクトしたりする場合に便利なものです。
