<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the current primary key constraint
            $table->dropPrimary();
    
            // Changing the column type to char(36) for UUIDs
            $table->char('id', 36)->change();
    
            // Re-adding the primary key constraint
            $table->primary('id');
        });
    }
    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the current primary key constraint
            $table->dropPrimary();
    
            // Reverting 'id' back to its previous type (bigIncrements for auto-incremented IDs)
            $table->bigIncrements('id')->change();
    
            // Re-adding the primary key constraint
            $table->primary('id');
        });
    }
    
};

