<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function createTransaction(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            $transaction = Transaction::create([
                'transaction_no' => Transaction::generateTransactionNo(),
                'date' => $data['date'] ?? now()->toDateString(),
                'total' => 0,
                'created_by' => auth()->id(),
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                $price = $product->price;
                $qty = $item['qty'];
                $subtotal = $price * $qty;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $qty);

                $total += $subtotal;
            }

            $transaction->update(['total' => $total]);

            return $transaction->load('details.product');
        });
    }

    public function getTransactionWithDetails(int $id): Transaction
    {
        return Transaction::with(['details.product', 'user'])->findOrFail($id);
    }
}
