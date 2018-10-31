<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\Event;
use App\User;
use Datatables;

class AdminController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }
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
        if ($request->draw) {
          // code...
          if ($request->history) {
            // code...
            $users = User::all();
            $history = collect(new Attendance);//[];
            foreach ($users as $key => $user) {
              // code...
              //array_push($history, Attendance::selectRaw('users.firstname, users.lastname, users.role,
              $attendance = Attendance::selectRaw('users.firstname, users.lastname, users.role,
                SUM(CASE when attendance = 1 then 1 else 0 end) As yes,
                SUM(CASE when attendance = 0 then 1 else 0 end) As no,
                SUM(CASE when attendance = 3 then 1 else 0 end) As ignored')
                ->where('user_id', $user->id)->join('users', 'attendances.user_id', 'users.id')->groupby('users.firstname', 'users.lastname', 'users.role')->first();
                $history->push($attendance);
            }
            return Datatables::of($history)->make();
          }

          if ($request->report) {
            // code...
            //initial
            $active = Event::where('active', '1')->first();
            $report = User::select('users.firstname', 'users.lastname','users.role', 'attendances.attendance', 'events.event_date')
              ->where('event_id', $active->id)->leftjoin('attendances', 'users.id', 'attendances.user_id')
              ->leftjoin('events', 'events.id', 'attendances.event_id')->get();
            return Datatables::of($report)->make();
          }

          if ($request->find) {
            // code...for finding event
            $squery_date = $request->sdate;
            $sdate = Event::where('event_date', $squery_date)->first();
            if ($sdate) {
              // code...
              $report = User::select('users.firstname', 'users.lastname','users.role', 'attendances.attendance', 'events.event_date')
                ->where('event_id', $sdate->id)->leftjoin('attendances', 'users.id', 'attendances.user_id')
                ->leftjoin('events', 'events.id', 'attendances.event_id')->get();
              return Datatables::of($report)->make();
              // return response()->json(['status' => true, 'message' => 'Success', 'report' => $report]);
            }else{
              $report = collect(new Attendance);
              return Datatables::of($report)->make();
              //return response()->json(['success' => false, 'date' => $squery_date]);
            }
          }
          //return response()->json(['status' => true, 'message' => 'Success', 'report' => $report, 'history' => $history]);
        }
        return 1;
      }
    }
}
