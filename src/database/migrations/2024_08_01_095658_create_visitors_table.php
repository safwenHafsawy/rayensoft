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
        Schema::create('visitors', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('ip_address');
            $table->string('session_id');
            $table->string('user_agent');
            $table->string('location');
            $table->unsignedInteger('visited_pages_count')->default(1);
            $table->timestamp('visited_at')->useCurrent();

            $table->string('last_page')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

