<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->locale;
        $els = config('language.enabled_languages', []);
        if (!empty($els) && is_array($els)) {
            if (!in_array($locale, $els)) {
                throw new HttpException(422, 'The local not available.');
            }
        }
        App::setLocale($locale);

        return $next($request);
    }
}
