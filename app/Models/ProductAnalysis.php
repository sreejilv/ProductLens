<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAnalysis extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'product_analyses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'url_hash',
        'product_url',
        'platform',
        'product_name',
        'estimated_price',
        'currency',
        'purchase_recommendation',
        'reason_for_recommendation',
        'analysis_date',
        'raw_response',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'analysis_date' => 'date',
        'estimated_price' => 'float',
        'raw_response' => 'array',
    ];

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Generate a SHA-256 hash for the given URL (normalized to lowercase).
     */
    public static function hashUrl(string $url): string
    {
        return hash('sha256', strtolower(trim($url)));
    }

    /**
     * Find a cached analysis for the given URL that was created today.
     *
     * @return static|null
     */
    public static function findCachedForToday(string $url): ?self
    {
        return static::where('url_hash', static::hashUrl($url))
            ->whereDate('analysis_date', today())
            ->latest()
            ->first();
    }

    /**
     * Convert the model to the array format expected by the Livewire component.
     */
    public function toAnalysisArray(): array
    {
        return [
            'platform' => $this->platform,
            'product_name' => $this->product_name,
            'estimated_price' => $this->estimated_price,
            'currency' => $this->currency,
            'purchase_recommendation' => $this->purchase_recommendation,
            'reason_for_recommendation' => $this->reason_for_recommendation,
            'analysis_date' => $this->analysis_date?->format('Y-m-d'),
        ];
    }
}
