<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function article(){
		return $this->belongsTo('App\Article');
	}
}
