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
        Schema::create('report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_list_id')->constrained('report_lists')->onDelete('cascade');
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('category_list_download')->nullable();
            $table->string('single_user_license_cost')->nullable();
            $table->string('team_user_license_cost')->nullable();
            $table->string('enterprise_user_license_cost')->nullable();
            $table->text('download_text')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_details');
    }
};
