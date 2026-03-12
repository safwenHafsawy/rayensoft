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
        Schema::create('goal_work_session', function (Blueprint $table) {
            $table->id();
            $table->char('goal_id', 36);
            $table->char('work_session_id', 36);

            $table->foreign('goal_id')
                ->references('id')->on('goals')
                ->onDelete('cascade');

            $table->foreign('work_session_id')
                ->references('id')->on('work_sessions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_work_session');
    }
};
