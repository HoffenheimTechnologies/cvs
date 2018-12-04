<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
    	'event_sdate', 'active','event_edate','service_id',
	];

  public static function getActive(){
    $datetime = now("+1 hours");//substr(NOW(), 11,2);date("Y-m-d H:i:s", strtotime("+1 hours"))
    return Event::
    // select(\DB::raw('SUBSTRING(event_sdate,11,3) as sub', 'event_edate'))->
    where('active', '1')->where('event_sdate', '<=' , $datetime)->where('event_edate', '>=' , $datetime)->with('service')
    // ->where(\DB::raw('SUBSTRING(event_sdate,11,3)'), '<=' , $datetime)
    ->first();
  }

  public static function getActives(){
    $datetime = now("+1 hours");
    return Event::
    where('active', '1')->where('event_sdate', '<=' , $datetime)->where('event_edate', '>=' , $datetime)->with('service')
    ->get();
  }

  public static function getEventByEndDate($event_date){
    return Event::whereRaw("event_edate LIKE '$event_date%'")->first();
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

  public static function disableEvent(Event $event){
  	$event->active = !$event->active;
    $event->save();
    return $event->active;
  }

  public function attendance(){
  	return $this->hasMany(Attendance::class);
  }

  public function service(){
  	return $this->belongsTo(Service::class);
  }
}
