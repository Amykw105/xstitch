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

  public function viewProfile($slug){
    $user = User::where('slug', $slug)->first();
    return view('/profile.index', compact('user'));
  }

}
