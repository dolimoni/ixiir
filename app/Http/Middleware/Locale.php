<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('locale')) {
            session(['locale' => $request->getPreferredLanguage(config('app.locales'))]);
        }
        $locale = session('locale');
        app()->setLocale($locale);
        setlocale(LC_TIME, app()->environment('local') ? $locale : config('locale.languages')[$locale][1]);
        return $next($request);
    }
}
