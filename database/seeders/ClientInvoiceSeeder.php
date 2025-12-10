<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Str;

class ClientInvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            Invoice::updateOrCreate(
                ['client_id' => $client->id, 'invoice_number' => 'INV-' . Str::upper(Str::random(6))],
                [
                    'amount'       => rand(100, 1000),
                    'status'       => ['paid', 'pending'][rand(0, 1)],
                    'invoice_date' => now()->subDays(rand(0, 30)),
                ]
            );
        }
    }
}







