<?php

namespace App\Http\Controllers\web;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Http\Requests;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{

    public function index($slug, $project){
      $user = User::where('slug', $slug)->first();
      $project = Project::where('slug', $project)->where('user_id', $user->id)->first();
      return view('/project.index', compact('user', 'project'));
    }
}
