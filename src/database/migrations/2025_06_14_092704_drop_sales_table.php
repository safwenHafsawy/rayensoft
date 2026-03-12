<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        // First: remove the foreign key and column in invoices (if it exists)
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'sale_id')) {
                $table->dropForeign(['sale_id']);
                $table->dropColumn('sale_id');
            }
        });

        // Then: drop the sales table
        Schema::dropIfExists('sales');
    }

    public function down(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('client_id', 36);
            $table->char('project_id', 36);
            $table->float('amount');
            $table->string('status');
            $table->date('sale_date');
            $table->string('offer');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
};
