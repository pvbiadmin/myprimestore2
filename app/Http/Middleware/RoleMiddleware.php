<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->role !== $role) {
            return match ($request->user()->role) {
                'vendor' => redirect()->route('vendor.dashboard'),
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('user.dashboard')
            };
        }

        return $next($request);
    }
}
