<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class LoginMiddleware
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
        if ($request->input('api_token')) {
            if (User::where('api_token', $request->input('api_token'))->first()) {
                return response()->json('API Token not Valid!', 400);
            } else {
                return $next($request);
            }
        } else {
            return response()->json('Enter the API token first!', 400);
        }
    }
}
