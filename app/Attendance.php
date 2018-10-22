<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = [
        'attendance', 'event_date', 'user_id'
    ];

    public function user(){
      return $this->belongsTo(Users::class);
    }
}
