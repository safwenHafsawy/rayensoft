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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn('cover_letter');
            $table->string('country');
            $table->string('city');
            $table->string('street_address');
            $table->string('postal_code');
            $table->string('experience');
            $table->string('skills');
            $table->string('resume', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['country', 'city', 'street_address', 'postal_code', 'experience', 'skills']);
        });
    }
};

