<?php

namespace App\Http\Middleware;

use Closure;

class JWTAuthenticate
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
        $this->decodePayload($request);
        $this->authenticate($request);
        return $next($request);
    }
}
