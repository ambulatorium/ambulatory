<?php

namespace Ambulatory\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Doctor
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
        if (auth('ambulatory')->user()->isDoctor()) {
            return $next($request);
        }

        return abort(403, 'Sorry, you are forbidden from accessing this resources.');
    }
}
