<?php

namespace App\Http\Controllers\web;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Status;
use App\Http\Requests;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index($user){
       $user = User::where('slug', $user)->first();
       return view('project.index', compact('user'));
     }

    public function show($user, $project){
      $user = User::where('slug', $user)->first();
      $projectslug = $project;
      $projectid = Project::where('slug', $project)->where('user_id', $user['id'])->first();
      return view('project.show', compact('user','projectslug', 'projectid'));
    }

}
