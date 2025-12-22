<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\novacore;
use App\Models\Filiale;
use App\Models\Agence;
use App\Models\Employee;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'filiale_id',
        'agency_id',   // utilisé pour la relation User -> Agence
        'role_id',
        'role',        // pour vérifier superadmin
        'agence_id'    // pour compatibilité avec ExpenseController
    ];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Relations
     */
    public function novacore()
    {
        return $this->belongsTo(novacore::class);
    }

    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    // IMPORTANT : unifie agency_id et agence_id
    public function agency()
    {
        return $this->belongsTo(Agence::class, 'agency_id');
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class, 'agence_id'); // pour compatibilité
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }


    /**
     * -------------------------
     *   LOGIQUE D'AUTORISATION
     * -------------------------
     */

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function hasAccessToFiliale(?int $filialeId): bool
    {
        return $this->filiale_id && $this->filiale_id === $filialeId;
    }

    public function hasAccessToAgence(?int $agenceId): bool
    {
        // Supporte agency_id ET agence_id (évite les erreurs dans tes contrôleurs)
        return ($this->agency_id && $this->agency_id === $agenceId)
            || ($this->agence_id && $this->agence_id === $agenceId);
    }

    public function canAccessExpense($expense): bool
    {
        return $this->isSuperAdmin()
            || $this->hasAccessToFiliale($expense->filiale_id)
            || $this->hasAccessToAgence($expense->agence_id);
    }
}




