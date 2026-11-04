<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Fast2SmsService
{
    /**
     * Send numeric OTP via Fast2SMS OTP route (Instant Delivery, No DLT required).
     *
     * @param string $phoneNumber 10-digit Indian phone number
     * @param string|int $otp The OTP code
     * @return array
     */
    public static function sendOtp(string $phoneNumber, string|int $otp): array
    {
        $apiKey = config('services.fast2sms.key', env('FAST2SMS_API_KEY'));

        if (empty($apiKey)) {
            Log::warning('Fast2SMS: API Key is not configured in .env or config/services.php');
            return [
                'success' => false,
                'message' => 'Fast2SMS API key is not configured.'
            ];
        }

        // Clean phone number (strip +91, 0, spaces, dashes) to extract 10-digit number
        $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (strlen($cleanNumber) > 10) {
            $cleanNumber = substr($cleanNumber, -10);
        }

        if (strlen($cleanNumber) !== 10) {
            Log::warning("Fast2SMS: Invalid 10-digit phone number: {$phoneNumber}");
            return [
                'success' => false,
                'message' => 'Invalid phone number. Must be 10 digits.'
            ];
        }

        $route = config('services.fast2sms.route', env('FAST2SMS_ROUTE', 'q'));

        try {
            $payload = [
                'numbers' => $cleanNumber,
            ];

            if ($route === 'otp') {
                $payload['route'] = 'otp';
                $payload['variables_values'] = (string) $otp;
            } else {
                $payload['route'] = 'q';
                $payload['message'] = "Your ChowChak verification OTP is: {$otp}. Valid for 10 minutes.";
                $payload['language'] = 'english';
                $payload['flash'] = 0;
            }

            $response = Http::withoutVerifying()->withHeaders([
                'authorization' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://www.fast2sms.com/dev/bulkV2', $payload);

            $body = $response->json();

            if ($response->successful() && isset($body['return']) && $body['return'] === true) {
                Log::info("Fast2SMS: OTP sent successfully to {$cleanNumber}", [
                    'request_id' => $body['request_id'] ?? null
                ]);
                return [
                    'success' => true,
                    'message' => 'OTP sent successfully.',
                    'data' => $body
                ];
            }

            Log::error("Fast2SMS API error for {$cleanNumber}: " . json_encode($body));
            return [
                'success' => false,
                'message' => $body['message'][0] ?? 'Failed to send OTP via Fast2SMS',
                'data' => $body
            ];

        } catch (\Throwable $e) {
            Log::error("Fast2SMS exception: " . $e->getMessage(), [
                'phone' => $cleanNumber,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send generic Quick SMS (No DLT required).
     *
     * @param string $phoneNumber 10-digit phone number
     * @param string $message Text message
     * @return array
     */
    public static function sendQuickSms(string $phoneNumber, string $message): array
    {
        $apiKey = config('services.fast2sms.key', env('FAST2SMS_API_KEY'));

        if (empty($apiKey)) {
            return [
                'success' => false,
                'message' => 'Fast2SMS API key is not configured.'
            ];
        }

        $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (strlen($cleanNumber) > 10) {
            $cleanNumber = substr($cleanNumber, -10);
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'authorization' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://www.fast2sms.com/dev/bulkV2', [
                'route' => 'q',
                'message' => $message,
                'language' => 'english',
                'flash' => 0,
                'numbers' => $cleanNumber,
            ]);

            $body = $response->json();

            if ($response->successful() && isset($body['return']) && $body['return'] === true) {
                return [
                    'success' => true,
                    'message' => 'SMS sent successfully.',
                    'data' => $body
                ];
            }

            return [
                'success' => false,
                'message' => $body['message'][0] ?? 'Failed to send SMS',
                'data' => $body
            ];

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get Fast2SMS current wallet balance.
     *
     * @return array
     */
    public static function getWalletBalance(): array
    {
        $apiKey = config('services.fast2sms.key', env('FAST2SMS_API_KEY'));

        if (empty($apiKey)) {
            return ['success' => false, 'message' => 'API Key not set'];
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'authorization' => $apiKey,
            ])->get('https://www.fast2sms.com/dev/wallet');

            return $response->json() ?? [];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
