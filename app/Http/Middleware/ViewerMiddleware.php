<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class ViewerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isViewer()) {
            if ($request->routeIs('logout')) {
                return $next($request);
            }
            $method = $request->method();
            if ($request->isMethod('POST') && $request->has('_method')) {
                $method = strtoupper($request->input('_method'));
            }
            if (!in_array(strtoupper($method), ['GET', 'HEAD', 'OPTIONS'])) {
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