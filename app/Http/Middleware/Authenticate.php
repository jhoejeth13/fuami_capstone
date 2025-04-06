<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Define public routes that don't require authentication
        $publicRoutes = [
            'tracer.form',
            'tracer.jhs-form', 
            'tracer.shs-form',
            'tracer.submit',
            'tracer.submit-jhs',
            'tracer.submit-shs'
        ];
        
        // If the current route is in the public routes, allow access without authentication
        if ($request->routeIs(...$publicRoutes)) {
            return $next($request);
        }
        
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        return redirect()->guest(route('login'));
    }
}