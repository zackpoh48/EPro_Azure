<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class Log
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            $user = $request->user();
            $user_json = json_encode([
                "id" => $user->id,
                "unique_id" => $user->unique_id,
                "name" => $user->name,
                "email" => $user->email,
            ]);
        }

        $response = $next($request);

        $uniqueId = Str::uuid();

        $route = json_encode([
            "path" => $request->path(),
            "method" => $request->method(),
        ]);

        DB::table("logs")->insert([
            "unique_id" => $uniqueId,
            "route" => $route,
            "created_by" => $user_json ?? null,
            "request" => json_encode($request->input()),
            "response" => $response->content(),
            "created_at" => Carbon::now(),
        ]);

        $modifiedData = array_merge($response->getData(true), [
            "ref_id" => $uniqueId,
        ]);

        $response->setData($modifiedData);

        return $response;
    }
}
