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
        Schema::create('leads', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('status');
            $table->string('industry');
            $table->string('lead_reason');
            $table->string('lead_source');
            $table->string('follow_up_date');
            $table->longText('notes')->nullable();
            $table->char('found_by_id', 36)->nullable();
            $table->timestamps();

            /** RELATIONS */
            $table->foreign('found_by_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

