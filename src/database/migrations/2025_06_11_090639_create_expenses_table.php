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
        Schema::create('expenses', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('title');
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->float('amount');
            $table->date('expense_date');
            $table->string('payment_method')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
