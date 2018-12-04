<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Event;
use App\Service;
use App\User;
use App\Attendance;
use App\Notifications\NewEventNotification;
use Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEventMail;

class EventService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        //get todays day
        $today = date('l');

        //fetch services up for creation
        $services = Service::where('sdays', $today.'s')->get();

        if($services){
          // for each services up
          foreach ($services as $key => $service) {
            //get current date
            $now = NOW();
            //get the date of the end day
            $end = date('Y-m-d', strtotime($service->edays)).' 23:58:00';
            // create its event
            $create = Event::create([
              'service_id' => $service->id,
              'event_sdate' => $now,
              'event_edate' => $end//$end_date.' 23:58:00'
            ]);
            if ($create) {
              $users = User::select('id')->get();
              foreach ($users as $key => $user) {
                // code...
                Attendance::initiate($create, $user);
              }
              $users = User::all();
              foreach ($users as $key => $user) {
                User::notifyMe($user,$create);
              }
            }
          }
        }
    }
}
