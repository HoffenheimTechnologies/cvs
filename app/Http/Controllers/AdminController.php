<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\Event;
use App\User;

class AdminController extends Controller
{
    //

    public function event(){
      $active = Event::where('active', '1')->first();
      return view('admin', compact('active'));
    }

    public function eventCreate(Request $request){
      $event_date =  date('Y-m-d',strtotime($request->event_date));
      //check for past date
        if (NOW() >= $event_date)
        {
          return response()->json(['status' => false, 'reason' => 'Date already past']);
        }
      //check if already exists
      $exists = Event::where('event_date', $event_date)->get(['id'])->count();
        if($exists > 0){
          return response()->json(['status' => false, 'reason' => 'Event exists for that date']);
        }
      //try to create
      $create = Event::create([
        'event_date' => 1//$event_date,
      ]);
      if ($create) {
        # deactivate ative event
        $active = Event::where('active', 1)->where('id', '!=', $create->id)->get();
        foreach ($active as $key => $value) {
          # code...
          $value->active = 0;
          $value->save();
        }
        return response()->json(['status' => true]);
      }else{
        return response()->json(['status' => fale, 'reason' => 'Unkown error occured']);
      }
    }

    public function report(){
      return view('admin.report');
    }

    public function eventReport(){
      $users = User::all();
      $history = [];
      foreach ($users as $key => $user) {
        // code...
        array_push($history, Attendance::selectRaw('users.firstname, users.lastname, users.role,
          SUM(CASE when attendance = 1 then 1 else 0 end) As yes,
          SUM(CASE when attendance = 0 then 1 else 0 end) As no,
          (SELECT COUNT(events.id) FROM events LIMIT 1) as event')
          ->where('user_id', $user->id)->join('users', 'attendances.user_id', 'users.id')->groupby('users.firstname', 'users.lastname', 'users.role')->first());
      }
      //initial
      $active = Event::where('active', '1')->first();
      $report = User::where('event_id', $active->id)->leftjoin('attendances', 'users.id', 'attendances.user_id')->get();
      // $report = User::leftjoin('attendances', 'users.id', 'attendances.user_id')->get();
      return response()->json(['status' => true, 'message' => 'Success', 'report' => $report, 'history' => $history]);
    }
}
