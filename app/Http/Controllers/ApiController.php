<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Attendance;
use App\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\MarkedAttendance;

class ApiController extends Controller
{
    //
    public function status(Request $request){
      $status = new \stdClass();
      if (isset($request->message)) {
        foreach ($request->message as $key => $value) {
          // code...
          $status->$key = $value;
        }
        // code...
        return view('status', compact('status'));
      }
      return view('status', compact('status'));
    }

    public function mark(Request $request)
    {
      $user = User::findOrFail($request->user_id);
      $attendance = $request->attendance;
      $event = Event::find($request->event_id);
      $status = false;
      $message = NULL;
      $error = NULL;
      $continue = true;
      //check if attendance for that date has already been marked by the user
      if ($continue) {
        // code...
        try {
          if(Attendance::isMarked($event, $user)){
            $message = 'Attendance already marked';
            $continue = false;
          }
        } catch (\Exception $e) {
          $message =  'couldnt check attendance'; $error =  $e;
          $continue = false;
        }
      }

      if ($continue) {
        // code...
        //mark the attendance
        try {
          $active = $event;//Event::getActive();
          $mark = Attendance::where('user_id', $user->id)->where('event_id', $active->id)->first();
          //probably the user might be a new user
          if (!$mark) {
            // code...
            $created = Attendance::create([
              'attendance' => $attendance,
              'user_id' => $user->id,
              'event_id' => $active->id
            ]);
          }else{
            $mark->attendance = $attendance;
            $mark->save();
            //notify successfull attendance
            $user->notify(new \App\Notifications\WebNotice('Attendance Marked', 'You will '.($attendance ? 'attend ' : 'not attend ').explode(' ', $active->event_edate)[0].' event', route('home')));
            try {
              Mail::to($user)->send(new MarkedAttendance($active, $mark));
            } catch (\Exception $e) {
              $status = true; $error = $e;
            }

          }
        } catch (\Exception $e) {
           $error = $e;
           $continue = false;
        }
      }

      //return data
      return redirect(route('api.status'))->with('status', $status,      'message', $message,      'error', $error);
    }
}
