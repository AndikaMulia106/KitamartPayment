<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role === 'admin' && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'user' && auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
    protected $routeMiddleware = [
    // ...
    'role' => \App\Http\Middleware\CheckRole::class,
    ];
}