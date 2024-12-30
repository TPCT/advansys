<?php

namespace App\Http\Middleware;

use App\Helpers\Responses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->super_admin)
            return $next($request);
        return Responses::error([], 403, __("site.Unauthorized"));
    }
}
