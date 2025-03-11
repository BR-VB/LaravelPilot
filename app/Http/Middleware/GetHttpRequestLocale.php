<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GetHttpRequestLocale
{
    //
    //Middleware - Api: get locale from http request header
    //
    public function handle(Request $request, Closure $next): Response
    {
        $apiLocale = config('app.locale');
        if ($request->hasHeader('Accept-Language')) {
            $apiLocale = $request->header('Accept-Language') ?? $apiLocale;
        }

        session(['apiLocale' => $apiLocale]);
        App::setLocale($apiLocale);

        Log::info(class_basename(self::class), [__('middleware.middleware_executed') => ['apiLocale' => $apiLocale]]);

        //next middleware step ...
        return $next($request);
    }
}
