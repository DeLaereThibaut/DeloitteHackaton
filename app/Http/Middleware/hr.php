<?php

namespace App\Http\Middleware;

use Closure;

class hr
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->guest() || auth()->user()->ambassadorType != "HR") return redirect('/');
        return $next($request);
    }
}
