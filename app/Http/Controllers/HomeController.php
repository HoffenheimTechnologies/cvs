<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Attendance;
use App\Event;
use App\User;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user = Auth::user();
      if (isset($request->success)) {
        // code...
        $success = $request->success;
        if ($request->success == 1) {
          // code...
          $message = 'You Have Successfully Registered';
          return view('home', compact('message', 'success'));
        }elseif($request->fail = -1){
          $message = 'You Have Successfully Registered';
        }else{
          $message = 'Attendance Marked';
          return view('home', compact('message', 'success'));
        }
      }
      $marked = false;
      //check for active event
      $pending_attendance = Event::where('active', '1')->first();
      if($pending_attendance){
        //check if user already marked the event attendance
        if(Attendance::where('event_id', $pending_attendance->id)->where('user_id', $user->id)
          ->where('attendance', '!=', 3)->first()){
          $marked = true;
        }
      }
      if($marked){
        return view('home');
      }else{
        return view('home', compact('pending_attendance'));
      }
    }

    public function history()
    {
      $user = Auth::user()->id;
      $attendance = Attendance::selectRaw("SUM(CASE when attendance = 1 then 1 else 0 end) As yes,
        SUM(CASE when attendance = 0 then 1 else 0 end) As no,
        SUM(CASE when attendance = 3 then 1 else 0 end) As ignored")
        ->where('user_id', $user)->first();
      $attendance_dates = Attendance::selectRaw('(CASE WHEN attendance = 1 then created_at end) as yesdates,
        (CASE WHEN attendance = 0 then created_at end) as nodates,
        (CASE WHEN attendance = 3 then created_at end) as ignoredates')
        ->where('user_id', $user)->get();
        // dd($attendance_dates);
      return view('history', compact('attendance', 'attendance_dates'));
    }

    public function profile()
    {
        return 'profile';
    }

    public function profileEdit()
    {
        return 'edit-profile';
    }

    public function mark(Request $request)
    {
      $user =  Auth::user()->id;
      $attendance = $request->attendance;
      $event_id = $request->event_id;
      //check if attendance for that date has already been marked by the user
      try {
        $exists = Attendance::where('user_id', $user)->where('event_id', $event_id)
          ->where('attendance', '!=', 3)->get(['id'])->count();
        if($exists > 0){
          return response()->json(['status' => false, 'reason' => 'Attendance already marked']);
        }
      } catch (\Exception $e) {
        return response()->json(['status' => false, 'reason' => 'couldnt check attendance', "e" => $e]);
      }
      //mark the attendance
      try {
        $active = Event::where('active', 1)->first()->id;
        $mark = Attendance::where('user_id', $user)->where('event_id', $active)->first();
        //probably the user might be a new user
        if (!$mark) {
          // code...
          Attendance::create([
            'attendance' => $attendance,
            'user_id' => $user,
            'event_id' => $active
          ]);
        }else{
          $mark->attendance = $attendance;
          $mark->save();
        }
      } catch (\Exception $e) {
        return response()->json(['status' => false, "e" => $e]);
      }
      //return data
      return response()->json(['status' => true]);
    }

    public function getevent(Request $request){
      $date = $request->date;
      $date = Event::where('event_date', $date)->first();
      if ($date) {
        // code...
        return response()->json(['success' => true, 'date' => $date]);
      }else{
        return response()->json(['success' => false]);
      }
    }
}
