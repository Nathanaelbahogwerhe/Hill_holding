<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;
use App\Models\Filiale;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que la filiale existe
        $filiale = Filiale::firstOrCreate(['id' => 1], ['name' => 'Maison mère']);

        $budgets = [
            [
                'title' => 'Budget Marketing 2025',
                'amount' => 10000,
                'description' => 'Campagnes et publicités',
                'start_date' => now()->startOfYear(),
                'end_date' => now()->endOfYear(),
                'filiale_id' => $filiale->id,
                'status' => 'active',
            ],
            [
                'title' => 'Budget RH 2025',
                'amount' => 15000,
                'description' => 'Salaires et formations',
                'start_date' => now()->startOfYear(),
                'end_date' => now()->endOfYear(),
                'filiale_id' => $filiale->id,
                'status' => 'active',
            ],
        ];

        foreach ($budgets as $budget) {
            Budget::create($budget);
        }
    }
}







