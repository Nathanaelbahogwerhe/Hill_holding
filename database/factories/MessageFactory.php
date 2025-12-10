<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;
use App\Models\Employee;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        // RÃ©cupÃ¨re tous les employÃ©s pour choisir un destinataire alÃ©atoire
        $recipient = Employee::inRandomOrder()->first();

        return [
            'sender_id' => null, // sera dÃ©fini dans le seeder
            'recipient_id' => $recipient ? $recipient->id : null,
            'subject' => $this->faker->sentence(3),
            'body' => $this->faker->paragraph(),
            'is_read' => $this->faker->boolean(30), // 30% de chance que le message soit lu
        ];
    }

    /**
     * DÃ©finir un destinataire spÃ©cifique
     */
    public function to(Employee $employee)
    {
        return $this->state(function () use ($employee) {
            return [
                'recipient_id' => $employee->id,
            ];
        });
    }
}







