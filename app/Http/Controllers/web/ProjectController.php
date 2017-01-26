<?php

namespace App\Http\Controllers\web;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Requests;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
class ProjectController extends Controller
{

    public function vueCrud(){
      return view('/vuejscrud/index');
    }
}
