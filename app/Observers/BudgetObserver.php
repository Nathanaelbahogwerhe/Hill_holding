<?php

namespace App\Observers;

use App\Models\Budget;
use Illuminate\Support\Facades\Log;

class BudgetObserver
{
    /**
     * Handle the Budget "created" event.
     */
    public function created(Budget $budget): void
    {
        // Initialiser les valeurs de suivi lors de la création
        if (is_null($budget->amount_used)) {
            $budget->amount_used = 0;
        }
        if (is_null($budget->percentage_used)) {
            $budget->percentage_used = 0;
        }
    }

    /**
     * Handle the Budget "updated" event.
     */
    public function updated(Budget $budget): void
    {
        // Recalculer le pourcentage si le montant ou amount_used a changé
        if ($budget->isDirty(['amount', 'amount_used'])) {
            $budget->percentage_used = $budget->amount > 0 
                ? ($budget->amount_used / $budget->amount * 100) 
                : 0;
        }

        // Log si le budget est dépassé
        if ($budget->isOverBudget()) {
            Log::warning("Budget dépassé", [
                'budget_id' => $budget->id,
                'title' => $budget->title,
                'amount' => $budget->amount,
                'amount_used' => $budget->amount_used,
                'percentage' => $budget->percentage_used,
            ]);
        }
    }

    /**
     * Handle the Budget "deleted" event.
     */
    public function deleted(Budget $budget): void
    {
        // Supprimer le fichier joint si existe
        if ($budget->attachment && \Storage::disk('public')->exists($budget->attachment)) {
            \Storage::disk('public')->delete($budget->attachment);
        }
    }
}
