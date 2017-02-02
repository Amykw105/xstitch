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
use Carbon\Carbon;
use File;
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
      $status = new Status;
      $status->description = $request->description;
      $status->project_id = $request->project_id;
      if($request->hasFile('image')) {
          $file = Input::file('image');
          //getting timestamp
          $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
          $name = str_replace([' ', ':'], '-',$timestamp. '-' .$file->getClientOriginalName());
          $project_id = $request->project_id;
          $userslug = $request->userslug;
          $status->image = '/images/projects/'.$userslug.'/'.$project_id.'/'.$name;
          $file->move(public_path().'/images/projects/'.$userslug.'/'.$project_id, $name);
          $status->save();
      }
      return response()->json($request);
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
