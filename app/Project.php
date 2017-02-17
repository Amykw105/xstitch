<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'source', 'description', 'type'];

    public function user(){
      return $this->belongsTo('App\User', 'projects', 'user_id', 'id');
    }

    public function status(){
      return $this->hasMany('App\Status');
    }

}
