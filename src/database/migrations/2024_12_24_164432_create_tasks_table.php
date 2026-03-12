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
        Schema::create('tasks', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->char('assigned_to', 36);
            $table->date('due_date')->nullable();
            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical'])->default('Medium');
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Overdue', 'Cancelled'])->default('Pending');
            $table->boolean('is_reoccurring')->default(false);
            $table->text('completion_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
