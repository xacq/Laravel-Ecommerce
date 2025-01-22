<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $messageData;

    public function __construct($messageData)
    {
        // Asegúrate de que $messageData no sea null
        if (is_null($messageData)) {
            $messageData = [];
        }
        $this->messageData = $messageData;
    }

    public function build()
    {
        return $this->view('emails.vendor_confirmation')
                    ->subject('Confirma tu cuenta de vendedor');
    }
}
