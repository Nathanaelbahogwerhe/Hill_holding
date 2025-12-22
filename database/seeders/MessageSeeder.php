<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        if ($employees->count() < 2) {
            $this->command->warn('â›” MessageSeeder : au moins 2 employés sont requis.');
            return;
        }

        // --- 1) Messages locaux : au sein de la màªme agence ---
        foreach ($employees as $sender) {
            if (!$sender->agency_id) continue; // ignorer si pas d'agence

            $colleagues = $employees->where('agency_id', $sender->agency_id)
                                    ->where('id', '!=', $sender->id);

            foreach ($colleagues as $recipient) {
                DB::table('messages')->updateOrInsert(
                    [
                        'sender_id'    => $sender->id,
                        'recipient_id' => $recipient->id,
                        'subject'      => "Annonce interne - {$sender->name}",
                    ],
                    [
                        'body'       => "Bonjour {$recipient->name}, ceci est une annonce interne de votre agence par {$sender->name}.",
                        'is_read'    => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // --- 2) Messages inter-agences et filiales : libre communication ---
        foreach ($employees as $sender) {
            foreach ($employees as $recipient) {
                if ($sender->id === $recipient->id) continue; // ignorer soi-màªme
                if ($sender->agency_id === $recipient->agency_id) continue; // déjà  couvert dans local

                DB::table('messages')->updateOrInsert(
                    [
                        'sender_id'    => $sender->id,
                        'recipient_id' => $recipient->id,
                        'subject'      => "Message de {$sender->name} à  {$recipient->name}",
                    ],
                    [
                        'body'       => "Bonjour {$recipient->name}, ceci est un message de {$sender->name}.",
                        'is_read'    => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $this->command->info('ðŸ“© MessageSeeder : messages locaux et globaux créés avec succès !');
    }
}







