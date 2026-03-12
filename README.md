<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?style=flat-square&logo=laravel" alt="Laravel 12" />
  <img src="https://img.shields.io/badge/Livewire-4-purple?style=flat-square" alt="Livewire 4" />
  <img src="https://img.shields.io/badge/TailwindCSS-CDN-teal?style=flat-square&logo=tailwindcss" alt="TailwindCSS" />
  <img src="https://img.shields.io/badge/OpenAI-GPT--4o--mini-green?style=flat-square" alt="OpenAI" />
  <img src="https://img.shields.io/badge/Database-SQLite-blue?style=flat-square&logo=sqlite" alt="SQLite" />
</p>

# 🔍 ProductLens — AI Product Analyzer

> Paste an Amazon or Flipkart product URL and get AI-powered analysis in seconds. Results are cached in SQLite so the same product analyzed on the same day never triggers a duplicate API call.

---

## ✨ Features

| Feature | Details |
|---|---|
| 🔗 URL Validation | Domain allow-list + product-page regex (Amazon `/dp/`, Flipkart `/p/`) |
| 🤖 AI Analysis | GPT-4o-mini extracts name, price, currency, recommendation & reason |
| ⚡ SQLite Cache | Same URL on same calendar day → served from DB, zero extra API cost |
| 📤 CRM Webhook | POST analysis payload to any CRM / Zapier / Make webhook endpoint |
| 💅 Modern UI | Dark teal/emerald/amber theme, loading skeleton, cache/live badges |

---

## 🚀 Quick Start

### 1. Clone & Install

```bash
cd /Users/sreejilv/Desktop/product-analyzer
composer install
```

### 2. Configure Environment

Copy `.env.example` to `.env` (already done during install), then set:

```dotenv
# ── Required ──────────────────────────────────────────
OPENAI_API_KEY=sk-...your-openai-api-key-here...

# ── Optional (defaults shown) ─────────────────────────
OPENAI_MODEL=gpt-4o-mini
APP_NAME="ProductLens"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
```

> **Where to get an API key:** [platform.openai.com/api-keys](https://platform.openai.com/api-keys)

### 3. Run Database Migrations

The app uses the **SQLite** file already created at `database/database.sqlite`:

```bash
php artisan migrate
```

### 4. Start the Development Server

```bash
php artisan serve
```

Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your browser.

---

## 🗂️ Project Structure

```
app/
├── Livewire/
│   └── ProductAnalyzer.php        # Reactive component: validation, API call, CRM send
├── Models/
│   └── ProductAnalysis.php        # Eloquent model + cache helpers
└── Services/
    └── ProductAnalyzerService.php  # Cache-first OpenAI integration

database/
└── migrations/
    └── ..._create_product_analyses_table.php

resources/views/
├── layouts/app.blade.php          # HTML shell, TailwindCSS CDN, navbar
└── livewire/
    └── product-analyzer.blade.php # 3-section UI

routes/
└── web.php                        # / → ProductAnalyzer Livewire component
```

---

## 🧠 How the Cache Works

```
User submits URL
       │
       ▼
SHA-256 hash of URL
       │
       ▼
Check product_analyses WHERE url_hash = ? AND analysis_date = TODAY
       │
   ┌───┴─────────────┐
   │ HIT             │ MISS
   │                 ▼
   │         Call OpenAI API
   │                 │
   │         Save result to SQLite
   │                 │
   └──────► Return result to UI
```

A **"Cached"** amber badge or **"Live AI"** teal badge on the result card tells you the source.

---

## 🌐 Supported Product URL Formats

| Platform | Valid Pattern | Example |
|---|---|---|
| Amazon India | `amazon.in/…/dp/XXXXXXXXXX` | `https://www.amazon.in/Apple-iPhone/dp/B0CHX1TYVZ` |
| Amazon US | `amazon.com/…/dp/XXXXXXXXXX` | `https://www.amazon.com/dp/B09G3HRMVB` |
| Flipkart | `flipkart.com/…/p/XXXXXXXX` | `https://www.flipkart.com/samsung-s23/p/itmd9s7u` |

Category pages and search pages are **rejected** with a clear error.

---

## 📤 CRM Webhook Payload

When you click **Send to CRM**, the following JSON is `POST`-ed to your webhook URL:

```json
{
  "product_url":    "https://www.amazon.in/dp/B0CHX1TYVZ",
  "platform":       "Amazon",
  "product_name":   "Apple iPhone 15 (128 GB) - Black",
  "price":          79999,
  "currency":       "INR",
  "recommendation": "Good Deal",
  "reason":         "Current price is below the typical market range for this model.",
  "analysis_date":  "2026-03-12"
}
```

> **Tip:** Use [webhook.site](https://webhook.site) to test the webhook without a real CRM.

---

## 🧪 Running Tests

```bash
php artisan test --filter ProductAnalyzerTest
```

**Test coverage:**

| Test | Assertion |
|---|---|
| `homepage_loads_successfully` | HTTP 200 on `/` |
| `non_url_string_is_invalid` | Validation rejects non-URL strings |
| `unsupported_domain_is_rejected` | Only Amazon & Flipkart allowed |
| `amazon_category_url_is_rejected` | `/s?k=…` search URLs rejected |
| `valid_amazon_product_url_passes_validation` | `/dp/` URL + mocked service |
| `valid_flipkart_product_url_passes_validation` | `/p/` URL + mocked service |

---

## ⚙️ Environment Variables Reference

| Variable | Required | Default | Description |
|---|---|---|---|
| `OPENAI_API_KEY` | ✅ Yes | — | Your OpenAI secret key |
| `OPENAI_MODEL` | No | `gpt-4o-mini` | Model to use for analysis |
| `APP_KEY` | ✅ Yes | auto-generated | Laravel app key (run `php artisan key:generate`) |
| `DB_CONNECTION` | No | `sqlite` | Database driver |

---

## 📄 License

MIT — free to use and modify.
