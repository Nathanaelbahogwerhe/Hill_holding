<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Congé annuel', 'days' => 21],
            ['name' => 'Congé maladie', 'days' => 14],
            ['name' => 'Congé maternité', 'days' => 90],
            ['name' => 'Congé paternité', 'days' => 14],
            ['name' => 'Congé sans solde', 'days' => 30],
            ['name' => 'Congé formation', 'days' => 15],
            ['name' => 'Congé exceptionnel', 'days' => 5],
            ['name' => 'Congé de deuil', 'days' => 5],
            ['name' => 'Congé sabbatique', 'days' => 60],
            ['name' => 'Congé parental', 'days' => 30],
            ['name' => 'Congé pour événements familiaux', 'days' => 5],
            ['name' => 'Congé pour raisons personnelles', 'days' => 10],
            ['name' => 'Congé pour service civique', 'days' => 20],
            ['name' => 'Congé pour études', 'days' => 30],
            ['name' => 'Congé pour création d\'entreprise', 'days' => 30],
            ['name' => 'Congé pour mobilité internationale', 'days' => 60],
            ['name' => 'Congé pour adoption', 'days' => 30],
            ['name' => 'Congé pour soins médicaux', 'days' => 15],
            ['name' => 'Congé pour obligations légales', 'days' => 10],
            ['name' => 'Congé de circonstances', 'days' => 4],
        ];

        foreach ($types as $type) {
            LeaveType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}







