<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\User;
use App\Project;
use App\Profile;
use App\Status;
use Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Input;

class FeedController extends Controller
{

    public function myFeed($user){
      $getUser = User::where('slug', $user)->first();

      $updates = DB::table('statuses')
              ->select('statuses.*')
              ->join('projects', 'statuses.project_id', '=', 'projects.id')
              ->where('projects.user_id', $getUser['id'])
              ->orderby('statuses.created_at', 'desc')->get();
      // select s.* from statuses s inner join projects p on p.id = s.project_id and p.user_id = 11 order by s.created_at Desc;

      return response()->json([
          'updates'=>$updates,
      ]);
    }
    public function followingFeed($user){
      $getUser = User::where('slug', $user)->first();

      $updates = DB::table('statuses')
              ->select('statuses.*')
              ->join('projects', 'statuses.project_id', '=', 'projects.id')
              ->join('followers', 'projects.id', '=', 'followers.followee_id')
              ->where('followers.follower_id', $getUser['id'])
              ->orderby('statuses.created_at', 'desc')->limit(6)->get();
      // select s.* from statuses s inner join projects p on p.id = s.project_id inner join followers f on p.id = f.followee_id where f.follower_id = 11;

      return response()->json([
          'updates'=>$updates,
      ]);
    }

}
