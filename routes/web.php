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

/*
* Route for welcome page for everyone
*/
Route::get('/', function () {
    return view('welcome');
});


/*
* Basic auth route
*/
Auth::routes();

/*
* Route for only registrated users
*/
Route::group(['middleware' => ['auth']], function () {

    Route::get('/post/{id}', 'PostController@show')->name('post');

    Route::get('/posts', 'PostController@index')->name('posts');

    Route::resource('/comments', 'CommentsController');

    //Route for only authenticated admin users
    Route::group(['middleware' => ['auth','admin']], function () {

        Route::name('admin.')->group(function () {
        
            /*
            * Route for posts handeling
            */
            Route::resource('admin/posts', 'AuthorPostsController',
            [
                'except' => [
                    'show',
                    ]
            ]);            
            
            Route::post('admin/post/{id}/restore', 'AuthorPostsController@restore')->name('posts.restore');


            /*
            * Route for users handeling
            */
            Route::resource('admin/user', 'AdminUsersController',            
            [
            'except' => [
                'index',
                'create'
                ]
            ]);
            
            Route::post('admin/user/{id}/restore', 'AdminUsersController@restore')->name('user.restore');
    
            Route::get('admin/users/', 'AdminUsersController@index')->name('users.index');

            Route::get('admin/users/search/', 'AdminUsersController@search')->name('users.search');

            /*
            * Route for boats handeling
            */
            Route::resource('admin/boats', 'AdminBoatsController',            
            [
            'except' => [
                'index',
                ]
            ]);
            
            Route::post('admin/boats/{id}/restore', 'AdminBoatsController@restore')->name('boat.restore');
    
            Route::get('admin/boats/', 'AdminBoatsController@index')->name('boats.index');

        });
    });

});


Route::get('/home', 'HomeController@index')->name('home');
