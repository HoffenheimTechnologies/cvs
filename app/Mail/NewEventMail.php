<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Event;
use App\Attendance;

class NewEventMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        //
        $this->$event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hello@cvms.trueworthfabrics.com.ng')
        ->with([
            'event' => $this->$event,
          ])
        ->view('mail.NewEventMail');
    }
}
