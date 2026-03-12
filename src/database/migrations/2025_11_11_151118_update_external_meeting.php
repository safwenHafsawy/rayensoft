<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\text;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('external_meetings', function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'concluded'])->default('pending')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_meetings', function (Blueprint $table) {
            Schema::table('external_meetings', function (Blueprint $table) {
                // Remove the new column
                $table->dropColumn('notes');

                // Revert the enum back to the original values
                $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                    ->default('pending')
                    ->change();
            });
        });
    }
};
