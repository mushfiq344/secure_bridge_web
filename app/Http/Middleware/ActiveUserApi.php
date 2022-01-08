<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveUserApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->is_active) {
            return response()->json([ 'success' => false,"message"=>'your account is inactived',"data"=>[]],403);
        }

        return $next($request);
    }
}

