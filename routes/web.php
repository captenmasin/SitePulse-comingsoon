<?php

use App\Http\Controllers\WaitlistEntryController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'ComingSoon')->name('home');

Route::get('/robots.txt', function (): Response {
    $content = implode(PHP_EOL, [
        'User-agent: *',
        'Allow: /',
        'Sitemap: '.route('sitemap', absolute: true),
    ]);

    return response($content, 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
    ]);
})->name('robots');

Route::get('/sitemap.xml', function (): Response {
    $homeUrl = route('home', absolute: true);

    $content = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{$homeUrl}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
</urlset>
XML;

    return response($content, 200, [
        'Content-Type' => 'application/xml; charset=UTF-8',
    ]);
})->name('sitemap');

Route::post('/waitlist', WaitlistEntryController::class)
    ->middleware('throttle:6,1')
    ->name('waitlist.store');
