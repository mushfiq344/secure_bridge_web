<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveUser
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->is_active) {
            $user = auth()->user();
            auth()->logout();
            return redirect()->route('login')
                ->withError('Your account is');
        }

        return $next($request);
    }
}