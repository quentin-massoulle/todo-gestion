<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');  // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
        }
        // Vérifie si l'utilisateur est un admin (is_admin doit exister et être égal à 1 pour un admin)
        if (auth()->user()->is_admin == 0) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('/')->with('error', __("validator.access_denied"));
        }

        // Si l'utilisateur est un admin, on continue la requête
        return $next($request);
    }
}
