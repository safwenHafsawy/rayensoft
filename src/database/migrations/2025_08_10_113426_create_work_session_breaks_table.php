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
        Schema::create('work_session_breaks', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('work_session_id', 36);
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();

            $table->foreign('work_session_id')->references('id')->on('work_sessions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_session_breaks');
    }
};
