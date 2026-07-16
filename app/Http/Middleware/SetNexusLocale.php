<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetNexusLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->user()?->locale ?? $request->session()->get('locale', config('app.locale', 'bg'));
        app()->setLocale(in_array($locale, ['bg', 'en'], true) ? $locale : 'bg');
        return $next($request);
    }
}

