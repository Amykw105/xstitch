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

// Profiles and users
Route::get('/{user}/info', 'api\ProfilesController@getInfo');
Route::get('/{user}/followers', 'api\ProfilesController@getFollowers');
Route::get('/{user}/following', 'api\ProfilesController@getFollowees');

// Projects and Statuses
Route::resource('/{user}/projects', 'api\ProjectsController');
Route::get('/{user}/projects/{project}', 'api\ProjectsController@projectInfo');
Route::resource('/{user}/{project}/statuses', 'api\StatusController');

// Feeds
Route::get('/{user}/my-feed', 'api\FeedController@myFeed');
Route::get('/{user}/following-feed', 'api\FeedController@followingFeed');
