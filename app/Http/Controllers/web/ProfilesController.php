<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\User;
use App\Project;
use Auth;
use Session;
use Illuminate\Support\Facades\Input;

class ProfilesController extends Controller
{
    public function index($slug){
      $user = User::where('slug', $slug)->first();
      $following = $user->followings()->get()->toArray();
      $followers = $user->followers()->get()->toArray();
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
      if(search_array($current_user_id, $followers)) {
        $am_i_following = true;
      }
      if(!search_array($current_user_id, $followers)) {
        $am_i_following = false;
      }

      $projects = $user->project()->get()->toArray();
       return view('profiles.profile', compact('user', 'am_i_following'));
    }
    public function getInfo($user){
      $getUser = User::where('slug', $user)->first();
      $userAdv = $getUser->profile()->get()->toArray();
      return response()->json([
          'userbasics'=>$getUser,
          'user'=>$userAdv
      ]);
    }
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
    public function getProjects($user){
      $getUser = User::where('slug', $user)->first();
      $projects = $getUser->project()->get()->toArray();
      return response()->json([
          'projects'=>$projects
      ]);
    }
    public function getFollowers($user){
      $getUser = User::where('slug', $user)->first();
      $followers = $getUser->followers()->get()->toArray();
      return response()->json([
          'followers'=>$followers
      ]);
    }
    public function getFollowees($user){
      $getUser = User::where('slug', $user)->first();
      $followees = $getUser->followings()->get()->toArray();
      return response()->json([
          'followees'=>$followees
      ]);
    }

    public function edit(){
      $user = Auth::user()->profile;
      return view('profiles.edit', compact('user'));
    }

    public function update(Request $request){
      $this->validate($request,[
        'location' => 'required',
        'about' => 'required|max:255'
      ]);

      Auth::user()->profile()->update([
        'location' => $request->location,
        'about' => $request->about
      ]);


      if(Input::hasFile('avatar')){
        $file = $request->avatar;
        $extension = $file->getClientOriginalExtension();
        $filename = (Auth::user()->slug) . '.' .$extension;
        $file->move('images/profiles/custom/', $filename);
        Auth::user()->update([
          'avatar' =>  'images/profiles/custom/' . $filename
        ]);
      }

      Session::flash('success', 'Profile Updated');
      return redirect()->back();

    }

    public function followUser($slug){
      $user = User::where('slug', $slug)->first();
      Auth::user()->followUser($user);
      Session::flash('success', 'You have followed this user!');
      return redirect()->back();
    }

    public function unfollowUser($slug){
      $user = User::where('slug', $slug)->first();
      Auth::user()->unfollowUser($user);
      Session::flash('success', 'You have unfollowed this user!');
      return redirect()->back();
    }
}
