<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['description', 'image','project_id'];

    public function project(){
      return $this->belongsTo('App\Project');
    }

}
