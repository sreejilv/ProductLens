<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ProductLens — AI Product Analyzer</title>
    <meta name="description" content="Analyze Amazon and Flipkart product URLs instantly with AI-powered insights." />

    {{-- TailwindCSS Play CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        brand: {
                            50:  '#f0fdfa',
                            100: '#ccfbf1',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                        },
                        accent: {
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                        },
                    },
                    animation: {
                        'fade-in':  'fadeIn 0.35s ease-out',
                        'slide-up': 'slideUp 0.4s cubic-bezier(.16,1,.3,1)',
                        'pulse-slow': 'pulse 3s cubic-bezier(.4,0,.6,1) infinite',
                    },
                    keyframes: {
                        fadeIn:  { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(18px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                    },
                },
            },
        };
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    @livewireStyles

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Teal gradient text ── */
        .gradient-text {
            background: linear-gradient(135deg, #14b8a6, #34d399, #fb923c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Glowing card border on hover ── */
        .card-glow { position: relative; }
        .card-glow::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 1rem;
            background: linear-gradient(135deg, #14b8a6, #34d399, #fb923c);
            opacity: 0;
            transition: opacity .35s ease;
            z-index: -1;
        }
        .card-glow:hover::before { opacity: .55; }

        /* ── Spinner ── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner {
            width: 1.1rem; height: 1.1rem;
            border: 2px solid rgba(255,255,255,.25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .75s linear infinite;
            display: inline-block;
        }

        /* ── Animated gradient background blobs ── */
        .bg-blob-teal {
            position: fixed; width: 500px; height: 500px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(20,184,166,.18) 0%, transparent 70%);
            filter: blur(60px); pointer-events: none;
        }
        .bg-blob-amber {
            position: fixed; width: 400px; height: 400px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(251,146,60,.12) 0%, transparent 70%);
            filter: blur(60px); pointer-events: none;
        }
    </style>
</head>

<body class="h-full bg-[#09130f] text-slate-100 antialiased overflow-x-hidden">

    {{-- Ambient blobs --}}
    <div class="bg-blob-teal"  style="top:-100px; left:-100px;"></div>
    <div class="bg-blob-amber" style="bottom:0; right:-80px;"></div>

    {{-- ── Navbar ── --}}
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-white/5 bg-black/30 backdrop-blur-2xl">
        <div class="mx-auto flex max-w-6xl items-center gap-3 px-6 py-4">
            {{-- Logo --}}
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-teal-400 to-emerald-500 shadow-lg shadow-teal-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-lg font-bold tracking-tight">
                Product<span class="gradient-text">Lens</span>
            </span>
            <span class="ml-auto rounded-full border border-teal-500/30 bg-teal-500/10 px-3 py-1 text-xs font-semibold text-teal-300">
                AI-Powered
            </span>
        </div>
    </nav>

    {{-- ── Main Content ── --}}
    <main class="min-h-screen pt-24 pb-16">
        {{ $slot }}
    </main>

    {{-- ── Footer ── --}}
    <footer class="border-t border-white/5 bg-black/30 py-6 text-center text-sm text-slate-500">
        ProductLens &mdash; AI Product Analyzer &copy; {{ date('Y') }}
    </footer>

    @livewireScripts
</body>
</html>