<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyPasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check())
            if (Auth::user()->last_password_change_datetime == NULL || date('m', strtotime(Auth::user()->last_password_change_datetime)) == date('m') - 3)
                return redirect()->route('change-password');
            else
                return $next($request);

        else
            return $next($request);
    }
}
