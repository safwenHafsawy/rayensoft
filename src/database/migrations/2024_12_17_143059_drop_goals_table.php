<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key constraint on tasks table if it exists
        Schema::table('tasks', function (Blueprint $table) {
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'tasks' AND COLUMN_NAME = 'goal_id' 
                AND CONSTRAINT_NAME != 'PRIMARY'");

            if (!empty($foreignKeys)) {
                $table->dropForeign(['goal_id']);
            }
        });

        // Drop the 'tasks' table if it exists
        Schema::dropIfExists('tasks');

        // Drop the 'goals' table if it exists
        Schema::dropIfExists('goals');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the 'goals' table
        Schema::create('goals', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->char('project_id', 36);
            $table->char('user_id', 36);
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Recreate the 'tasks' table
        Schema::create('tasks', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('description')->nullable();
            $table->date('deadline');
            $table->string('status');
            $table->string('priority');
            $table->char('project_id');
            $table->char('user_id')->nullable();
            $table->char('goal_id')->nullable();
            // Adding foreign key back to 'goals' table
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('set null');
            $table->timestamps();
        });
    }
};
