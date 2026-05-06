<?php

namespace App\Providers;

use App\Services\SettingsService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the SettingsService as a singleton so it is only resolved once per request
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share the settings service with all Blade views automatically
        // You can now use $siteSettings->get('hospital_name') anywhere in your frontend
        View::composer('*', function ($view) {
            $view->with('siteSettings', app(SettingsService::class));
        });
    }
}
