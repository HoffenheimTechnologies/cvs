<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
    	'event_sdate', 'active','event_edate',
	];

    public function attendance(){
    	return $this->hasMany(Attendance::class);
    }
}
