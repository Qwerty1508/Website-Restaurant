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
        'status',
        'status/*',
        'login',
        'register',
        'logout',
        'auth/*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isExcludedPath($request)) {
            return $next($request);
        }

        if ($this->isSuperAdmin()) {
            return $next($request);
        }

        if ($this->isMaintenanceMode()) {
            return response()->view('maintenance', [], 503);
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
