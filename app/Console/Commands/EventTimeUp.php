<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Event;

class EventTimeUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:timeup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable events not active';

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
      //check for expired events
      $expired_events = Event::where('active', 1)->where('event_edate', '<', NOW())->get();
      print($expired_events);
      if($expired_events){
        //disable each expired events
        foreach ($expired_events as $key => $event) {
          // set event not active
          $event->active = 0;
          $event->save();
        }
      }
    }
}
