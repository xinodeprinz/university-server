<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Vonage\Client\Credentials\Basic;
// use Vonage\Client;
// use Vonage\SMS\Message\SMS;
use Nexmo\Laravel\Facade\Nexmo;

class SMSController extends Controller
{
    // public function sendSMS(Request $request)
    // {
    //     $basic  = new Basic('bfhfghg');
    //     $client = new Client();
    //     $response = $client->sms()->send(
    //         new SMS("237653371212", 'NdeTek', 'A text message sent using the Nexmo SMS API')
    //     );
        
    //     $message = $response->current();
        
    //     if ($message->getStatus() == 0) {
    //         return "The message was sent successfully";
    //     } else {
    //         return "The message failed with status: " . $message->getStatus();
    //     }
    // }

    public function send(Request $request)
    {
        Nexmo::message()->send([
            'to' => $request->phoneNumber, // can send only to 237653371212 for now
            'from' => 'NdeTek',
            'text' => 'Hello World'
        ]);
        return 'Message Sent';
    }
}
