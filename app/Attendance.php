<?php

namespace App;
use App\User;
use App\Attendance;
use App\Event;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = [
        'attendance', 'event_id', 'user_id'
    ];

  public static function getUserTotalStat(User $user){
    return Attendance::selectRaw('users.firstname, users.lastname, users.role,
      SUM(CASE when attendance = 1 then 1 else 0 end) As yes,
      SUM(CASE when attendance = 0 then 1 else 0 end) As no,
      SUM(CASE when attendance = 3 then 1 else 0 end) As ignored')
      ->where('user_id', $user->id)->join('users', 'attendances.user_id', 'users.id')->groupby('users.firstname', 'users.lastname', 'users.role')->first();
  }

  public static function isMarked(Event $event, User $user){
    return Attendance::where('event_id', $event->id)->where('user_id', $user->id)
      ->where('attendance', '!=', 3)->first();
  }

  public static function getUserStat(User $user){
    return Attendance::selectRaw("SUM(CASE when attendance = 1 then 1 else 0 end) As yes,
      SUM(CASE when attendance = 0 then 1 else 0 end) As no,
      SUM(CASE when attendance = 3 then 1 else 0 end) As ignored")
      ->where('user_id', $user->id)->first();
  }

  public static function getUserHistoryDate(User $user){
    return Attendance::selectRaw('(CASE WHEN attendance = 1 then updated_at end) as yesdates,
      (CASE WHEN attendance = 0 then updated_at end) as nodates,
      (CASE WHEN attendance = 3 then updated_at end) as ignoredates')
      ->where('user_id', $user->id)->get();
  }

  public function user(){
    return $this->belongsTo(User::class);
  }

  public function event(){
  	return $this->belongsTo(Event::class);
  }
}
