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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address');
            }

            if (!Schema::hasColumn('users', 'dob')) {
                $table->date('dob');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender');
            }

            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position');
            }

            if (!Schema::hasColumn('users', 'doh')) {
                $table->date('doh');
            }

            if (!Schema::hasColumn('users', 'employment_status')) {
                $table->string('employment_status');
            }

            if (!Schema::hasColumn('users', 'department')) {
                $table->string('department')->nullable();
            }

            if (!Schema::hasColumn('users', 'salary')) {
                $table->string('salary')->nullable();
            }

            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo');
            }

            // Drop the email_verified_at column if it exists
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns that were added in the 'up' method
            $table->dropColumn([
                'phone',
                'address',
                'dob',
                'gender',
                'position',
                'doh',
                'employment_status',
                'department',
                'salary',
                'photo',
            ]);

            // Re-add the 'email_verified_at' column
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};

