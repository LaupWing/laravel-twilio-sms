<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
        dd($recipients);
    }

    public function send(Request $request) {
        if($request->has("phone_number")){
            $this->sendMessage($request->message, $request->phone_number);
            return response()->json([
                "message" => "It works"
            ]);
        }
        return response()->json([
            "error" => "Please provide an phonenumber"
        ]);
    }
}
