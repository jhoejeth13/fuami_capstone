<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // First, check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Get the user ID
        $userId = Auth::id();
        
        // Check if the user has the admin role by directly querying the database
        $hasAdminRole = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $userId)
            ->where('roles.name', 'admin')
            ->exists();
        
        if (!$hasAdminRole) {
            abort(403, 'Unauthorized action. You must be an admin to access this page.');
        }
        
        return $next($request);
    }
} 