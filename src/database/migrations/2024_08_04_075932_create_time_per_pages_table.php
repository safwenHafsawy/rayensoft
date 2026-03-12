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
        Schema::create('time_per_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page');
            $table->integer('timeSpent');
            $table->integer('number_of_visits');
            $table->string('session_id', 191);
            $table->timestamps();

             /**
             * Relationships
             */

            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_per_pages');
    }
};

