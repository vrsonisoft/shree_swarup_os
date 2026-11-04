<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtp extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $recipientName = data_get($notifiable, 'name', __('app.user'));
        $appName = config('app.name', 'ChowChak');

        return (new MailMessage)
            ->subject($appName . ' - ' . __('auth.loginVerificationCode'))
            ->view('emails.otp_verification', [
                'name' => $recipientName,
                'otp' => $this->otp,
                'appName' => $appName,
                'type' => 'login',
                'expireMinutes' => 10,
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'otp' => $this->otp,
            'type' => 'login',
        ];
    }
} 