<?php

namespace Reliqui\Ambulatory\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('ambulatory')->user()->isAdmin()) {
            return $next($request);
        }

        throw new HttpException(403, 'Sorry, you are forbidden from accessing this resources.');
    }
}
