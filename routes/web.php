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

    Route::get('/posts', 'PostController@index')->name('posts');

    Route::group(['middleware' => ['auth','admin']], function () {

        Route::name('admin.')->group(function () {
        
            Route::resource('admin/posts', 'AdminPostsController',
            [
            'except' => [
                'index'
                ]
            ]);            
            
            Route::post('admin/post/{id}/restore', 'AdminPostsController@restore')->name('posts.restore');
    
            Route::get('admin/posts/index/{listmode?}', 'AdminPostsController@index')->name('posts.index');



            Route::resource('admin/user', 'AdminUsersController',            
            [
            'except' => [
                'index'
                ]
            ]);
            
            Route::post('admin/user/{id}/restore', 'AdminUsersController@restore')->name('user.restore');
    
            Route::get('admin/users/{listmode?}', 'AdminUsersController@index')->name('users.index');

        });
    });

});

//Route::get('logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
