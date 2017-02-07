<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\User;
use App\Project;
use App\Profile;
use App\Followers;
use Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Input;

class FollowingController extends Controller
{

    public function index($cuser, $ouser){
      $getUser = User::where('slug', $ouser)->first();
      $currentUser = User::where('slug', $cuser)->first();
      // The below function allows for searching of
      // multi-dimensional arrays
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

      if($getUser['id'] === $currentUser['id']){
        $followstatus = 'You cannot follow yourself';
      }
      else{
        $am_i_following = $currentUser->followings()->get()->toArray();

        if(search_array($getUser['id'], $am_i_following)){
          // $followstatus = 'you are already following';
          $followstatus = true;
        }
        else{
          // $followstatus = 'you are not following';
          $followstatus = false;
        }
      }
      return response()->json([
          'followstatus'=>$followstatus,
      ]);
    }

    public function store($cuser, $ouser, Request $request){
      $follower = new Followers;
      $follower->followee_id = $request->followee;
      $follower->follower_id = $request->follower;
      $follower->save();

      return response()->json($request);
    }

    public function destroy($cuser, $ouser, Request $request){
      $getUser = User::where('slug', $ouser)->first();
      $currentUser = User::where('slug', $cuser)->first();
      $entry = Followers::where('followee_id', $getUser['id'])->where('follower_id', $currentUser['id'])->first(['id']);
      $entry->delete();
    }


}
