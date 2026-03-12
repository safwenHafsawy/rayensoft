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
        Schema::create('lead_social_media_contacts', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('lead_id', 36);
            $table->text('instagram')->nullable();
            $table->text('facebook')->nullable();
            $table->text('linkedin')->nullable();
            $table->timestamps();

            /*
             * Relationships
             * */
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_social_media_contacts');
    }
};
