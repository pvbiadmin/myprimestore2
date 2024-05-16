<?php

namespace App\Providers;

use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Get default values from the .env file
        $defaultGeneralSetting = [
            'timezone' => config('app.timezone', 'Asia/Manila'),
        ];

        $defaultMailSetting = [
            'host' => config('mail.mailers.smtp.host', 'sandbox.smtp.mailtrap.io'),
            'port' => config('mail.mailers.smtp.port', 2525),
            'encryption' => config('mail.mailers.smtp.encryption', 'tls'),
            'username' => config('mail.mailers.smtp.username', 'ad1ae6abb4512c'),
            'password' => config('mail.mailers.smtp.password', '6cfba444153ea8'),
        ];

        $defaultPusherSetting = [
            'pusher_key' => config(
                'broadcasting.connections.pusher.key', 'bc17b66f451cd0eab1f5'),
            'pusher_secret' => config(
                'broadcasting.connections.pusher.secret', '801dce42885a52b82c17'),
            'pusher_app_id' => config(
                'broadcasting.connections.pusher.app_id', '1791095'),
            'pusher_cluster' => config(
                'broadcasting.connections.pusher.options.cluster', 'ap1'),
        ];

        // Fetch data from database or use defaults if not available
        $general_setting = GeneralSetting::first() ?? (object) $defaultGeneralSetting;
        $logo_setting = LogoSetting::first();
        $mailSetting = EmailConfiguration::first() ?? (object) $defaultMailSetting;
        $pusherSetting = PusherSetting::first() ?? (object) $defaultPusherSetting;

        // Set Timezone
        Config::set('app.timezone', $general_setting->timezone);

        // Set Mail Config
        Config::set('mail.mailers.smtp.host', $mailSetting->host);
        Config::set('mail.mailers.smtp.port', $mailSetting->port);
        Config::set('mail.mailers.smtp.encryption', $mailSetting->encryption);
        Config::set('mail.mailers.smtp.username', $mailSetting->username);
        Config::set('mail.mailers.smtp.password', $mailSetting->password);

        // Set Broadcasting Config
        Config::set('broadcasting.connections.pusher.key', $pusherSetting->pusher_key);
        Config::set('broadcasting.connections.pusher.secret', $pusherSetting->pusher_secret);
        Config::set('broadcasting.connections.pusher.app_id', $pusherSetting->pusher_app_id);
        Config::set('broadcasting.connections.pusher.options.host',
            "api-" . $pusherSetting->pusher_cluster . ".pusher.com");

        // Access settings at all views
        View::composer('*', static function ($view) use ($general_setting, $logo_setting, $pusherSetting) {
            $view->with([
                'settings' => $general_setting,
                'logo_setting' => $logo_setting,
                'pusherSetting' => $pusherSetting
            ]);
        });
    }
}
