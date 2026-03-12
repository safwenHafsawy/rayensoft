<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_balances', function (Blueprint $table) {
            $table->id();
            $table->float('amount'); // current bank balance
            $table->date('recorded_at'); // when this balance was logged
            $table->text('notes')->nullable(); // optional: for comments like "after rent payment"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_balances');
    }
};
