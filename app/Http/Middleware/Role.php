<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!is_null(auth()->user())) {
            $allowedRoles = ['admin', 'hos', 'hod', 'teacher'];

            if (!in_array($role, $allowedRoles)) {
                return redirect('/login');
            }

            if (session('login_role') != $role) {
                return redirect($this->getRedirectUrl(session('login_role')));
            }

            if (!$request->user()->hasRole($role)) {
                return redirect($this->getRedirectUrl($role));
            }
        }

        return $next($request);
    }

    /**
     * Get the appropriate redirect URL based on the role.
     *
     * @param string $role
     * @return string
     */
    private function getRedirectUrl(string $role): string
    {
        switch ($role) {
            case 'admin':
                return '/';
            case 'hos':
                return '/hos';
            case 'hod':
                return '/hod';
            default:
                return '/teacher';
        }
    }
}
