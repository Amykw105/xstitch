<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Status;
use App\Http\Requests;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
class ProjectController extends Controller
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
      return response()->json($response);
    }

    public function getProject($user,$project){
      $getUser = User::where('slug', $user)->first();
      $project = Project::where('slug', $project)->where('user_id', $getUser->id)->first();
      $statuses = Status::where('project_id', $project->id)->get();
      return response()->json([
          'projects'=>$project,
          'statuses' => $statuses
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
      'name' => 'required',
      'description' => 'required',
      ]);
      $create = Project::create($request->all());
      return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Project::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request,[
      'name' => 'required',
      'description' => 'required',
      ]);
      $edit = Project::find($id)->update($request->all());
      return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Project::find($id)->delete();
      return response()->json(['done']);
    }
}
