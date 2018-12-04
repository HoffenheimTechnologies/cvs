<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Event;

class EventTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    // public function testGetActive(){
    //   $event = Event::find(13);
    //   $event = Event::getActive($event);
    //
    // }

    public function testGetUserStat(){
      $event = Event::find(13);
      $stat = Event::getUserStat($event);
      $this->assertEquals(gettype($stat),'object');
    }

}
