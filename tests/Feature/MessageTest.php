<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Message;
use App\Models\Employee;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_employe_peut_envoyer_un_message_a_un_collaborateur_de_sa_agence()
    {
        // Seeder pour avoir des employÃ©s et agences
        $this->seed();

        $sender = Employee::first();
        $recipient = Employee::where('agency_id', $sender->agency_id)
                             ->where('id', '!=', $sender->id)
                             ->first();

        $message = Message::factory()->create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->assertDatabaseHas('messages', [
            'id'          => $message->id,
            'sender_id'   => $sender->id,
            'recipient_id'=> $recipient->id,
        ]);
    }

    /** @test */
    public function un_message_peut_etre_lu_ou_non()
    {
        $this->seed();

        $message = Message::factory()->create();

        $this->assertContains($message->is_read, [true, false]);
    }
}







