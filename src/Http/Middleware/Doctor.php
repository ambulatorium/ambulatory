<?php

namespace Reliqui\Ambulatory\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $user = auth('ambulatory')->user();

        if (! $user->isDoctor()) {
            throw new HttpException(403, 'Sorry, you are forbidden from accessing this resources.');
        }

        if (blank($user->doctorProfile)) {
            throw new HttpException(403, 'Sorry, you are forbidden from accessing this resources. Please complete your doctor profile first');
        }

        return $next($request);
    }
}
