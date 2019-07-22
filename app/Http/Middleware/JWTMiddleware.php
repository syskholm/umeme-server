<?php

namespace App\Http\Middleware;

use Closure;

class JWTMiddleware
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
        if (app()->runningUnitTests()) {
            return $next($request);
        }

        $payload = JWTAuth::parseToken()->getPayload();

        $request->userData = $payload['userData'];

        return $next($request);
    }
}