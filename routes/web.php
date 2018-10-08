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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/post/{id}', 'PostController@show')->name('post');

    Route::get('/news', 'PostController@index')->name('news');

    
    Route::name('admin.')->group(function () {
        
        Route::resource('admin/posts', 'AdminPostsController',
        [
        'except' => [
            'index'
            ]
        ]);
        
        Route::post('admin/restore/{id}', 'AdminPostsController@restore')->name('posts.restore');

        Route::get('admin/index/{listmode?}', 'AdminPostsController@index')->name('posts.index');
    });
});

//Route::get('logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
