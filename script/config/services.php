<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'pusher' => [
        'instance_id' => env('PUSHER_INSTANCE_ID'),
        'beam_secret' => env('PUSHER_BEAM_SECRET'),
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'organization_id' => env('OPENAI_ORGANIZATION_ID'),
        'model' => env('OPENAI_MODEL', 'gpt-4o'),
    ],

    'fast2sms' => [
        'key' => env('FAST2SMS_API_KEY'),
        'enabled' => env('FAST2SMS_ENABLED', true),
        'route' => env('FAST2SMS_ROUTE', 'q'),
    ],

    'msg91' => [
        'auth_key' => env('MSG91_AUTH_KEY'),
        'whatsapp_number' => env('MSG91_WHATSAPP_NUMBER'),
        'whatsapp_template' => env('MSG91_WHATSAPP_TEMPLATE', 'chowchak_access_code'),
    ],

];
