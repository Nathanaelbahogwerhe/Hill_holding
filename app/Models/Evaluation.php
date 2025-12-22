<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'type',
        'note',
        'commentaires',
        'points_forts',
        'points_amelioration',
        'recommandations',
        'evaluable_type',
        'evaluable_id',
        'evaluateur_id',
        'evaluated_user_id',
        'filiale_id',
        'agence_id',
    ];

    /**
     * Relation polymorphique
     */
    public function evaluable()
    {
        return $this->morphTo();
    }

    /**
     * Relation vers l'évaluateur
     */
    public function evaluateur()
    {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    /**
     * Relation vers l'évalué (pour les évaluations d'employés)
     */
    public function evaluatedUser()
    {
        return $this->belongsTo(User::class, 'evaluated_user_id');
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
     * Scopes
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Attributs calculés
     */
    public function getNoteColorAttribute()
    {
        if ($this->note >= 80) return 'green';
        if ($this->note >= 60) return 'yellow';
        if ($this->note >= 40) return 'orange';
        return 'red';
    }

    public function getNoteBadgeAttribute()
    {
        $color = $this->note_color;
        return "<span class='bg-{$color}-600 text-white px-2 py-1 rounded text-xs'>{$this->note}%</span>";
    }
}
