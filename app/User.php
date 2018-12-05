<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use App\Notifications\NewEventNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEventMail;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    // use Notifiable;
    use Notifiable, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstname', 'lastname', 'phone', 'role', 'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function attendance(){
      return $this->hasMany(Attendance::class);
    }

    public function Admin(){
        return $this->admin;
    }

    public static function notifyMe(User $user, Event $event){
      $event->name = (Service::find($event->service_id))->name;
      // send notification
      try {
        Log::debug('before mail');
        Mail::to($user)->send(new NewEventMail($event, $user));
        Log::debug('after mail');
      } catch (\Exception $e) {
        // judt log the error
        Log::debug($e);
      }
      try {
        Log::debug('after push');
        $user->notify(new NewEventNotification('New Attendance Available','Will you attend service on '.$event->end, $user->id, $event->id));
        Log::debug('before push');
      } catch (\Exception $e) {
        // judt log the error
        Log::debug($e);
      }
    }
}
