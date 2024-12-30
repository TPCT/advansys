<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->header('accept-language'), array_keys(config('app.locales')))){
            session()->put('locale', $request->header('accept-language'));
        }
        else if (in_array($request->segment(1), array_keys(config('app.locales')))){
            session()->put('locale', $request->segment(1));
        }
        else{
            if (!session()->has('locale'))
                session()->put('locale', config('app.locale'));
            return redirect('/' . session('locale') . "/" . $request->path());
        }

        app()->setLocale(session('locale'));
        \URL::defaults(['locale' => session('locale')]);

        return $next($request);
    }
}
