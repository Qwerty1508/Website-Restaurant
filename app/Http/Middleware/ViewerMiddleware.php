<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewerMiddleware
{
    /**
     * Handle an incoming request.
     * Viewer can only read (GET requests), cannot do any write operations.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isViewer()) {
            // Allow logout
            if ($request->routeIs('logout')) {
                return $next($request);
            }

            // Block all write operations for viewers
            if (!$request->isMethod('GET')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Akses ditolak. Akun Viewer hanya dapat melihat, tidak dapat melakukan perubahan.',
                        'error' => 'viewer_readonly'
                    ], 403);
                }
                
                return redirect()->back()->with('error', 'Akses ditolak. Akun Viewer hanya dapat melihat, tidak dapat melakukan perubahan.');
            }
        }

        return $next($request);
    }
}
