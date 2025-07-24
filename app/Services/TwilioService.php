<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
  public function sendWhatsApp($to, $message)
  {
    $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

    return $twilio->messages->create(
      "whatsapp:$to",
      [
        'from' => 'whatsapp:' . env('TWILIO_WHATSAPP_FROM'),
        'body' => $message
      ]
    );
  }
}
