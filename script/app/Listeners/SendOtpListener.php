<?php

namespace App\Listeners;

use App\Events\SendOtpEvent;
use App\Notifications\SendOtp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOtpListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendOtpEvent $event): void
    {
        try {
            $event->user->notify(new SendOtp($event->otp));

            if (!empty(config('services.msg91.auth_key')) && !empty($event->user->phone_number)) {
                \App\Services\Msg91WhatsAppService::sendOtp($event->user->phone_number, $event->otp, $event->user->name ?? 'User');
            } elseif (config('services.fast2sms.enabled') && !empty($event->user->phone_number)) {
                \App\Services\Fast2SmsService::sendOtp($event->user->phone_number, $event->otp);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send OTP notification: ' . $e->getMessage(), [
                'user_id' => $event->user->id,
                'email' => $event->user->email,
                'otp' => $event->otp,
                'type' => $event->type
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(SendOtpEvent $event, \Throwable $exception): void
    {
        Log::error('OTP notification job failed: ' . $exception->getMessage(), [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'otp' => $event->otp,
            'type' => $event->type
        ]);
    }
} 