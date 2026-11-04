<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class CustomerEmailVerify extends BaseNotification
{

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
        $build = parent::build($notifiable);
        $appName = config('app.name', 'ChowChak');

        return $build
            ->subject($appName . ' - ' . __('email.emailVerification.subject'))
            ->view('emails.otp_verification', [
                'name' => $notifiable->name ?? 'User',
                'otp' => $notifiable->email_otp,
                'appName' => $appName,
                'type' => 'customer_verify',
                'expireMinutes' => 10,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

}
