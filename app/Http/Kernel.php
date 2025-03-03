<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Trust proxies for load balancers or cloud environments
        \App\Http\Middleware\TrustProxies::class,

        // Handle Cross-Origin Resource Sharing (CORS)
        \Illuminate\Http\Middleware\HandleCors::class, // Updated for Laravel 11

        // Prevent requests during maintenance mode
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Validate the size of incoming POST requests
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Trim strings in request data
        \App\Http\Middleware\TrimStrings::class,

        // Convert empty strings to null in request data
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            // Encrypt cookies
            \App\Http\Middleware\EncryptCookies::class,

            // Add queued cookies to the response
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // Start the session
            \Illuminate\Session\Middleware\StartSession::class,

            // Share errors from the session to views
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // Verify CSRF tokens for POST requests
            \App\Http\Middleware\VerifyCsrfToken::class,

            // Substitute route bindings
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Throttle API requests
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':60,1', // Updated syntax for Laravel 11

            // Substitute route bindings
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // Authenticate users
        'auth' => \App\Http\Middleware\Authenticate::class,

        // Authenticate users with HTTP Basic Auth
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // Substitute route bindings
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // Set cache headers for responses
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // Authorize user actions
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // Redirect authenticated users
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // Validate signed URLs
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Throttle requests
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Ensure the user's email is verified
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Spatie Laravel Permission Middleware
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class, // Added for convenience
    ];
}