<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Add this import
use Illuminate\Support\Facades\Log;  // For error logging

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
        try {
            $locationsPath = storage_path('app/locations');
            
            // Verify the directory exists and is readable
            if (!file_exists($locationsPath)) {
                Log::warning("Locations directory missing: {$locationsPath}");
            } elseif (!is_readable($locationsPath)) {
                Log::warning("Locations directory not readable: {$locationsPath}");
            }
            
            View::share('locationsPath', $locationsPath);
            
        } catch (\Exception $e) {
            Log::error("Failed to initialize locationsPath: " . $e->getMessage());
        }
    }
}