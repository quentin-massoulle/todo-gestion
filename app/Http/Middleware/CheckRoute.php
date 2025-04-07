<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Auth;

class CheckRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Récupère l'URI de la requête
        $uri = $request->path();

        // Récupérer toutes les routes définies
        $routes = \Route::getRoutes();

        // Vérifier si une route existe pour l'URI demandé
        $routeExists = false;
        foreach ($routes as $route) {
            if ($route->uri() == $uri) {
                $routeExists = true;
                break;
            }
        }

        // Si la route n'existe pas
        if (!$routeExists) {
            // Récupérer le premier segment de l'URL
            $segments = $request->segments();
            $prefix = $segments[0] ?? null;

            if ($prefix) {
                // Vérifier si la route /{prefix}/dashboard existe
                $dashboardUri = $prefix . '/dashboard';
                foreach ($routes as $route) {
                    if ($route->uri() == $dashboardUri) {
                        return redirect('/' . $dashboardUri);
                    }
                }
            }
            return redirect('/');
        }

        // Si la route existe, continuer normalement
        return $next($request);
    }

    
}
