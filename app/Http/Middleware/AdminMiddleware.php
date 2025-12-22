<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access if user is Admin OR Viewer (Viewer is read-only restricted by ViewerMiddleware)
        if (!auth()->check() || (!auth()->user()->isAdmin() && !auth()->user()->isViewer())) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
