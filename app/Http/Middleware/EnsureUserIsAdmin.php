<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    //
    //Middleware: check if user has admin rights ... if not redirect to hone
    //
    public function handle(Request $request, Closure $next): Response
    {
        Log::info(class_basename(self::class), [__('middleware.middleware_executed')]);

        if (Auth::check() && Auth::user()->is_admin) {
            Log::info(class_basename(self::class), ['isAdminUser=true']);
            return $next($request);
        }

        return redirect()->route('home')->withError(__('middleware.is_admin_error'));
    }
}
