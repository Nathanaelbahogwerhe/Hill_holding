<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            [
                'name' => 'Laptop Dell',
                'category' => 'Informatique',
                'value' => 1200,
                'quantity' => 10, // ðŸ‘ˆ obligatoire maintenant
                'acquisition_date' => now()->subMonths(6),
                'status' => 'active',
                'description' => 'Ordinateur portable Dell pour le staff IT',
            ],
            [
                'name' => 'Imprimante HP',
                'category' => 'Informatique',
                'value' => 350,
                'quantity' => 5,
                'acquisition_date' => now()->subMonths(3),
                'status' => 'active',
                'description' => 'Imprimante laser HP pour le bureau',
            ],
            [
                'name' => 'Bureau en bois',
                'category' => 'Mobilier',
                'value' => 200,
                'quantity' => 15,
                'acquisition_date' => now()->subYears(1),
                'status' => 'active',
                'description' => 'Bureau en bois pour les employés',
            ],
            [
                'name' => 'Chaise ergonomique',
                'category' => 'Mobilier',
                'value' => 150,
                'quantity' => 20,
                'acquisition_date' => now()->subYears(1),
                'status' => 'active',
                'description' => 'Chaise ergonomique pour le confort des employés',
            ],
            [
                'name' => 'Projecteur Epson',
                'category' => 'Équipement audiovisuel',
                'value' => 800,
                'quantity' => 3,
                'acquisition_date' => now()->subMonths(8),
                'status' => 'active',
                'description' => 'Projecteur pour les présentations en salle de réunion',
            ],
            [
                'name' => 'Table de conférence',
                'category' => 'Mobilier',
                'value' => 600,
                'quantity' => 2,
                'acquisition_date' => now()->subYears(2),
                'status' => 'active',
                'description' => 'Grande table pour les réunions d\'équipe',
            ],
            [
                'name' => 'Serveur NAS Synology',
                'category' => 'Informatique',
                'value' => 1500,
                'quantity' => 1,
                'acquisition_date' => now()->subMonths(10),
                'status' => 'active',
                'description' => 'Serveur de stockage en réseau pour les données de l\'entreprise',
            ],
            [
                'name' => 'Téléphone IP Cisco',
                'category' => 'Télécommunications',
                'value' => 100,
                'quantity' => 25,
                'acquisition_date' => now()->subMonths(5),
                'status' => 'active',
                'description' => 'Téléphone IP pour les communications internes et externes',
            ],
            [
                'name' => 'Tablette iPad',
                'category' => 'Informatique',
                'value' => 400,
                'quantity' => 8,
                'acquisition_date' => now()->subMonths(4),
                'status' => 'active',
                'description' => 'Tablette pour les présentations mobiles et la prise de notes',
            ],
            [
                'name' => 'Caméra de sécurité',
                'category' => 'Sécurité',
                'value' => 250,
                'quantity' => 6,
                'acquisition_date' => now()->subMonths(7),
                'status' => 'active',
                'description' => 'Caméra pour la surveillance des locaux',
            ],
        ];

        foreach ($assets as $asset) {
            Asset::firstOrCreate([
                'name' => $asset['name'],
                'category' => $asset['category'],
                'value' => $asset['value'],
                'quantity' => $asset['quantity'],
            ], $asset);
        }
    }
}







