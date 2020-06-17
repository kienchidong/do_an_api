<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class loginOrNot
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->headers->get('authorization')) {
            $token = explode(' ', $request->headers->get('authorization'));
            $user = User::whereApiToken($token[1])->first();
            if($user){
                Auth::setUser($user);
            }
        }
        return $next($request);
    }
}
