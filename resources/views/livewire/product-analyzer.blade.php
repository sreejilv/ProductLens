<div class="mx-auto max-w-3xl px-4">

    {{-- ════════════════════════════════════════
    Hero
    ═════════════════════════════════════════ --}}
    <div class="mb-10 text-center animate-fade-in">
        <div
            class="mb-4 inline-flex items-center gap-2 rounded-full border border-teal-500/30 bg-teal-500/10 px-4 py-1.5 text-sm font-medium text-teal-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                <path
                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
            </svg>
            AI-Powered Product Analyzer
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
            Analyze Any <span class="gradient-text">Product</span> Instantly
        </h1>
        <p class="mt-3 text-slate-400">
            Paste an Amazon or Flipkart link — get AI-powered insights in seconds, cached for the day.
        </p>
    </div>

    {{-- ════════════════════════════════════════
    Section 1 — URL Analyzer Card
    ═════════════════════════════════════════ --}}
    <div
        class="card-glow animate-slide-up mb-6 rounded-2xl border border-white/[.07] bg-white/[.04] p-6 shadow-2xl backdrop-blur-lg">

        {{-- Header --}}
        <div class="mb-5 flex items-center gap-3">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-teal-400 to-emerald-500 shadow-lg shadow-teal-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-5 w-5 text-white">
                    <path fill-rule="evenodd"
                        d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-.353-5.304.75.75 0 0 1-.353-1Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white">Product URL Analyzer</h2>
                <p class="text-xs text-slate-400">Supports amazon.in, amazon.com &amp; flipkart.com</p>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($error)
            <div
                class="mb-4 flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="mt-0.5 h-4 w-4 flex-shrink-0">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ $error }}</span>
            </div>
        @endif

        {{-- Form --}}
        <form wire:submit.prevent="analyze" class="space-y-4">
            <div>
                <label for="product-url" class="mb-1.5 block text-sm font-medium text-slate-300">
                    Product URL <span class="text-orange-400">*</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="h-4 w-4 text-slate-500">
                            <path
                                d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                        </svg>
                    </div>
                    <input id="product-url" type="url" wire:model.defer="productUrl"
                        placeholder="https://www.amazon.in/dp/B09G3HRMVB  or  flipkart.com/…/p/…"
                        class="w-full rounded-xl border border-white/10 bg-white/[.04] py-3 pl-10 pr-4 text-sm text-white placeholder-slate-600 outline-none transition focus:border-teal-500/60 focus:ring-2 focus:ring-teal-500/25" />
                </div>
                <p class="mt-1.5 text-xs text-slate-600">Amazon: /dp/PRODUCT_ID &nbsp;·&nbsp; Flipkart: /p/PRODUCT_ID
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Analyze button --}}
                <button type="submit" id="analyze-btn" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-teal-500/25 transition hover:from-teal-400 hover:to-emerald-400 disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove wire:target="analyze">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd"
                                d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="analyze">Analyze Product</span>
                    <span wire:loading wire:target="analyze" class="flex items-center gap-2">
                        <span class="spinner"></span>
                        Analyzing…
                    </span>
                </button>

                {{-- New Analysis button — only shown after a result --}}
                @if ($result)
                    <button type="button" wire:click="clearForm"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 bg-white/[.04] px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/[.08]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd"
                                d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                                clip-rule="evenodd" />
                        </svg>
                        New Analysis
                    </button>
                @endif
            </div>
        </form>
    </div>

    {{-- ════════════════════════════════════════
    Section 2 — Loading Skeleton
    ═════════════════════════════════════════ --}}
    @if ($loading)
        <div class="mb-6 rounded-2xl border border-white/[.07] bg-white/[.04] p-6 backdrop-blur-lg animate-pulse">
            <div class="mb-4 h-5 w-40 rounded-lg bg-white/10"></div>
            <div class="grid grid-cols-2 gap-4">
                @foreach (range(1, 6) as $_)
                    <div class="rounded-xl border border-white/5 bg-white/[.04] p-4">
                        <div class="mb-2 h-3 w-20 rounded bg-white/10"></div>
                        <div class="h-4 w-32 rounded bg-white/10"></div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ════════════════════════════════════════
    Section 2 — Analysis Result Card
    ═════════════════════════════════════════ --}}
    @if ($result)
        <div
            class="card-glow animate-slide-up mb-6 rounded-2xl border border-white/[.07] bg-white/[.04] p-6 shadow-2xl backdrop-blur-lg">

            {{-- Card Header --}}
            <div class="mb-5 flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg shadow-emerald-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="h-5 w-5 text-white">
                        <path fill-rule="evenodd"
                            d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Product Analysis</h2>
                    <p class="text-xs text-slate-400">AI-generated insights</p>
                </div>

                <div class="ml-auto flex items-center gap-2">
                    {{-- Cache badge --}}
                    @if ($fromCache)
                        <span
                            class="flex items-center gap-1 rounded-full border border-amber-500/30 bg-amber-500/10 px-2.5 py-1 text-xs font-medium text-amber-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-3 w-3">
                                <path
                                    d="M5.625 3.75a2.625 2.625 0 1 0 0 5.25h12.75a2.625 2.625 0 0 0 0-5.25H5.625ZM3.75 11.25a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75ZM3 15.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75ZM3.75 18.75a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H3.75Z" />
                            </svg>
                            Cached
                        </span>
                    @else
                        <span
                            class="flex items-center gap-1 rounded-full border border-teal-500/30 bg-teal-500/10 px-2.5 py-1 text-xs font-medium text-teal-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-3 w-3">
                                <path fill-rule="evenodd"
                                    d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Live AI
                        </span>
                    @endif

                    {{-- Recommendation badge --}}
                    @php
                        $rec = $result['purchase_recommendation'] ?? '';
                        $badgeClass = match (true) {
                            str_contains(strtolower($rec), 'good') => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30',
                            str_contains(strtolower($rec), 'expensive') => 'bg-red-500/20 text-red-300 border-red-500/30',
                            default => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                        };
                    @endphp
                    <span class="rounded-full border {{ $badgeClass }} px-3 py-1 text-xs font-semibold">
                        {{ $rec }}
                    </span>
                </div>
            </div>

            {{-- Data Grid --}}
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                <div class="rounded-xl border border-white/5 bg-white/[.03] p-4">
                    <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-slate-500">Platform</p>
                    <p class="font-semibold text-white">
                        @if (strtolower($result['platform'] ?? '') === 'amazon') 🛒 {{ $result['platform'] }}
                        @elseif (strtolower($result['platform'] ?? '') === 'flipkart') 🏪 {{ $result['platform'] }}
                        @else {{ $result['platform'] ?? '—' }}
                        @endif
                    </p>
                </div>

                <div class="rounded-xl border border-white/5 bg-white/[.03] p-4">
                    <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-slate-500">Product Name</p>
                    <p class="font-semibold leading-snug text-white">{{ $result['product_name'] ?? '—' }}</p>
                </div>

                <div class="rounded-xl border border-white/5 bg-white/[.03] p-4">
                    <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-slate-500">Estimated Price</p>
                    <p class="text-xl font-bold text-teal-400">
                        {{ ($result['currency'] ?? '') === 'INR' ? '₹' : '$' }}{{ number_format((float) ($result['estimated_price'] ?? 0), 2) }}
                    </p>
                </div>

                <div class="rounded-xl border border-white/5 bg-white/[.03] p-4">
                    <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-slate-500">Analysis Date</p>
                    <p class="font-semibold text-white">{{ $result['analysis_date'] ?? '—' }}</p>
                </div>

                <div class="col-span-full rounded-xl border border-teal-500/20 bg-teal-500/[.05] p-4">
                    <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-teal-400">Recommendation Reason</p>
                    <p class="text-sm leading-relaxed text-slate-300">{{ $result['reason_for_recommendation'] ?? '—' }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- ════════════════════════════════════════
    Section 3 — CRM Webhook Card
    ═════════════════════════════════════════ --}}
    @if ($result)
        <div
            class="card-glow animate-slide-up rounded-2xl border border-white/[.07] bg-white/[.04] p-6 shadow-2xl backdrop-blur-lg">

            <div class="mb-5 flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-orange-400 to-amber-500 shadow-lg shadow-orange-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="h-5 w-5 text-white">
                        <path
                            d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Send to CRM</h2>
                    <p class="text-xs text-slate-400">Push analysis data to your CRM via webhook</p>
                </div>
            </div>

            @if ($crmSuccess)
                <div
                    class="mb-4 flex items-center gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-300 animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="h-4 w-4 flex-shrink-0">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $crmSuccess }}
                </div>
            @endif

            @if ($crmError)
                <div
                    class="mb-4 flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300 animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="mt-0.5 h-4 w-4 flex-shrink-0">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ $crmError }}</span>
                </div>
            @endif

            <form wire:submit.prevent="sendToCrm" class="space-y-4">
                <div>
                    <label for="crm-url" class="mb-1.5 block text-sm font-medium text-slate-300">
                        CRM Webhook URL <span class="text-orange-400">*</span>
                    </label>
                    <input id="crm-url" type="url" wire:model.defer="crmWebhookUrl"
                        placeholder="https://hooks.yourcrm.com/webhook/..."
                        class="w-full rounded-xl border border-white/10 bg-white/[.04] px-4 py-3 text-sm text-white placeholder-slate-600 outline-none transition focus:border-orange-500/60 focus:ring-2 focus:ring-orange-500/25" />
                </div>

                <button type="submit" id="crm-btn" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-500/25 transition hover:from-orange-400 hover:to-amber-400 disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove wire:target="sendToCrm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path
                                d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="sendToCrm">Send to CRM</span>
                    <span wire:loading wire:target="sendToCrm" class="flex items-center gap-2">
                        <span class="spinner"></span>
                        Sending…
                    </span>
                </button>
            </form>

            {{-- Payload Preview --}}
            <details class="mt-5 rounded-xl border border-white/[.06] bg-black/20">
                <summary
                    class="cursor-pointer px-4 py-3 text-xs font-medium text-slate-500 hover:text-slate-300 select-none">
                    📦 View CRM Payload Preview
                </summary>
                <pre class="overflow-x-auto px-4 pb-4 text-xs text-slate-500">{{ json_encode([
            'product_url' => $productUrl,
            'platform' => $result['platform'] ?? null,
            'product_name' => $result['product_name'] ?? null,
            'price' => $result['estimated_price'] ?? null,
            'currency' => $result['currency'] ?? null,
            'recommendation' => $result['purchase_recommendation'] ?? null,
            'reason' => $result['reason_for_recommendation'] ?? null,
            'analysis_date' => $result['analysis_date'] ?? null,
        ], JSON_PRETTY_PRINT) }}</pre>
            </details>
        </div>
    @endif

</div>