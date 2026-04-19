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
        Schema::table('report_details', function (Blueprint $table) {
            $table->string('slug_url')->nullable()->after('title');
            $table->string('breadcrumb_title')->nullable()->after('slug_url');
            $table->string('page_main_title')->nullable()->after('breadcrumb_title');
            $table->string('report_sku')->nullable()->after('page_main_title');
            
            $table->longText('table_of_contents')->nullable()->after('description');
            
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('canonical_tag')->nullable();
            $table->string('meta_robots')->nullable();
            
            $table->json('hreflang_tags')->nullable();
            $table->json('open_graph_tags')->nullable();
            $table->json('twitter_card_tags')->nullable();
            
            $table->text('schema_tag')->nullable();
            $table->text('schema_tag_2')->nullable();
            $table->json('custom_schema_tags')->nullable();
            $table->json('faqs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_details', function (Blueprint $table) {
            $table->dropColumn([
                'slug_url', 'breadcrumb_title', 'page_main_title', 'report_sku',
                'table_of_contents', 'meta_title', 'meta_description', 'meta_keywords',
                'canonical_tag', 'meta_robots', 'hreflang_tags', 'open_graph_tags',
                'twitter_card_tags', 'schema_tag', 'schema_tag_2', 'custom_schema_tags', 'faqs'
            ]);
        });
    }
};
