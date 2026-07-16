<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Symfony\Component\HttpFoundation\Response;
class EnsureNexusIsInstalled { public function handle(Request $request, Closure $next): Response { $installed=app()->environment('testing')||is_file(storage_path('app/nexus-installed')); if(!$installed&&!$request->routeIs('install','install.store','up')) return redirect()->route('install'); if($installed&&$request->routeIs('install','install.store')) return redirect()->route('home'); return $next($request); } }
