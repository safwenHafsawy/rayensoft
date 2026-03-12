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
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'acquisition_channel', 'name', 'industry']);
            $table->char('lead_id', 36);

            /**
             * Relationship
             */
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // First, drop the foreign key constraint
            $table->dropForeign(['lead_id']); // Drop the foreign key
            $table->dropColumn('lead_id');     // Drop the lead_id column

            // Re-add the previously dropped columns
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('acquisition_channel')->nullable();
            $table->string('name')->nullable();
            $table->string('industry')->nullable();
        });
    }
};

