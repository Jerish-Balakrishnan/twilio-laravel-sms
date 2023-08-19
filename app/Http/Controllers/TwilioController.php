<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioController extends Controller
{
    public function sendSms(Request $request)
    {
        $recipient = $request->input('recipient');
        $messageBody = $request->input('message');

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilioNumber = env('TWILIO_PHONE');

        $client = new Client($sid, $token);

        try {
            $message = $client->messages->create(
                $recipient,
                [
                    'from' => $twilioNumber,
                    'body' => $messageBody
                ]
            );
            return response()->json(['status' => 'success', 'message' => 'SMS sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to send SMS. ' . $e->getMessage()]);
        }
    }
}
