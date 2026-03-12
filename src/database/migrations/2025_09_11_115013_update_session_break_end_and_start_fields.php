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
        DB::statement('ALTER TABLE work_session_breaks MODIFY COLUMN started_at DATETIME(0)');
        DB::statement('ALTER TABLE work_session_breaks MODIFY COLUMN ended_at DATETIME(0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE work_session_breaks MODIFY COLUMN started_at TIMESTAMP');
        DB::statement('ALTER TABLE work_session_breaks MODIFY COLUMN ended_at TIMESTAMP');
    }
};
