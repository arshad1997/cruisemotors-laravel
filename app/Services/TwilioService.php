<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(config('twilio.sid'), config('twilio.token'));
    }

    public function sendVerificationCode($phoneNumber)
    {
        $verification = $this->client->messages->create(
            $phoneNumber,
            [
                'from' => config('twilio.phone_number'),
                'body' => 'Your verification code is: ' . rand(1000, 9999)
            ]
        );

        return $verification->sid;
    }
}
