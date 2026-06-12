<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!file_exists(storage_path('installed'))) {
            if (!$request->is('install*')) {
                return redirect()->route('install.index');
            }
        }

        return $next($request);
    }
}
