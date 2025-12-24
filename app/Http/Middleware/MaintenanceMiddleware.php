<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CmsSetting;

class MaintenanceMiddleware
{
    protected $excludedPaths = [
        'project',
        'project/*',
        'maintenance',
        'maintenance/*',
        'api/maintenance-status',
        'login',
        'logout',
        'register',
        'auth/*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Handle /maintenance path specially - redirect to login if not super admin
        if ($request->is('maintenance') || $request->is('maintenance/*')) {
            // If not logged in, redirect to login (no warning for guests)
            if (!auth()->check()) {
                return redirect('/login');
            }
            // If logged in but not super admin, redirect to landing page
            if (auth()->user()->email !== 'pedoprimasaragi@gmail.com') {
                return redirect('/');
            }
            // Super admin can proceed
            return $next($request);
        }
        
        // Always allow other excluded paths
        if ($this->isExcludedPath($request)) {
            return $next($request);
        }

        // Super admin can access everything
        if ($this->isSuperAdmin()) {
            return $next($request);
        }

        // Check if maintenance mode is ON
        if ($this->isMaintenanceMode()) {
            // Check if on root path (empty string)
            $path = $request->path();
            if ($path === '' || $path === '/') {
                return response()->view('maintenance', [], 503);
            }
            
            // All other paths: redirect to root
            return redirect('/');
        }

        return $next($request);
    }

    protected function isExcludedPath(Request $request): bool
    {
        foreach ($this->excludedPaths as $path) {
            if ($request->is($path)) {
                return true;
            }
        }
        return false;
    }

    protected function isSuperAdmin(): bool
    {
        return auth()->check() && auth()->user()->email === 'pedoprimasaragi@gmail.com';
    }

    protected function isMaintenanceMode(): bool
    {
        try {
            $setting = CmsSetting::where('key', 'maintenance_mode')->first();
            return $setting && $setting->value === 'true';
        } catch (\Exception $e) {
            return false;
        }
    }
}
