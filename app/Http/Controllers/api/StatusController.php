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
class StatusController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user, $project)
    {
      $id = User::where('slug', $user)->first();
      $project = Project::where('slug', $project)->where('user_id', $id['id'])->first();
      $items = Status::where('project_id', $project['id'])->get();
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
      $create = Status::create($request->all());

      return response()->json($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user, $project, $id){
        $userid = User::where('slug', $user)->first();
        $project = Project::where('slug', $project)->where('user_id', $userid['id'])->first();
        $status = Status::where('project_id', $project['id'])->where('id', $id)->get();
        $response = [
          'data' => $status
        ];
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user, $project, $id){
       //$userid = User::where('slug', $user)->first();
      // $project = Project::where('slug', $project)->where('user_id', $userid['id'])->first();
       $edit = Status::where('id', $id)->first();
       $edit->update($request->all());
       return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user, $project, $id)
    {
      $del = Status::findOrFail($id);
      $del->delete();
    }
}
