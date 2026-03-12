<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            // Add project_id instead of sale_id
            $table->char('project_id', 36)->after('id');

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');

            $table->char('sale_id', 36)->after('id');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }
};

