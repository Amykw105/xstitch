<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/all_projects', 'api\ProjectController@index');
 Route::get('/{user}/info', 'api\ProfilesController@getInfo');
// Route::get('/{user}/followees', 'api\ProfilesController@getFollowees');
// Route::get('/{user}/followers', 'api\ProfilesController@getFollowers');
// Route::get('/{user}/actions', 'api\ProfilesController@profileActions');
 Route::get('/{user}/projects_list', 'api\ProfilesController@getProjects');
// Route::get('/{user}/{project}', 'api\ProjectController@getProject');
Route::resource('/projects', 'api\ProjectsController');
//Route::post('/projects', 'api\ProjectsController@store');
