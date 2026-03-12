<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Creates the product_analyses table used to cache AI-generated
     * product analysis results. A cached record is considered valid
     * for the same URL on the same calendar day.
     */
    public function up(): void
    {
        Schema::create('product_analyses', function (Blueprint $table) {
            $table->id();

            // SHA-256 hash of the normalized product URL for fast lookups
            $table->string('url_hash', 64)->index();

            // The original URL stored for reference / display
            $table->text('product_url');

            // AI-extracted fields
            $table->string('platform')->nullable();          // Amazon | Flipkart
            $table->string('product_name')->nullable();
            $table->decimal('estimated_price', 12, 2)->nullable();
            $table->string('currency', 10)->nullable();      // INR | USD
            $table->string('purchase_recommendation')->nullable(); // Good Deal | Normal Price | Expensive
            $table->text('reason_for_recommendation')->nullable();
            $table->date('analysis_date')->nullable();

            // Raw JSON payload from OpenAI (for debugging / reprocessing)
            $table->json('raw_response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_analyses');
    }
};
