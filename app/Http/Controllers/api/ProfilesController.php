<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\User;
use App\Project;
use App\Profile;
use Auth;
use Session;
use Illuminate\Support\Facades\Input;

class ProfilesController extends Controller
{
    // public function index($slug){
    //   $user = User::where('slug', $slug)->first();
    //   $following = $user->followings()->get()->toArray();
    //   $followers = $user->followers()->get()->toArray();
    //   // The below function checks to the is the logged in user is
    //   // following the profile of user being viewed.
    //   $current_user_id = Auth::user()->id;
    //   function search_array($needle, $haystack) {
    //      if(in_array($needle, $haystack)) {
    //           return true;
    //      }
    //      foreach($haystack as $element) {
    //           if(is_array($element) && search_array($needle, $element))
    //                return true;
    //      }
    //      return false;
    //   }
    //   if(search_array($current_user_id, $followers)) {
    //     $am_i_following = true;
    //   }
    //   if(!search_array($current_user_id, $followers)) {
    //     $am_i_following = false;
    //   }
    //
    //   $projects = $user->project()->get()->toArray();
    //    return view('profiles.profile', compact('user', 'am_i_following'));
    // }
    // public function getInfo($user){
    //   $getUser = User::where('slug', $user)->first();
    //   $userAdv = $getUser->profile()->get()->first();
    //   return response()->json([
    //       'userbasics'=>$getUser,
    //       'user'=>$userAdv
    //   ]);
    // }
    public function profileActions($user){
      $getUser = User::where('slug', $user)->first();
      $following = $getUser->followings()->get()->toArray();
      $followers = $getUser->followers()->get()->toArray();
      // The below function checks to the is the logged in user is
      // following the profile of user being viewed.
      $current_user_id = Auth::user()->id;
      function search_array($needle, $haystack) {
         if(in_array($needle, $haystack)) {
              return true;
         }
         foreach($haystack as $element) {
              if(is_array($element) && search_array($needle, $element))
                   return true;
         }
         return false;
      }
      if(!search_array($current_user_id, $followers)) {
        $am_i_following = 0;
      }
      if(search_array($current_user_id, $followers)) {
        $am_i_following = 1;
      }
      if($getUser->id == $current_user_id) {
        $am_i_following = 2;
      }
      return response()->json([
          'status'=>$am_i_following
      ]);
    }
    public function getInfo($user){
      $getUser = User::where('slug', $user)->first();
      $getInfo = Profile::where('user_id', $getUser['id'])->first();
      return response()->json([
          'userinfo'=>$getUser,
          'userdata'=>$getInfo,
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
