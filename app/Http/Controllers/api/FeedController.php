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
              ->where('projects.user_id', $getUser['id'])
              ->orderby('statuses.created_at', 'desc')->limit(6)->get();
      // select s.* from statuses s inner join projects p on p.id = s.project_id and p.user_id = 11 order by s.created_at Desc;

      return response()->json([
          'updates'=>$updates,
      ]);
    }
    public function getProjects($user){
      $getUser = User::where('slug', $user)->first();
      $projects = $getUser->project()->get()->toArray();
      return response()->json([
          'projects'=>$projects
      ]);
    }
    // Who are my followers
    public function getFollowers($user){
      $getUser = User::where('slug', $user)->first();
      $followers = $getUser->followers()->get()->toArray();
      return response()->json([
          'followers'=>$followers
      ]);
    }
    // Who am I following
    public function getFollowees($user){
      $getUser = User::where('slug', $user)->first();
      $followees = $getUser->followings()->get()->toArray();
      return response()->json([
          'followees'=>$followees
      ]);
    }
}
