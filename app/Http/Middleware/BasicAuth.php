<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $logged = false;
        if (
            $request->header("PHP_AUTH_USER", null) &&
            $request->header("PHP_AUTH_PW", null)
        ) {
            $username = $request->header("PHP_AUTH_USER");
            $password = $request->header("PHP_AUTH_PW");

            if (
                $username === env("BASIC_AUTH_USERNAME") &&
                $password === env("BASIC_AUTH_PASSWORD")
            ) {
                $logged = true;
            }
        }

        if ($logged === false) {
            return $this->errorResponse("Unauthenticated", 401);
        }
        return $next($request);
    }
}
