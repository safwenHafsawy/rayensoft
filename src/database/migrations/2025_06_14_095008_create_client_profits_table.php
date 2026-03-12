<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('client_profits', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('project_id', 36);
            $table->date('month');
            $table->float('reported_profit');
            $table->float('calculated_cut');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unique(['project_id', 'month']); // prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_profits');
    }
};
