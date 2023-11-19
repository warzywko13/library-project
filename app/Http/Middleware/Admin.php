<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( isset(Auth()->user()->id) ) {
            if(Auth()->user()->isAdmin == 1) {
                return $next($request);
            }
        }

        abort(401);
    }
}
