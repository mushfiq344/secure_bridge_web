<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->user_type == 0) {
            return $next($request);
        } elseif (auth()->user()->user_type == 1) {
            return redirect('org-admin/home')->with('error', "You don't have user access.");
        } elseif (auth()->user()->user_type == 2) {
            return redirect('admin/home')->with('error', "You don't have user access.");
        }

    }
}