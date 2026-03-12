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
        Schema::table('messages', function (Blueprint $table) {
            $table->string('subject')->default('Work Proposal')->change();
            $table->string('status')->nullable();
            $table->string('chosenPlan')->nullable();
            $table->string('businessName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('businessName');
            $table->dropColumn('chosenPlan');
            $table->string('subject')->default(null)->change();
        });
    }
};

