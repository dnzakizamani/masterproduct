<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_no' => Transaction::generateTransactionNo(),
            'date' => fake()->dateTimeBetween('-1 month', 'now'),
            'total' => 0,
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the transaction is for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => now(),
        ]);
    }

    /**
     * Indicate that the transaction has a specific total.
     */
    public function withTotal(float $total): static
    {
        return $this->state(fn (array $attributes) => [
            'total' => $total,
        ]);
    }
}
