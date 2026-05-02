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
        Schema::create('press_release_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('press_release_id')->constrained('press_releases')->onDelete('cascade');
            $table->longText('content')->nullable();
            
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            $table->text('canonical_tag')->nullable();
            $table->string('meta_robots')->nullable();
            
            $table->json('hreflang_tags')->nullable();
            $table->json('open_graph_tags')->nullable();
            $table->json('twitter_card_tags')->nullable();
            
            $table->longText('schema_tag')->nullable();
            $table->longText('schema_tag_2')->nullable();
            
            $table->string('slug_url')->nullable();
            $table->string('page_main_title')->nullable();
            $table->string('breadcrumb_title')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('press_release_details');
    }
};
