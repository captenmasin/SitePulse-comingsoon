<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $siteName = config('app.name');
        $pageTitle = config('seo.title');
        $description = config('seo.description');
        $canonicalUrl = $request->url();
        $ogImageUrl = url(config('seo.og_image.path'));

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'waitlist' => [
                    'success' => fn (): ?string => $request->session()->get('waitlist.success'),
                ],
            ],
            'seo' => [
                'siteName' => $siteName,
                'pageTitle' => $pageTitle,
                'fullTitle' => "{$pageTitle} - {$siteName}",
                'description' => $description,
                'canonicalUrl' => $canonicalUrl,
                'robots' => config('seo.robots'),
                'ogImageUrl' => $ogImageUrl,
                'ogImageAlt' => config('seo.og_image.alt'),
                'ogImageWidth' => config('seo.og_image.width'),
                'ogImageHeight' => config('seo.og_image.height'),
                'twitterCard' => config('seo.twitter.card'),
                'structuredData' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'SoftwareApplication',
                    'name' => $siteName,
                    'applicationCategory' => 'BusinessApplication',
                    'operatingSystem' => 'Web',
                    'url' => route('home', absolute: true),
                    'description' => $description,
                    'image' => $ogImageUrl,
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => config('seo.organization.name'),
                    ],
                ],
            ],
        ];
    }
}
