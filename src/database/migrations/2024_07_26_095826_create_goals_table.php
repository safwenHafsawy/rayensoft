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
        Schema::create('goals', function (Blueprint $table) {
            // Primary key as UUID (stored as char(36))
            $table->char('id', 36)->primary();
            
            // Other columns
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date');
            
            // Foreign keys using UUIDs (stored as char(36))
            $table->char('project_id', 36);
            $table->char('user_id', 36);
            
            // Adding foreign key constraints
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Timestamps
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};

