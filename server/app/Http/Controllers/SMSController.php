<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use App\Mail\Gmail;
use Illuminate\Support\Facades\Mail;

class SMSController extends Controller
{
    public function sendSMS(Request $request)
    {
        Nexmo::message()->send([
            'to' => $request->phoneNumber, // can send only to 237653371212 for now
            'from' => 'NdeTek',
            'text' => 'Hello World'
        ]);
        return 'Message Sent';
    }

    public function sendGmail(Request $request)
    {
        $body = "Thank you for registering under the NdeTek university";
        $details = [
            'title' => 'THE NDETEK UNIVERSITY APP',
            'body' => $body,
            'matricule' => $request->matricule,
            'password' => $request->password
        ];
        $gmail = new Gmail($details);
        Mail::to($request->email)->send($gmail);
        return response(['message' => 'Email sent successfully!']);
    }
}
