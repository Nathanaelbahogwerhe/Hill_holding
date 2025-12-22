<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Transaction::create([
                'filiale_id'        => 1,
                'reference'         => strtoupper(Str::random(10)), // ðŸ”¹ Génère une référence unique
                'type'              => $i % 2 === 0 ? 'income' : 'expense',
                'amount'            => rand(1000, 500000),
                'description'       => "Transaction example {$i}",
                'transaction_date'  => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}







