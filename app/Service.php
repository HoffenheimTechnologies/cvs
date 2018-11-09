<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;

class Service extends Model
{
    //
    protected $fillable = [
    	'sdays', 'name','edays',
	];

  public static function createServiceEvent(Event $event){
  	return ;
  }
}
