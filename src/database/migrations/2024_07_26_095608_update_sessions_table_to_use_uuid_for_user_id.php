<!-- <?php

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
        // Dropping the foreign key and user_id column
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        // Adding the new user_id column with UUID type
        Schema::table('sessions', function (Blueprint $table) {
            $table->char('user_id', 36)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Dropping the UUID foreign key and user_id column
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        // Adding the original user_id column back with unsignedBigInteger type
        Schema::table('sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }
}; 

