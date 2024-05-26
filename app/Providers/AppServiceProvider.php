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

        $general_setting = GeneralSetting::firstOrFail();
        $logo_setting = LogoSetting::firstOrFail();
        $mailSetting = EmailConfiguration::firstOrFail();
        $pusherSetting = PusherSetting::firstOrFail();

        /**
         * Set Timezone
         */
        Config::set('app.timezone', $general_setting->timezone);

        /** Set Mail Config */
        Config::set('mail.mailers.smtp.host', $mailSetting->host);
        Config::set('mail.mailers.smtp.port', $mailSetting->port);
        Config::set('mail.mailers.smtp.encryption', $mailSetting->encryption);
        Config::set('mail.mailers.smtp.username', $mailSetting->username);
        Config::set('mail.mailers.smtp.password', $mailSetting->password);

        /** Set Broadcasting Config */
        Config::set('broadcasting.connections.pusher.key', $pusherSetting->pusher_key);
        Config::set('broadcasting.connections.pusher.secret', $pusherSetting->pusher_secret);
        Config::set('broadcasting.connections.pusher.app_id', $pusherSetting->pusher_app_id);
        Config::set('broadcasting.connections.pusher.options.host',
            "api-" . $pusherSetting->pusher_cluster . ".pusher.com");

        /**
         * Access settings at all views
         */
        View::composer('*', static function ($view) use ($general_setting, $logo_setting, $pusherSetting) {
            $view->with([
                'settings' => $general_setting,
                'logo_setting' => $logo_setting,
                'pusherSetting' => $pusherSetting
            ]);
        });
    }
}
