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
        // 1. Create Pricings Table
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('cost', 10, 2);
            $table->decimal('discount_cost', 10, 2)->nullable();
            $table->text('details')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        // 2. Create Purchases Table
        Schema::create('report_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_detail_id')->nullable()->constrained('report_details')->nullOnDelete();
            $table->foreignId('pricing_id')->nullable()->constrained('pricings')->nullOnDelete();
            $table->string('paypal_order_id')->nullable();
            $table->string('payment_status')->default('COMPLETED');
            $table->timestamps();
        });

        // 3. Drop Static Costs from report_details
        Schema::table('report_details', function (Blueprint $table) {
            $table->dropColumn([
                'single_user_license_cost',
                'team_user_license_cost',
                'enterprise_user_license_cost'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_details', function (Blueprint $table) {
            $table->string('single_user_license_cost')->nullable();
            $table->string('team_user_license_cost')->nullable();
            $table->string('enterprise_user_license_cost')->nullable();
        });

        Schema::dropIfExists('report_purchases');
        Schema::dropIfExists('pricings');
    }
};
