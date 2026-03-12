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
        // Schema::table('meeting_participants', function (Blueprint $table) {
        //         try {
        //             $table->dropForeign(['meeting_id']);
        //             $table->dropForeign(['user_id']);
        //         } catch (\Illuminate\Database\QueryException $e) {}
        //     });

          Schema::dropIfExists('meeting_participants');
          Schema::dropIfExists('meetings');

        Schema::create('external_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->time('hour');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('link')->nullable();
            $table->char('lead_id', 36);
            $table->timestamps();

            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_meetings');

        Schema::create('meetings', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('title');
            $table->date('date');
            $table->time('hour');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('link')->nullable(); // e.g. Zoom or Google Meet link
            $table->char('lead_id', 36)->nullable();
            $table->char('client_id', 36)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('meeting_participants', function (Blueprint $table) {
            $table->id();
            $table->char('meeting_id', 36);
            $table->char('user_id', 36);
            $table->enum('role', ['participant', 'organizer']);
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

    }
};
