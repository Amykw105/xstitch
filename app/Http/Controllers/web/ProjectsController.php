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
    public function index()
    {
      $items = Project::all();
      $response = [
        'data' => $items
      ];
      return view('project.index', compact('items'));
    }

}
