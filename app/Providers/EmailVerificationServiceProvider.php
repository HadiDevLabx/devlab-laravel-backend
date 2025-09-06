<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class EmailVerificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Customize the verification email to redirect to frontend
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            // Parse the Laravel verification URL to extract parameters
            $urlParts = parse_url($url);
            $queryString = $urlParts['query'] ?? '';
            
            // Build frontend URL by replacing the backend domain
            $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
            $frontendVerifyUrl = $frontendUrl . '/verify-email?' . $queryString;

            return (new MailMessage)
                ->subject('Verify Your Email Address - ShopEasy')
                ->greeting('Welcome to ShopEasy!')
                ->line('Thank you for signing up! Please click the button below to verify your email address.')
                ->action('Verify Email Address', $frontendVerifyUrl)
                ->line('This verification link will expire in 60 minutes.')
                ->line('If you did not create an account, no further action is required.')
                ->salutation('Best regards, The ShopEasy Team');
        });
    }
}
