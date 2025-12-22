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
        // Récupère tous les employés pour choisir un destinataire aléatoire
        $recipient = Employee::inRandomOrder()->first();

        return [
            'sender_id' => null, // sera défini dans le seeder
            'recipient_id' => $recipient ? $recipient->id : null,
            'subject' => $this->faker->sentence(3),
            'body' => $this->faker->paragraph(),
            'is_read' => $this->faker->boolean(30), // 30% de chance que le message soit lu
        ];
    }

    /**
     * Définir un destinataire spécifique
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







