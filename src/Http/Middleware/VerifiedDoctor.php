<?php

namespace Ambulatory\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedDoctor
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
        if (auth('ambulatory')->user()->isVerifiedDoctor()) {
            return $next($request);
        }

        return abort(403, 'Please verify your doctor profile first');
    }
}
