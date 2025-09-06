<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        // Replace backend URL with frontend URL for email verification
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        $verificationUrl = str_replace(
            config('app.url'),
            $frontendUrl . '/verify-email',
            $verificationUrl
        );

        return (new MailMessage)
            ->subject('Verify Your Email Address - Dev Lab')
            ->greeting('Welcome to Dev Lab!')
            ->line('Thank you for registering with Dev Lab. Please click the button below to verify your email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not create an account, no further action is required.')
            ->salutation('Best regards, The Dev Lab Team');
    }
}