<?php

namespace App\Services;

use App\Models\ProductAnalysis;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductAnalyzerService
{
    protected string $apiKey;
    protected string $model;
    protected string $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openai.key');
        $this->model = config('services.openai.model', 'gpt-4o-mini');
    }

    /**
     * Analyze a product URL.
     *
     * Strategy:
     *   1. Look up the SQLite cache for a record with the same URL hash AND today's date.
     *   2. If found, return the cached data immediately (no API call).
     *   3. Otherwise call OpenAI, persist the result, and return it.
     *
     * @param  string  $url
     * @param  bool    &$fromCache  Set to true if result came from the DB cache
     * @return array   Parsed product analysis data
     *
     * @throws Exception
     */
    public function analyze(string $url, bool &$fromCache = false): array
    {
        // ── 1. Check DB cache ──────────────────────────────────────────────
        $cached = ProductAnalysis::findCachedForToday($url);

        if ($cached !== null) {
            Log::info('ProductAnalyzerService: serving result from cache', [
                'url_hash' => ProductAnalysis::hashUrl($url),
                'id' => $cached->id,
            ]);

            $fromCache = true;
            return $cached->toAnalysisArray();
        }

        // ── 2. Call OpenAI ─────────────────────────────────────────────────
        $data = $this->callOpenAi($url);

        // ── 3. Persist to SQLite ───────────────────────────────────────────
        $this->persistToDb($url, $data);

        $fromCache = false;
        return $data;
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Send the prompt to OpenAI and return the parsed response array.
     *
     * @throws Exception
     */
    private function callOpenAi(string $url): array
    {
        $response = Http::withToken($this->apiKey)
            ->timeout(60)
            ->post($this->endpoint, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a product analysis assistant. Always respond with valid JSON only, no markdown, no explanation.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $this->buildPrompt($url),
                    ],
                ],
                'temperature' => 0.3,
            ]);

        if ($response->failed()) {
            Log::error('OpenAI API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new Exception(
                'OpenAI API request failed: ' . $response->status() .
                ' — ' . $response->json('error.message', 'Unknown error')
            );
        }

        $content = $response->json('choices.0.message.content');

        if (empty($content)) {
            throw new Exception('Empty response received from OpenAI.');
        }

        // Strip any accidental markdown code fences
        $content = preg_replace('/^```(?:json)?\s*/i', '', trim($content));
        $content = preg_replace('/\s*```$/', '', $content);

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON parse error from OpenAI', ['content' => $content]);
            throw new Exception('Could not parse the AI response as JSON. Please try again.');
        }

        return $data;
    }

    /**
     * Save the analysis result to the local SQLite database.
     */
    private function persistToDb(string $url, array $data): void
    {
        try {
            ProductAnalysis::create([
                'url_hash' => ProductAnalysis::hashUrl($url),
                'product_url' => $url,
                'platform' => $data['platform'] ?? null,
                'product_name' => $data['product_name'] ?? null,
                'estimated_price' => $data['estimated_price'] ?? null,
                'currency' => $data['currency'] ?? null,
                'purchase_recommendation' => $data['purchase_recommendation'] ?? null,
                'reason_for_recommendation' => $data['reason_for_recommendation'] ?? null,
                'analysis_date' => $data['analysis_date'] ?? today()->toDateString(),
                'raw_response' => $data,
            ]);
        } catch (\Throwable $e) {
            // Non-fatal — cache write failure should not break the user flow
            Log::warning('ProductAnalyzerService: could not persist to DB', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Build the structured analysis prompt.
     */
    private function buildPrompt(string $url): string
    {
        return <<<PROMPT
Analyze the following product URL and extract useful information.

Product URL: {$url}

Return a JSON response with exactly these keys:
- platform             : "Amazon" or "Flipkart"
- product_name         : Full name of the product
- estimated_price      : Numeric price (no currency symbol)
- currency             : "INR" or "USD"
- purchase_recommendation : "Good Deal", "Normal Price", or "Expensive"
- reason_for_recommendation : One or two sentence explanation
- analysis_date        : Today's date in YYYY-MM-DD format

If the product price appears low compared to the typical market average, classify as "Good Deal".
Return JSON only, no markdown, no code fences.
PROMPT;
    }
}
