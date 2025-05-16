<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Auth;

class CheckRoute
{
    
    public function handle(Request $request, Closure $next)
    {
        $path = trim($request->path(), '/');
    
        if ($path === '') {
            return $next($request);
        }
    
        $routes = Route::getRoutes();
        $routeExists = false;
    
        foreach ($routes as $route) {
            if ($this->matchUriToRoute($path, $route->uri())) {
                $routeExists = true;
                break;
            }
        }
    
        if (!$routeExists) {
            $segments = $request->segments();
            $prefix = $segments[0] ?? null;
    
            if (!$prefix) {
                return $next($request);
            }
    
            $dashboardUri = $prefix . '/dashboard';
    
            if ($path === $dashboardUri) {
                return $next($request);
            }
    
            foreach ($routes as $route) {
                if ($route->uri() === $dashboardUri) {
                    return redirect('/' . $dashboardUri);
                }
            }
    
            return redirect('/');
        }
    
        return $next($request);
    }
    
    
    
    private function matchUriToRoute(string $path, string $routeUri): bool
    {
        $pattern = preg_replace('/\{[^}]+\}/', '[^/]+', $routeUri);
        return preg_match("#^{$pattern}$#", $path);
    }
    
}
