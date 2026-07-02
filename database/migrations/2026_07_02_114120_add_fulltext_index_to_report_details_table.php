<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report_details', function (Blueprint $table) {
            DB::statement('ALTER TABLE report_details ADD FULLTEXT INDEX report_search_fulltext_idx (title)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_details', function (Blueprint $table) {
            DB::statement('ALTER TABLE report_details DROP INDEX report_search_fulltext_idx');
        });
    }
};
