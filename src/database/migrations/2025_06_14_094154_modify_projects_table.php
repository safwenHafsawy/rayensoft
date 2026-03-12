<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
            Schema::table('projects', function (Blueprint $table) {
                $table->enum('payment_model', ['lump_sum', 'profit_share'])->default('lump_sum');
                $table->float('agreed_price')->nullable();        // For lump sum projects
                $table->float('profit_percentage')->nullable();   // For profit-share projects
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['payment_model', 'agreed_price', 'profit_percentage']);
        });
    }
};
