<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDateFilter
{
    /**
     * Si l'URL contient de nouveaux paramètres de date → on les stocke en session.
     * Sinon on remet dans la requête les dates de la session précédente.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('reset_dates')) {
            // Réinitialisation explicite du filtre
            session()->forget(['admin_date_debut', 'admin_date_fin']);
        } elseif ($request->has('date_debut') || $request->has('date_fin')) {
            // Stocker en session (null si vide)
            session([
                'admin_date_debut' => $request->input('date_debut') ?: null,
                'admin_date_fin'   => $request->input('date_fin')   ?: null,
            ]);
        } else {
            // Restaurer depuis la session dans la requête courante
            $request->merge([
                'date_debut' => session('admin_date_debut'),
                'date_fin'   => session('admin_date_fin'),
            ]);
        }

        return $next($request);
    }
}
