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
        if (Schema::hasTable('san_pham') && !Schema::hasColumn('san_pham', 'status')) {
            // Temporarily remove strict zero-date checks to normalize legacy invalid values.
            DB::statement("SET @OLD_SQL_MODE = @@SESSION.sql_mode");
            DB::statement("SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'NO_ZERO_IN_DATE', ''), 'NO_ZERO_DATE', '')");

            if (Schema::hasColumn('san_pham', 'created_at')) {
                DB::statement("UPDATE san_pham SET created_at = NOW() WHERE DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') = '0000-00-00 00:00:00'");
            }

            if (Schema::hasColumn('san_pham', 'updated_at')) {
                DB::statement("UPDATE san_pham SET updated_at = NOW() WHERE DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') = '0000-00-00 00:00:00'");
            }

            DB::statement("SET SESSION sql_mode = @OLD_SQL_MODE");

            Schema::table('san_pham', function (Blueprint $table) {
                $table->tinyInteger('status')->default(1)->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('san_pham') && Schema::hasColumn('san_pham', 'status')) {
            Schema::table('san_pham', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
