<?php

namespace App;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
	use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Get all of the tasks for the user.
     */
    public function events()
    {
    	return $this->hasMany(Evenement::class);
    }
    
    public function articles(){
    	return $this->hasMany(Article::class);
    }
    
    public static function getPrez(){
    	return DB::table('users')->select('users.*')->join('role_user', 'users.id','=','role_user.user_id')
    			->leftjoin('roles','role_user.role_id','=','roles.id')->where('roles.name','=','prez')->orwhere('roles.name','=','admin')->get();
    }
//     public function roles()
//     {
//     	return $this->belongsToMany('Role','assigned_roles');
//     }
    
    
}
