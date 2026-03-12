<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign key and client_id column
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->char('client_id', 36)->after('id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
};
