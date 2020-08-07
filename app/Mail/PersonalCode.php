<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PersonalCode extends Mailable
{
    use Queueable, SerializesModels;

    public $personalCode;
    public $event;

    public function __construct($personalCode, $event)
    {
        $this->personalCode = $personalCode;
        $this->event = $event;
    }

    public function build()
    {
        return $this->markdown('emails.personalCode');
    }
}
