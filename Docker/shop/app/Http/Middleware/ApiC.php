<?php

namespace App\Http\Middleware;

use Closure;

class ApiC
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
        dd(123);
//        return $next($request);
    }
}
