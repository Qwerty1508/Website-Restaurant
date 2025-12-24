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
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Always allow excluded paths
        if ($this->isExcludedPath($request)) {
            return $next($request);
        }

        // Super admin can access everything
        if ($this->isSuperAdmin()) {
            return $next($request);
        }

        // Check if maintenance mode is ON
        if ($this->isMaintenanceMode()) {
            // If on root path, show maintenance page
            if ($request->is('/') || $request->path() === '/') {
                return response()->view('maintenance', [], 503);
            }
            
            // All other paths: redirect to root (which shows maintenance)
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
