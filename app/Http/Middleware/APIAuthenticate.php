<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APIAuthenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $accessToken = base64_encode(
            env("API_SERVICE_CLIENT_ID") .
                ":" .
                env("API_SERVICE_CLIENT_SECRET")
        );

        if ($request->header("token") != $accessToken) {
            return response()->json(["message" => "Unauthenticated"], 401);
        }

        return $next($request);
    }
}
