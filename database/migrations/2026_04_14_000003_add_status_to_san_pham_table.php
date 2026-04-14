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
        if (Schema::hasTable('san_pham') && !Schema::hasColumn('san_pham', 'status')) {
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
