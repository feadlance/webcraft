<?php

namespace Webcraft\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OldLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ( empty(Auth::user()->email) ) {
        	return redirect()->route('auth.email');
        }

        return $next($request);
    }
}
