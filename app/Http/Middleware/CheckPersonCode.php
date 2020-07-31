<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Cookie;

use Closure;

class CheckPersonCode
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
        // if(Cookie::get('personCode') !== null){
        //     return $next($request);
        // }
        // return redirect()->route('missing-user-code');
        return $next($request);
    }
}
