<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Attendance;

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
      return view('home');
    }

    public function history()
    {
        return 'history';
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
      $event_date = $request->event_date;
      //check if attendance for that date has already been created by the user
      try {
        $exists = Attendance::where('user_id', $user)->where('event_date', date('Y-m-d',strtotime($event_date)) )->get(['id'])->count();
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
          'event_date' => date('Y-m-d',strtotime($event_date))
        ]);
      } catch (\Exception $e) {
        return response()->json(['status' => false, "e" => $e]);
      }
      //return data
      return response()->json(['status' => true]);
    }
}
