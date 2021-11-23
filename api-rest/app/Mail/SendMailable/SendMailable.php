<?php

namespace App\Mail\SendMailable;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
  
    public function __construct($name)
    {
         $this->name = $name;  
    }

    
    public function build()
    {
        return $this->view('email.name');
    }
}
