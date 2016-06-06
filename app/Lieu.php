<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
	public function event()
    {
        return $this->hasMany('App\Evenement');
    }
}
