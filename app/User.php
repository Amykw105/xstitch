<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile(){
      return $this->hasOne('App\Profile');
    }
    public function project(){
      return $this->hasMany('App\Project');
    }

    public function followers(){//they follow this user
      return $this->belongsToMany('App\User', 'followers', 'followee_id', 'follower_id');
    }

    public function followings(){//this user follows them
      return $this->belongsToMany('App\User', 'followers', 'follower_id', 'followee_id');
    }

    public function followUser(User $user){
      $this->followings()->attach($user->id);
    }

    public function unfollowUser(User $user){
      $this->followings()->detach($user->id);
    }
}
