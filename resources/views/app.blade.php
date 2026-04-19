<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    @php
        $siteName = config('app.name', 'Laravel');
        $pageTitle = config('seo.title');
        $fullTitle = "{$pageTitle} | {$siteName}";
        $description = config('seo.description');
        $canonicalUrl = route('home', absolute: true);
        $robots = config('seo.robots');
        $ogImageUrl = url(config('seo.og_image.path'));
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => $siteName,
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'url' => $canonicalUrl,
            'description' => $description,
            'image' => $ogImageUrl,
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('seo.organization.name'),
            ],
        ];
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
        <link rel="shortcut icon" href="/favicon.ico" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&family=Funnel+Display:wght@300..800&display=swap"
            rel="stylesheet"
        />

        <title>{{ $fullTitle }}</title>
        <meta name="description" content="{{ $description }}">
        <meta name="robots" content="{{ $robots }}">
        <link rel="canonical" href="{{ $canonicalUrl }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $fullTitle }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:image" content="{{ $ogImageUrl }}">
        <meta property="og:image:alt" content="{{ config('seo.og_image.alt') }}">
        <meta name="twitter:card" content="{{ config('seo.twitter.card') }}">
        <meta name="twitter:title" content="{{ $fullTitle }}">
        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ $ogImageUrl }}">
        <script type="application/ld+json">@json($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>

        <script defer src="https://api.pirsch.io/pa.js"
                id="pianjs"
                data-code="7yHsS02FdieXIhs1nIivBKbdyRm3DJWK"></script>

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        <x-inertia::head />
    </head>
    <body class="font-sans antialiased">
        <noscript>
            <main class="min-h-screen bg-white text-neutral-950">
                <div class="mx-auto max-w-5xl px-6 py-16 md:px-10 md:py-24">
                    <img
                        src="/logo.png"
                        alt="{{ $siteName }}"
                        class="h-auto w-44"
                    />

                    <p class="mt-10 font-mono text-xs font-semibold tracking-widest text-neutral-500 uppercase">
                        Coming soon
                    </p>

                    <h1 class="mt-5 max-w-4xl text-5xl leading-tight font-semibold text-balance md:text-6xl">
                        SEO monitoring for every website you manage.
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-relaxed text-neutral-600">
                        {{ $description }}
                    </p>

                    <form method="POST" action="{{ route('waitlist.store') }}" class="mt-10 max-w-md rounded-2xl border border-neutral-200 p-4">
                        @csrf

                        <label for="waitlist-email" class="block text-sm font-medium text-neutral-900">
                            Join the waitlist
                        </label>

                        <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                            <input
                                id="waitlist-email"
                                name="email"
                                type="email"
                                inputmode="email"
                                autocomplete="email"
                                placeholder="you@company.com"
                                required
                                class="min-w-0 flex-1 rounded-xl border border-neutral-300 px-3 py-2.5 text-sm"
                            />

                            <button
                                type="submit"
                                class="rounded-xl bg-neutral-950 px-4 py-2.5 text-sm font-medium text-white"
                            >
                                Join waitlist
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </noscript>

        <x-inertia::app />
    </body>
</html>
