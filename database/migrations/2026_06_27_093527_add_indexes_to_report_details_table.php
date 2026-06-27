<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('report_details', function (Blueprint $table) {
            // Add the indexes
            $table->index('title');
            $table->index('slug_url');
        });
    }

    public function down()
    {
        Schema::table('report_details', function (Blueprint $table) {
            // Drop the indexes if we rollback the migration
            $table->dropIndex(['title']);
            $table->dropIndex(['slug_url']);
        });
    }
};
