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
        $path = trim($request->path(), '/'); // ex: "task/1"
        $routes = Route::getRoutes();
        $routeExists = false;
    
        foreach ($routes as $route) {
            // On vérifie si la route correspond à la requête
            if ($this->matchUriToRoute($path, $route->uri())) {
                $routeExists = true;
                break;
            }
        }
    
        if (!$routeExists) {
            $segments = $request->segments();
            $prefix = $segments[0] ?? null;
    
            if ($prefix) {
                $dashboardUri = $prefix . '/dashboard';
    
                // Ne pas rediriger en boucle
                if ($path === $dashboardUri) {
                    return redirect('/');
                }
    
                foreach ($routes as $route) {
                    if ($route->uri() === $dashboardUri) {
                        return redirect('/' . $dashboardUri);
                    }
                }
            }
    
            return redirect('/');
        }
    
        return $next($request);
    }
    
    private function matchUriToRoute(string $path, string $routeUri): bool
    {
        // Transforme route comme "task/{id}" en regex "task/[^/]+"
        $pattern = preg_replace('/\{[^}]+\}/', '[^/]+', $routeUri);
        return preg_match("#^{$pattern}$#", $path);
    }
    
}
