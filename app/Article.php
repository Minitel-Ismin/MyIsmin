<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    
	public function user(){
		return $this->belongsTo('App\User');
	}
	
	public function assos(){
		return $this->hasMany('App\Assos');
	}
	
	public function clubs(){
		return $this->hasMany('App\Clubs');
	}
	
	public function pages(){
		return $this->hasMany('App\Page');
	}
	
}
