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
        'event_date' => $event_date,
      ]);
      if ($create) {
        # deactivate ative event
        $active = Event::where('active', 1)->where('id', '!=', $create->id)->get();
        #set users that hasnt mark the active attendance to NULL
        //select users not in attendance with active event
        //$ignoring =  Users::select()->whereRaw()->with('users')->get();
        //get all users and make each attendance to the newly created event = NULL
        $users = User::select('id')->get();
        foreach ($users as $key => $value) {
          // code...
          Attendance::create([
            'attendance' => 3,
            'user_id' => $value->id,
            'event_id' => $create->id
          ]);
        }
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

    public function eventReport(Request $request){
      if ($request) {
        // code...
        if ($request->alltime) {
          // code...
          $users = User::all();
          $history = [];
          foreach ($users as $key => $user) {
            // code...
            array_push($history, Attendance::selectRaw('users.firstname, users.lastname, users.role,
              SUM(CASE when attendance = 1 then 1 else 0 end) As yes,
              SUM(CASE when attendance = 0 then 1 else 0 end) As no,
              SUM(CASE when attendance = 3 then 1 else 0 end) As ignored')
              ->where('user_id', $user->id)->join('users', 'attendances.user_id', 'users.id')->groupby('users.firstname', 'users.lastname', 'users.role')->first());
          }
          //initial
          $active = Event::where('active', '1')->first();
          $report = User::select('users.firstname', 'users.lastname','users.role', 'events.event_date', 'attendances.attendance')
            ->where('event_id', $active->id)->leftjoin('attendances', 'users.id', 'attendances.user_id')
            ->leftjoin('events', 'events.id', 'attendances.event_id')->get();
          return response()->json(['status' => true, 'message' => 'Success', 'report' => $report, 'history' => $history]);
        }elseif ($request->find) {
          // code...for finding event
          $query_date = $request->date;
          $date = Event::where('event_date', $query_date)->first();
          if ($date) {
            // code...
            $report = User::select('users.firstname', 'users.lastname','users.role', 'events.event_date', 'attendances.attendance')
              ->where('event_id', $date->id)->leftjoin('attendances', 'users.id', 'attendances.user_id')
              ->leftjoin('events', 'events.id', 'attendances.event_id')->get();
            return response()->json(['status' => true, 'message' => 'Success', 'report' => $report]);
          }else{
            return response()->json(['success' => false, 'date' => $query_date]);
          }
        }
      }else{

      }
    }
}
