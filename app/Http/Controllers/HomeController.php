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
      $pending_attendance = Event::getActive();
      if($pending_attendance){
        //check if user already marked the event attendance
        if(Attendance::isMarked($pending_attendance, $user)){
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
      $user = Auth::user();
      $attendance = Attendance::getUserStat($user);
      $attendance_dates = Attendance::getUserHistoryDate($user);
        // dd($attendance_dates);
      return view('history', compact('attendance', 'attendance_dates'));
    }

    public function profile(Request $request)
    {
      $user = Auth::user();
      if ($request->action == 'edit') {
        $index = ['firstname','lastname','phone','gender','role', 'city','address1','address2','state','postalcode','country'];
        foreach ($index as $key => $value) {
          // code...
          if($request->$value){
            $user->$value = $request->$value;
          }
        }
        $user->save();
        return 'True';
      }
      return view('user.profile', compact('user'));
    }

    public function profileEdit()
    {
        return view('user.edit');
    }

    public function mark(Request $request)
    {
      $user =  Auth::user();
      $attendance = $request->attendance;
      $event = Event::find($request->event_id);
      //check if attendance for that date has already been marked by the user
      try {
        if(Attendance::isMarked($event, $user)){
          return response()->json(['status' => false, 'reason' => 'Attendance already marked']);
        }
      } catch (\Exception $e) {
        return response()->json(['status' => false, 'reason' => 'couldnt check attendance', "e" => $e]);
      }
      //mark the attendance
      try {
        $active = Event::getActive()->id;
        $mark = Attendance::where('user_id', $user->id)->where('event_id', $active)->first();
        //probably the user might be a new user
        if (!$mark) {
          // code...
          Attendance::create([
            'attendance' => $attendance,
            'user_id' => $user->id,
            'event_id' => $active
          ]);
        }else{
          $mark->attendance = $attendance;
          $mark->save();
        }
      } catch (\Exception $e) {
        return response()->json(['status' => false, "e" => $e->getMessage()]);
      }
      //return data
      return response()->json(['status' => true]);
    }

    public function getevent(Request $request){
      $date = $request->date;
      $date = Event::where('event_edate', $date)->first();
      if ($date) {
        // code...
        return response()->json(['success' => true, 'date' => $date]);
      }else{
        return response()->json(['success' => false]);
      }
    }
    public function at(){
      $at = Attendance::all();
      return response()->json(['at' => $at]);
    }
}
