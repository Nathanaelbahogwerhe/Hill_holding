<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Revenue;

class RevenueSeeder extends Seeder
{
    public function run(): void
    {
        $revenues = [
            [
                'title' => 'Vente produit A',
                'amount' => 1500,
                'description' => 'Vente de produits au client X',
                'date' => now()->subDays(10),
                'filiale_id' => 1,
                'agence_id' => 1,
            ],
            [
                'title' => 'Service de consulting',
                'amount' => 800,
                'description' => 'Consulting IT pour le client Y',
                'date' => now()->subDays(5),
                'filiale_id' => 1,
                'agence_id' => 1,
            ],
        ];

        foreach ($revenues as $revenue) {
            Revenue::create($revenue);
        }
    }
}







