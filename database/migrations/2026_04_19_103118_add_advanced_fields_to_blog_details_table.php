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
        Schema::table('blog_details', function (Blueprint $table) {
            $table->text('canonical_tag')->nullable()->after('meta_keywords');
            $table->string('meta_robots')->nullable()->after('canonical_tag');
            
            $table->json('hreflang_tags')->nullable();
            $table->json('open_graph_tags')->nullable();
            $table->json('twitter_card_tags')->nullable();
            
            $table->text('schema_tag')->nullable();
            $table->text('schema_tag_2')->nullable();
            $table->text('schema_tag_3')->nullable();
            
            $table->json('faqs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_details', function (Blueprint $table) {
            $table->dropColumn([
                'canonical_tag', 'meta_robots', 'hreflang_tags', 
                'open_graph_tags', 'twitter_card_tags', 
                'schema_tag', 'schema_tag_2', 'schema_tag_3', 'faqs'
            ]);
        });
    }
};
