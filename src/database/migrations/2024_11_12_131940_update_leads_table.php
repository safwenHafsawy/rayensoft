<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Make 'industry' nullable
            $table->string('industry')->nullable()->change();

            // Make 'lead_reason' nullable
            $table->string('lead_reason')->nullable()->change();

            // Make 'lead_source' nullable
            $table->string('lead_source')->nullable()->change();

            // Make 'follow_up_date' nullable (adjust if it's a different type like datetime)
            $table->date('follow_up_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Revert 'industry' to non-nullable
            $table->string('industry')->nullable(false)->change();

            // Revert 'lead_reason' to non-nullable
            $table->string('lead_reason')->nullable(false)->change();

            // Revert 'lead_source' to non-nullable
            $table->string('lead_source')->nullable(false)->change();

            // Revert 'follow_up_date' to non-nullable (adjust if needed)
            $table->date('follow_up_date')->nullable(false)->change();
        });
    }

};
