<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->unique();
            $table->date('date');
            $table->decimal('total', 15, 2)->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('transaction_no');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
