<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductAnalyzerTest extends TestCase
{
    /**
     * The root route should return HTTP 200.
     */
    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * A fully invalid URL (not even a URL string) should fail.
     */
    public function test_non_url_string_is_invalid(): void
    {
        // We test the validation logic directly on the component
        $component = new \App\Livewire\ProductAnalyzer();
        $component->productUrl = 'not-a-url';
        $component->analyze();

        $this->assertNotNull($component->error);
        $this->assertNull($component->result);
    }

    /**
     * A URL from an unsupported domain should be rejected.
     */
    public function test_unsupported_domain_is_rejected(): void
    {
        $component = new \App\Livewire\ProductAnalyzer();
        $component->productUrl = 'https://www.google.com/search?q=iphone';
        $component->analyze();

        $this->assertStringContainsStringIgnoringCase('amazon', $component->error);
    }

    /**
     * An Amazon category / search URL (no /dp/ segment) should be rejected.
     */
    public function test_amazon_category_url_is_rejected(): void
    {
        $component = new \App\Livewire\ProductAnalyzer();
        $component->productUrl = 'https://www.amazon.in/s?k=iphone+14';
        $component->analyze();

        $this->assertStringContainsStringIgnoringCase('product page', $component->error);
    }

    /**
     * A valid Amazon product URL (contains /dp/PRODUCT_ID) should pass validation.
     * This test mocks the ProductAnalyzerService to avoid a real API call.
     */
    public function test_valid_amazon_product_url_passes_validation(): void
    {
        // Mock the service so the API is not actually called
        $this->mock(\App\Services\ProductAnalyzerService::class)
            ->shouldReceive('analyze')
            ->once()
            ->andReturn([
                'platform' => 'Amazon',
                'product_name' => 'iPhone 14',
                'estimated_price' => 65999,
                'currency' => 'INR',
                'purchase_recommendation' => 'Good Deal',
                'reason_for_recommendation' => 'Price is below typical market range.',
                'analysis_date' => '2026-03-12',
            ]);

        $component = new \App\Livewire\ProductAnalyzer();
        $component->productUrl = 'https://www.amazon.in/Apple-iPhone-256GB-Midnight/dp/B0CHX1TYVZ';
        $component->analyze();

        $this->assertNull($component->error);
        $this->assertNotNull($component->result);
        $this->assertEquals('Amazon', $component->result['platform']);
    }

    /**
     * A valid Flipkart product URL (contains /p/PRODUCT_ID) should pass validation.
     * This test mocks the ProductAnalyzerService to avoid a real API call.
     */
    public function test_valid_flipkart_product_url_passes_validation(): void
    {
        $this->mock(\App\Services\ProductAnalyzerService::class)
            ->shouldReceive('analyze')
            ->once()
            ->andReturn([
                'platform' => 'Flipkart',
                'product_name' => 'Samsung Galaxy S23',
                'estimated_price' => 54999,
                'currency' => 'INR',
                'purchase_recommendation' => 'Normal Price',
                'reason_for_recommendation' => 'Price is in line with market average.',
                'analysis_date' => '2026-03-12',
            ]);

        $component = new \App\Livewire\ProductAnalyzer();
        $component->productUrl = 'https://www.flipkart.com/samsung-galaxy-s23/p/itmd9s7udfcpz2gu';
        $component->analyze();

        $this->assertNull($component->error);
        $this->assertNotNull($component->result);
        $this->assertEquals('Flipkart', $component->result['platform']);
    }
}
