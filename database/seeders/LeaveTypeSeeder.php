<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'CongÃ© annuel', 'days' => 21],
            ['name' => 'CongÃ© maladie', 'days' => 14],
            ['name' => 'CongÃ© maternitÃ©', 'days' => 90],
            ['name' => 'CongÃ© paternitÃ©', 'days' => 14],
            ['name' => 'CongÃ© sans solde', 'days' => 30],
            ['name' => 'CongÃ© formation', 'days' => 15],
            ['name' => 'CongÃ© exceptionnel', 'days' => 5],
            ['name' => 'CongÃ© de deuil', 'days' => 5],
            ['name' => 'CongÃ© sabbatique', 'days' => 60],
            ['name' => 'CongÃ© parental', 'days' => 30],
            ['name' => 'CongÃ© pour Ã©vÃ©nements familiaux', 'days' => 5],
            ['name' => 'CongÃ© pour raisons personnelles', 'days' => 10],
            ['name' => 'CongÃ© pour service civique', 'days' => 20],
            ['name' => 'CongÃ© pour Ã©tudes', 'days' => 30],
            ['name' => 'CongÃ© pour crÃ©ation d\'entreprise', 'days' => 30],
            ['name' => 'CongÃ© pour mobilitÃ© internationale', 'days' => 60],
            ['name' => 'CongÃ© pour adoption', 'days' => 30],
            ['name' => 'CongÃ© pour soins mÃ©dicaux', 'days' => 15],
            ['name' => 'CongÃ© pour obligations lÃ©gales', 'days' => 10],
            ['name' => 'CongÃ© de circonstances', 'days' => 4],
        ];

        foreach ($types as $type) {
            LeaveType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}







