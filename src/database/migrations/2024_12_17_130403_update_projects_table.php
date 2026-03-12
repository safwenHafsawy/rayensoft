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
        Schema::table('projects', function (Blueprint $table) {
            // Drop columns
            $table->dropColumn(['deadline', 'code']);

            // Add new columns
            $table->string('phase')->nullable();
            $table->date('start_date')->nullable();

            // Modify existing column
            $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Recreate dropped columns
            $table->date('deadline')->nullable();
            $table->string('code')->nullable();

            // Drop added columns
            $table->dropColumn(['phase', 'start_date']);

            // Revert the column change
            $table->string('description')->change();
        });
    }
};

