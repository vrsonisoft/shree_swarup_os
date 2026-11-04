<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Msg91WhatsAppService
{
    /**
     * Send OTP or Access Code via MSG91 WhatsApp Outbound API.
     *
     * @param string $phoneNumber Indian or international phone number
     * @param string|int $otp The OTP / Code
     * @param string $name Name or greeting label
     * @return array
     */
    public static function sendOtp(string $phoneNumber, string|int $otp, string $name = 'User'): array
    {
        $authKey = config('services.msg91.auth_key', env('MSG91_AUTH_KEY'));
        $integratedNumber = config('services.msg91.whatsapp_number', env('MSG91_WHATSAPP_NUMBER'));
        $templateName = config('services.msg91.whatsapp_template', env('MSG91_WHATSAPP_TEMPLATE', 'chowchak_access_code'));

        if (empty($authKey) || empty($integratedNumber)) {
            Log::warning('MSG91 WhatsApp: Missing AUTH_KEY or INTEGRATED_NUMBER.');
            return [
                'success' => false,
                'message' => 'MSG91 WhatsApp credentials are not configured.'
            ];
        }

        // Clean phone number (strip spaces, symbols)
        $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If 10 digits, prepend 91 for India
        if (strlen($cleanNumber) === 10) {
            $cleanNumber = '91' . $cleanNumber;
        }

        try {
            $payload = [
                'integrated_number' => $integratedNumber,
                'content_type' => 'template',
                'payload' => [
                    'messaging_product' => 'whatsapp',
                    'type' => 'template',
                    'template' => [
                        'name' => $templateName,
                        'language' => [
                            'code' => 'en',
                            'policy' => 'deterministic'
                        ],
                        'to_and_components' => [
                            [
                                'to' => [$cleanNumber],
                                'components' => [
                                    'body_1' => [
                                        'type' => 'text',
                                        'value' => (string) $name
                                    ],
                                    'body_2' => [
                                        'type' => 'text',
                                        'value' => (string) $otp
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $response = Http::withoutVerifying()->withHeaders([
                'authkey' => $authKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/', $payload);

            $body = $response->json();

            if ($response->successful() && isset($body['status']) && $body['status'] === 'success') {
                Log::info("MSG91 WhatsApp: OTP sent successfully to {$cleanNumber}", [
                    'response' => $body
                ]);
                return [
                    'success' => true,
                    'message' => 'WhatsApp OTP sent successfully.',
                    'data' => $body
                ];
            }

            Log::error("MSG91 WhatsApp API Error for {$cleanNumber}: " . json_encode($body));
            return [
                'success' => false,
                'message' => $body['message'] ?? ($body['errors'] ?? 'Failed to send WhatsApp message'),
                'data' => $body
            ];

        } catch (\Throwable $e) {
            Log::error("MSG91 WhatsApp Exception: " . $e->getMessage(), [
                'phone' => $cleanNumber,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }
}
