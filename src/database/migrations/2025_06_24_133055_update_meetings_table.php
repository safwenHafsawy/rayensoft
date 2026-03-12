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
            // $table->enum('type', ['internal', 'external'])->default('external')->after('title');
            $table->char('lead_id', 36)->nullable();
            $table->char('client_id', 36)->nullable();

            $table->json('meta')->nullable()->after('link');

            $table->dropColumn(['name', 'email', 'phone', 'address', 'business_type', 'business_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['type', 'meta']);
            $table->string('name')->after('title');
            $table->string('email')->after('name');
            $table->string('phone')->after('email');
            $table->string('address')->after('phone');
            $table->string('business_type')->after('address');
            $table->string('business_name')->after('business_type');
        });
    }
};
