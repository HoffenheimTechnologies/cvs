<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\Event;
use App\User;
use Datatables;
use App\Service;
use App\Notifications\NewEventNotification;
use Notification;

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
      if ($active = Event::getActive()){
        $stat = Event::getUsersStat($active);
      }else{
        $stat = [];
        $active = new Event();
      }
      return view('admin', compact('active', 'stat'));
    }

    public function eventCreate(Request $request){
      $event_sdate =  $request->event_sdate;
      $event_edate =  $request->event_edate;//date('Y-m-d',strtotime());
      //check for past date
        if (NOW() > $event_edate)
        {
          return response()->json(['status' => false, 'reason' => 'Date already past']);
        }
      //check if already exists
      // $exists = Event::where('event_sdate', $event_edate)->get(['id'])->count();
      //   if($exists > 0){
      //     return response()->json(['status' => false, 'reason' => 'Event exists for that date']);
      //   }
      //try to create
      $create = Event::create([
        'event_sdate' => $event_sdate,
        'event_edate' => $event_edate,
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
        $users = User::all();
        foreach ($users as $key => $user) {
          // code...
          $user->notify(new NewEventNotification('New Attendance Available','Will you attend service on '.$event_edate, $user->id, $create->id));
        }
        // Notification::send($user = User::all(), );
        return response()->json(['status' => true]);
      }else{
        return response()->json(['status' => false, 'reason' => 'Unkown error occured']);
      }
    }

    public function report(){
      return view('admin.report');
    }

    public function sendNotification(Request $request)
    {
        $request->user()->notify(new GenericNotification('Title', 'Body'));

        return response()->json('Notification sent.', 201);
    }

    public function eventReport(Request $request){
      if ($request) {
        // if request from datatables
        if ($request->draw) {
          // code...
          if ($request->history) {
            // code...
            $users = User::all();
            $history = collect(new Attendance);//[];
            foreach ($users as $key => $user) {
              //array_push($history, Attendance::selectRaw('users.firstname, users.lastname, users.role,
              $attendance = Attendance::getUserTotalStat($user);
                $history->push($attendance);
            }
            return Datatables::of($history)->make();
          }
          //for finding report
          if ($request->find || $request->report) {
            if ($request->find) {
              // code...for finding event
              $event_date = $request->sdate;
              $event = Event::getEventByEndDate($event_date);
            }else {
              //initial
              $event = Event::getActive();
            }

            if ($event) {
              // code...
              $report = Event::getUserStat($event);
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

    public function createService(Request $request){
      $name = $request->name;
      $sdays = $request->sdays;
      $edays = $request->edays;
      //check conflit name

      //create service
      $service = Service::create([
        'name' => $name,
        'sdays' => $sdays,
        'edays' => $edays,
      ]);
      if ($service) {
        // code...
        return response()->json(['status' => true]);
      }
      return;
    }
}
