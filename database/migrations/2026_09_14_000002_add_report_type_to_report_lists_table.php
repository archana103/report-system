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
        Schema::table('report_lists', function (Blueprint $table) {
            $table->string('report_type')->default('B2B Reports')->after('report_category_id');
        });

        // Set all existing reports to 'B2B Reports'
        DB::table('report_lists')->update(['report_type' => 'B2B Reports']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_lists', function (Blueprint $table) {
            $table->dropColumn('report_type');
        });
    }
};
