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

Route::get('/home', 'HomeController@index');
// Not logged in to see
Route::group(['middleware' => ['web']], function() {

});
// Must be logged in to see
Route::group(['middleware' => ['auth']], function() {
  Route::get('/vuejscrud', 'web\ProjectController@vueCrud');
  Route::resource('/vueitems','web\ProjectController');
  //Route::get('/profile/{slug}', 'web\ProfilesController@viewProfile');
  Route::get('/profile/{slug}', 'web\ProjectController@index');
  Route::get('/profile/{slug}/{project}', 'web\ProjectController@index');
  Route::get('/projects', 'web/ProjectController@list');
});
