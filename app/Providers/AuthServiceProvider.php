<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\User;
use App\Policies\v1\PortfolioPolicy;
use App\Policies\v1\UserPolicy;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::createUrlUsing(function ($notifiable) {
            $params = [
                'expires' => Carbon::now()
                    ->addMinutes(60)
                    ->getTimestamp(),
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ];

            $url = URL::route('verification.verify', $params, true);

            $key = config('app.key');
            $signature = hash_hmac('sha256', $url, $key);

            return env('APP_AUTH_FRONT') .
                '/email-verify?id=' .
                $params['id'] .
                '&hash=' .
                $params['hash'] .
                '&expires=' .
                $params['expires'] .
                '&signature=' .
                $signature;
        });


        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->greeting('Welcome to atARTIST, ' . $notifiable->name)
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = env('APP_AUTH_FRONT') . '/reset-password?token=' . $token;

            return (new MailMessage)
                ->subject('Reset Password')
                ->greeting('Hi, ' . $notifiable->name . '!')
                ->line(
                    'Someone has requested to change your atARTIST password.
                    If you did make this request, click the button below:'
                )
                ->action('Reset Password', $url)
                ->line(
                    'If you didn\'t request this, please ignore this email.'
                );
        });
    }
}
