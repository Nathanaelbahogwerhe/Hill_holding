<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Filiale;
use App\Models\Agence;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'first_name'    => $this->faker->optional()->firstName, // parfois null
            'last_name'     => $this->faker->optional()->lastName,  // parfois null
            // Correction : on ne dÃ©finit plus 'email' ici, il sera passÃ© par le seeder ou gÃ©nÃ©rÃ© aprÃ¨s crÃ©ation
            'department_id' => Department::inRandomOrder()->value('id'),
            'filiale_id'    => Filiale::inRandomOrder()->value('id'),
            'agency_id'     => Agence::inRandomOrder()->value('id'),
        ];
    }
}







