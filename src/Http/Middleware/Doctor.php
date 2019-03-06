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
        $user = auth('reliqui')->user();

        if (! $user->isDoctor()) {
            throw new HttpException(403, 'Sorry, you are forbidden from accessing this page.');
        }

        if (blank($user->doctor()->first())) {
            throw new HttpException(403, 'Sorry, you do not have permission to create schedule yet. Please complete your profile as a doctor and create schedule again');
        }

        return $next($request);
    }
}
