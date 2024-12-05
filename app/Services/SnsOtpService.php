<?php

namespace App\Services;

use Aws\Sns\SnsClient;
use Exception;

class SnsOtpService
{
    protected $snsClient;

    public function __construct()
    {
        $this->snsClient = new SnsClient([
            'version' => config('services.sns.version'),
            'region'  => config('services.sns.region'),
            'credentials' => [
                'key'    => config('services.sns.key'),
                'secret' => config('services.sns.secret'),
            ],
        ]);
    }

    /**
     * Send OTP via SMS using AWS SNS.
     *
     * @param string $phoneNumber E.164 format (e.g., +1234567890)
     * @param string $otpCode The OTP code to send.
     * @return bool|string
     */
    public function sendOtp($phoneNumber, $otpCode)
    {
        try {
            $message = "Your OTP code is: " . $otpCode;
            $result = $this->snsClient->publish([
                'Message' => $message,
                'PhoneNumber' => $phoneNumber,
            ]);
            return $result['MessageId']; // If successful, return MessageId
        } catch (Exception $e) {
            return false; // Return false if there is an error
        }
    }
}
