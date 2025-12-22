<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'amount',
        'amount_used',
        'percentage_used',
        'description',
        'start_date',
        'end_date',
        'filiale_id',
        'agence_id',
        'status',
        'attachment',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'amount' => 'decimal:2',
        'amount_used' => 'decimal:2',
        'percentage_used' => 'decimal:2',
    ];

    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    /**
     * Calculer le montant restant disponible
     */
    public function getAmountRemainingAttribute()
    {
        return $this->amount - $this->amount_used;
    }

    /**
     * Vérifier si le budget est dépassé
     */
    public function isOverBudget()
    {
        return $this->amount_used > $this->amount;
    }

    /**
     * Vérifier si le budget approche de sa limite (>= 80%)
     */
    public function isNearLimit()
    {
        return $this->percentage_used >= 80 && $this->percentage_used < 100;
    }

    /**
     * Obtenir le statut du budget
     */
    public function getBudgetStatusAttribute()
    {
        if ($this->isOverBudget()) {
            return 'exceeded'; // Dépassé
        } elseif ($this->isNearLimit()) {
            return 'warning'; // Alerte
        } elseif ($this->percentage_used > 0) {
            return 'active'; // En cours
        }
        return 'unused'; // Non utilisé
    }

    /**
     * Obtenir la couleur du statut pour l'affichage
     */
    public function getStatusColorAttribute()
    {
        return match($this->budget_status) {
            'exceeded' => 'red',
            'warning' => 'orange',
            'active' => 'green',
            'unused' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Mettre à jour l'utilisation du budget
     */
    public function updateUsage()
    {
        // Calculer le total des dépenses liées à ce budget
        $totalExpenses = \App\Models\Expense::where('filiale_id', $this->filiale_id)
            ->when($this->agence_id, fn($q) => $q->where('agence_id', $this->agence_id))
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->whereBetween('date', [$this->start_date, $this->end_date])
            ->sum('amount');

        $this->amount_used = $totalExpenses;
        $this->percentage_used = $this->amount > 0 ? ($totalExpenses / $this->amount * 100) : 0;
        $this->save();

        return $this;
    }

    /**
     * Scope pour les budgets actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    /**
     * Scope pour les budgets dépassés
     */
    public function scopeOverBudget($query)
    {
        return $query->whereRaw('amount_used > amount');
    }

    /**
     * Scope pour les budgets en alerte
     */
    public function scopeNearLimit($query)
    {
        return $query->whereRaw('percentage_used >= 80 AND percentage_used < 100');
    }
}




