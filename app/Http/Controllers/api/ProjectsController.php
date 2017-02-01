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
class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user)
    {
      $id = User::where('slug', $user)->first();
      $items = Project::where('user_id', $id['id'])->get();
      $response = [
        'data' => $items
      ];
      return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
      $create = Project::create($request->all());

      return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user, $id){
        $project = Project::where('id', $id)->first();
        return response()->json($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function projectInfo($user, $slug){
        $userid = User::where('slug', $user)->first();
        $project = Project::where('slug', $slug)->where('user_id', $userid['id'])->first();
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user, $id)
    {
       $edit = Project::where('id', $id)->first();
       $edit->update($request->all());
       return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user, $id)
    {
      $del = Project::findOrFail($id);
      $del->delete();
    }
}
