<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(){
		return $this->belongsTo('App\User');
	}
	
	public function lieu(){
		return $this->belongsTo('App\Lieu');
	}
	
	public function assos(){
		return $this->belongsTo('App\Assos');
	}
	
	public function clubs(){
		return $this->belongsTo('App\Clubs');
	}
}
