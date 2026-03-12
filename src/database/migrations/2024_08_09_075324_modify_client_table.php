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
            $table->string('industry');
            $table->string('acquisition_channel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'industry')) {
                $table->dropColumn('industry');
            }
            if (Schema::hasColumn('clients', 'acquisition_channel')) {
                $table->dropColumn('acquisition_channel');
            }
        });
    }
};

