<?php

namespace App\Providers;

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
        // Share Settings Globally
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all()->pluck('value', 'key');
                \Illuminate\Support\Facades\View::share('school_name', $settings['school_name'] ?? 'TataPro System');
                \Illuminate\Support\Facades\View::share('school_logo', $settings['school_logo'] ?? null);
                \Illuminate\Support\Facades\View::share('school_settings', $settings); // Share all for flexibility
            }
        } catch (\Exception $e) {
            // Fallback if DB not ready
        }
    }
}
