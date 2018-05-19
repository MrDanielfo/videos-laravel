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

/*Route::get('/', 'HomeController@index')->name('home');
otra forma de escribir una ruta y el uses
*/

Route::get('/', array(
    'as'  => 'home',
    'uses' => 'HomeController@index'
));

// Rutas del Controlador de Video

Route::get('crear-video', array(
    'as'  => 'createVideo',
    'middleware' => 'auth', 
    'uses'      => 'VideoController@createVideo'
)); 

Route::post('guardar-video', array(
    'as'  => 'saveVideo',
    'middleware' => 'auth', 
    'uses'      => 'VideoController@saveVideo'
)); 

Route::get('miniatura/{filename}', array(
    'as'    => 'imageVideo',
    'uses'  => 'VideoController@getImage'
));

Route::get('video-detail/{video_id}', array(
    'as'    => 'videoDetail',
    'uses'  => 'VideoController@getVideoSingle'
));

Route::get('video-file/{filename}', array(
    'as'    => 'fileVideo',
    'uses'  => 'VideoController@getVideo'
));

Route::get('video-delete/{video_id}', array(
    'as' => 'videoDelete',
    'middleware' => 'auth',
    'uses'      => 'VideoController@deleteVideo'
));

Route::get('video-edit/{video_id}', array(
    'as' => 'videoEdit',
    'middleware' => 'auth',
    'uses'      => 'VideoController@editVideo'
));

Route::post('update-video/{video_id}', array(
    'as'  => 'videoUpdate',
    'middleware' => 'auth', 
    'uses'      => 'VideoController@updateVideo'
)); 

// Comentarios 

Route::post('comment', array(
    'as' => 'comment',
    'middleware' => 'auth',
    'uses'      => 'CommentController@store'
)); 

Route::get('comment-delete/{comment_id}', array(
    'as' => 'commentDelete',
    'middleware' => 'auth',
    'uses'      => 'CommentController@deleteComment'
)); 

// buscador

Route::get('search-video/{search?}/{filter?}', array(
    'as' => 'searchVideo',
    'uses'  => 'VideoController@search'
));

// ruta para caché

Route::get('clear-cache', function(){
    $code = Artisan::call('cache:clear');
}); 

// Usuarios 

Route::get('channel/{user_id}', array(
    'as' => 'channelUser',
    'uses'  => 'UserController@channel'
));


