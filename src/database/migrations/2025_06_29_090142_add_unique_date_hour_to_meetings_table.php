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
        Schema::table('meetings', function (Blueprint $table) {
            $table->unique(['date', 'hour'], 'unique_date_hour');
            // This adds a unique constraint on the combination of 'date' and 'hour' columns
            // The second parameter 'unique_date_hour' is the name of the constraint
            // This ensures that no two meetings can have the same date and hour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropUnique('unique_date_hour');
            // This removes the unique constraint on the combination of 'date' and 'hour' columns
            // It allows multiple meetings to have the same date and hour again
        });
    }
};
