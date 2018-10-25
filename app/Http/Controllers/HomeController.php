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
        if(Attendance::where('event_id', $pending_attendance->id)->where('user_id', $user->id)->first()){
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
      $attendance = Attendance::selectRaw('SUM(CASE when attendance = 1 then 1 else 0 end) As yes, SUM(CASE when attendance = 0 then 1 else 0 end) As no, (SELECT COUNT(events.id) FROM events LIMIT 1) as event')->where('user_id', $user)->first();
      return view('history', compact('attendance'));
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
      //check if attendance for that date has already been created by the user
      try {
        $exists = Attendance::where('user_id', $user)->where('event_id', $event_id)->get(['id'])->count();
        if($exists > 0){
          return response()->json(['status' => false, 'reason' => 'Attendance already marked']);
        }
      } catch (\Exception $e) {
        return response()->json(['status' => false, 'reason' => 'couldnt check attendance', "e" => $e]);
      }
      //mark the attendance
      try {
        Attendance::create([
          'attendance' => $attendance,
          'user_id' => $user,
          'event_id' => $event_id
        ]);
      } catch (\Exception $e) {
        return response()->json(['status' => false, "e" => $e]);
      }
      //return data
      return response()->json(['status' => true]);
    }

    public function admin(){
      return view('admin');
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
}
