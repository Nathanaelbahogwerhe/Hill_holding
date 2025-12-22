<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSchedule extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'nom',
        'type_rapport', // journalier, hebdomadaire, mensuel
        'frequence', // daily, weekly, monthly
        'jour_semaine', // 1-7 pour hebdomadaire
        'jour_mois', // 1-31 pour mensuel
        'heure_echeance',
        'department_id',
        'responsable_id',
        'filiale_id',
        'agence_id',
        'active',
        'derniere_soumission',
        'prochaine_echeance',
    ];

    protected $casts = [
        'active' => 'boolean',
        'derniere_soumission' => 'datetime',
        'prochaine_echeance' => 'datetime',
    ];

    /**
     * Relation vers le département
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relation vers le responsable
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    /**
     * Relation vers la filiale
     */
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    /**
     * Relation vers l'agence
     */
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    /**
     * Calculer la prochaine échéance
     */
    public function calculateNextDeadline()
    {
        $now = now();

        switch ($this->frequence) {
            case 'daily':
                $next = $now->copy()->addDay();
                break;

            case 'weekly':
                $next = $now->copy()->next($this->jour_semaine);
                if ($next->isSameDay($now)) {
                    $next->addWeek();
                }
                break;

            case 'monthly':
                $next = $now->copy()->day($this->jour_mois);
                if ($next->isPast()) {
                    $next->addMonth();
                }
                break;

            default:
                $next = $now->copy()->addDay();
        }

        if ($this->heure_echeance) {
            $time = explode(':', $this->heure_echeance);
            $next->hour($time[0])->minute($time[1] ?? 0);
        }

        $this->prochaine_echeance = $next;
        $this->save();

        return $next;
    }

    /**
     * Vérifier si en retard
     */
    public function isOverdue()
    {
        return $this->prochaine_echeance && $this->prochaine_echeance->isPast();
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOverdue($query)
    {
        return $query->where('prochaine_echeance', '<', now());
    }

    public function scopeDueSoon($query, $hours = 24)
    {
        return $query->whereBetween('prochaine_echeance', [now(), now()->addHours($hours)]);
    }
}
