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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'MicropostsController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');//views/auth/register.blade.phpを表示する
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
//nameメソッド｢->name('●●');｣は名前つきルー、特定のルートへのURLを生成したり、リダイレクトしたりする場合に便利なものです。

// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

//ログイン認証付きのルーティング
Route::group(['middleware' => 'auth'], function () { //ルーティングのグループを作成
              //['middleware' => ['auth']]ミドルウェアでこのグループに書かれたルーティングは必ずログイン認証を確認させる
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);//['only' => ['index', 'show']]実装するアクションを絞り込む
    
     Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        
        Route::post('favorite', 'UserFavoriteController@store')->name('user.favorite');
        Route::delete('unfavorite', 'UserFavoriteController@destroy')->name('user.unfavorite');
        Route::get('favoritings', 'UsersController@favoritings')->name('users.favoritings');
    });

    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);//ログイン認証を必要とするルーティンググループ内に、 Microposts のルーティングを設定
});