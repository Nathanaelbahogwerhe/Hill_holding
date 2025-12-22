<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait FilialeScope
{
    /**
     * Boot le trait pour appliquer automatiquement le scope
     */
    protected static function bootFilialeScope()
    {
        // Applique automatiquement le scope lors des requêtes
        static::addGlobalScope('filiale', function (Builder $builder) {
            $user = Auth::user();
            
            if (!$user) {
                return;
            }

            // Super Admin voit tout
            if ($user->hasRole('Super Admin')) {
                return;
            }

            // Si l'utilisateur appartient à une filiale, filtrer par filiale
            if ($user->filiale_id) {
                $builder->where('filiale_id', $user->filiale_id);
            }
        });
    }

    /**
     * Scope pour filtrer par filiale de l'utilisateur connecté
     */
    public function scopeForCurrentUser($query)
    {
        $user = Auth::user();

        if (!$user || $user->hasRole('Super Admin')) {
            return $query;
        }

        if ($user->filiale_id) {
            return $query->where('filiale_id', $user->filiale_id);
        }

        return $query;
    }

    /**
     * Scope pour obtenir toutes les données sans filtrage (pour Super Admin)
     */
    public function scopeWithoutFilialeScope($query)
    {
        return $query->withoutGlobalScope('filiale');
    }
}
