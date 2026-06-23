<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some products for transactions
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Skipping transaction seeding.');
            return;
        }

        // Create 20 transactions
        $transactions = Transaction::factory()
            ->count(20)
            ->create();

        // For each transaction, create 1-5 details
        foreach ($transactions as $transaction) {
            $detailCount = rand(1, 5);
            $total = 0;

            for ($i = 0; $i < $detailCount; $i++) {
                $product = $products->random();
                $qty = rand(1, 5);
                $price = $product->price;
                $subtotal = $qty * $price;
                $total += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update transaction total
            $transaction->update(['total' => $total]);
        }

        $this->command->info('Created ' . $transactions->count() . ' transactions with details.');
    }
}
