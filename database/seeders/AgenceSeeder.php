<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agence;
use App\Models\Filiale;

class AgenceSeeder extends Seeder
{
    public function run(): void
    {
        // Liste des agences avec leur filiale
        $agences = [
            [
                'code' => 'HH-BI-BUJ',
                'name' => 'Agence Bujumbura',
                'adresse' => 'Bujumbura, Burundi',
                'email' => 'bujumbura@hillholding.bi',
                'telephone' => '+257 111 222 333',
                'filiale_code' => 'HH-BI',
            ],
            [
                'code' => 'HH-RW-KIG',
                'name' => 'Agence Kigali',
                'adresse' => 'Kigali, Rwanda',
                'email' => 'kigali@HillHolding.rw',
                'telephone' => '+250 111 222 333',
                'filiale_code' => 'HH-RW',
            ],
            // Ajoute d’autres agences ici si nécessaire
        ];

        foreach ($agences as $data) {
            $filiale = Filiale::where('code', $data['filiale_code'])->first();

            if (!$filiale) {
                $this->command->warn("Filiale {$data['filiale_code']} non trouvée, l'agence {$data['code']} ne sera pas créée.");
                continue;
            }

            Agence::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'adresse' => $data['adresse'],
                    'email' => $data['email'],
                    'telephone' => $data['telephone'],
                    'filiale_id' => $filiale->id,
                ]
            );
        }

        $this->command->info("âœ… Agences seedées avec succès !");
    }
}







