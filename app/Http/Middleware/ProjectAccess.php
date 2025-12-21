<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProjectAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedEmails = [
            'pedoprimasaragi@gmail.com',
            'bernardprawira54@gmail.com',
            'haiidarmirza8289@gmail.com',
            'dimasaryadesta2@gmaiil.com',
            'dimasaryadesta2@gmail.com',
            'admin@super.admin',
        ];

        if (Auth::check() && in_array(Auth::user()->email, $allowedEmails)) {
            return $next($request);
        }

        return redirect('/');
    }
}
