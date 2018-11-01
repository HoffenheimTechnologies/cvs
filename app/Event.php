<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
    	'event_sdate', 'active','event_edate',
	];

  public static function getActive(){
    return Event::where('active', '1')->first();
  }

  public static function getEventByEndDate(){
    return Event::where('event_edate', $squery_date)->first();
  }

  public static function getUserStat(Event $event){
    return User::select('users.firstname', 'users.lastname','users.role', 'attendances.attendance', 'attendances.updated_at')
      ->where('event_id', $event->id)->leftjoin('attendances', 'users.id', 'attendances.user_id')
      ->leftjoin('events', 'events.id', 'attendances.event_id')->get();
  }

  public static function getUsersStat(Event $event){
    return Attendance::selectRaw("SUM(CASE when attendance = 1 then 1 else 0 end) As yes,
      SUM(CASE when attendance = 0 then 1 else 0 end) As no,
      SUM(CASE when attendance = 3 then 1 else 0 end) As ignored")
      ->where('event_id', $event->id)->first();
  }

  public function attendance(){
  	return $this->hasMany(Attendance::class);
  }
}
