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

            // View Composer for Navbar (Notifications)
            \Illuminate\Support\Facades\View::composer('backend.layouts.partials.navbar', function ($view) {
                // Recent Incoming Mails (Last 2 days)
                $recentMails = \App\Models\IncomingMail::where('created_at', '>=', now()->subDays(2))
                    ->latest()
                    ->take(5)
                    ->get();

                // Pending Dispositions (For Admin/Headmaster)
                $pendingDispositions = \App\Models\Disposition::where('status', 'pending')
                    ->latest()
                    ->take(5)
                    ->get();

                $view->with('recentMails', $recentMails)
                    ->with('pendingDispositions', $pendingDispositions);
            });

        } catch (\Exception $e) {
            // Fallback if DB not ready
        }
    }
}
