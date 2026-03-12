<?php

namespace App\Livewire;

use App\Services\ProductAnalyzerService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Exception;

class ProductAnalyzer extends Component
{
    // --- Form fields ---
    public string $productUrl = '';
    public string $crmWebhookUrl = '';

    // --- State ---
    public bool $loading = false;
    public bool $crmLoading = false;
    public bool $fromCache = false;   // true when result was served from DB

    // --- Feedback ---
    public ?string $error = null;
    public ?string $crmError = null;
    public ?string $crmSuccess = null;

    // --- Result ---
    public ?array $result = null;

    // -------------------------------------------------------------------------
    // Allowed domains & product-page patterns
    // -------------------------------------------------------------------------
    protected array $allowedDomains = [
        'amazon.in',
        'amazon.com',
        'flipkart.com',
    ];

    /**
     * Validate and analyze the submitted product URL.
     * Results are served from SQLite cache when the same URL was analyzed today.
     */
    public function analyze(): void
    {
        // Reset previous state
        $this->error = null;
        $this->result = null;
        $this->fromCache = false;
        $this->loading = true;

        // 1. Basic format validation
        $validator = Validator::make(
            ['url' => $this->productUrl],
            ['url' => 'required|url|max:2048']
        );

        if ($validator->fails()) {
            $this->error = $validator->errors()->first('url');
            $this->loading = false;
            return;
        }

        // 2. Domain allow-list check
        $parsed = parse_url($this->productUrl);
        $host = strtolower($parsed['host'] ?? '');
        $host = preg_replace('/^www\./', '', $host);

        if (!in_array($host, $this->allowedDomains, true)) {
            $this->error = 'Only Amazon (amazon.in / amazon.com) and Flipkart (flipkart.com) product links are accepted.';
            $this->loading = false;
            return;
        }

        // 3. Product-page pattern check (not a category/search page)
        $path = $parsed['path'] ?? '';

        $isProductPage = match (true) {
            str_contains($host, 'amazon') => (bool) preg_match('#/dp/[A-Z0-9]{10}#i', $path),
            str_contains($host, 'flipkart') => (bool) preg_match('#/p/[a-z0-9]+#i', $path),
            default => false,
        };

        if (!$isProductPage) {
            $this->error = 'The URL does not appear to be a product page. Please provide a direct product link (Amazon: /dp/PRODUCT_ID, Flipkart: /p/PRODUCT_ID).';
            $this->loading = false;
            return;
        }

        // 4. Call service (handles DB cache + OpenAI transparently)
        try {
            /** @var ProductAnalyzerService $service */
            $service = app(ProductAnalyzerService::class);
            $fromCache = false;
            $this->result = $service->analyze($this->productUrl, $fromCache);
            $this->fromCache = $fromCache;
        } catch (Exception $e) {
            $this->error = 'Analysis failed: ' . $e->getMessage();
        }

        $this->loading = false;
    }

    /**
     * Send the analyzed product data to the configured CRM webhook.
     */
    public function sendToCrm(): void
    {
        $this->crmError = null;
        $this->crmSuccess = null;
        $this->crmLoading = true;

        // Validate webhook URL
        $validator = Validator::make(
            ['url' => $this->crmWebhookUrl],
            ['url' => 'required|url|max:2048']
        );

        if ($validator->fails()) {
            $this->crmError = 'Please enter a valid webhook URL.';
            $this->crmLoading = false;
            return;
        }

        if (empty($this->result)) {
            $this->crmError = 'No analysis result to send. Please analyze a product first.';
            $this->crmLoading = false;
            return;
        }

        try {
            $payload = [
                'product_url' => $this->productUrl,
                'platform' => $this->result['platform'] ?? null,
                'product_name' => $this->result['product_name'] ?? null,
                'price' => $this->result['estimated_price'] ?? null,
                'currency' => $this->result['currency'] ?? null,
                'recommendation' => $this->result['purchase_recommendation'] ?? null,
                'reason' => $this->result['reason_for_recommendation'] ?? null,
                'analysis_date' => $this->result['analysis_date'] ?? null,
            ];

            $response = Http::timeout(15)->post($this->crmWebhookUrl, $payload);

            if ($response->successful()) {
                $this->crmSuccess = 'Data successfully sent to CRM!';
            } else {
                $this->crmError = 'CRM returned an error: HTTP ' . $response->status();
            }
        } catch (Exception $e) {
            $this->crmError = 'Webhook request failed: ' . $e->getMessage();
        }

        $this->crmLoading = false;
    }

    /**
     * Clear all form state.
     */
    public function clearForm(): void
    {
        $this->productUrl = '';
        $this->result = null;
        $this->error = null;
        $this->fromCache = false;
        $this->crmWebhookUrl = '';
        $this->crmSuccess = null;
        $this->crmError = null;
    }

    public function render()
    {
        return view('livewire.product-analyzer')
            ->layout('layouts.app');
    }
}
