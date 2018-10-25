<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = [
        'attendance', 'event_id', 'user_id'
    ];

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function event(){
    	return $this->belongsTo(Event::class);
    }
}
