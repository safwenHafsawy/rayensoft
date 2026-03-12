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
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('meta');
            $table->renameColumn('Title', 'title');
            $table->enum('type', ['internal', 'external', 'discovery'])->default('discovery')->after('title');
            $table->longText('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->json('meta')->nullable()->after('link');
            $table->renameColumn('title', 'Title');
            $table->enum('type', ['internal', 'external'])->default('external')->after('Title')->change();
        });
    }
};
