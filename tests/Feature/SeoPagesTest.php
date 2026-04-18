<?php

test('the home page includes crawlable seo metadata and fallback content', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee('<title>Website monitoring, uptime and performance checks - SEOToolkit</title>', false)
        ->assertSee('name="description"', false)
        ->assertSee(route('home', absolute: true), false)
        ->assertSee('application/ld+json', false)
        ->assertSee('SEO monitoring for every website you manage.', false);
});

test('robots.txt exposes the sitemap and allows crawling', function () {
    $response = $this->get(route('robots'));

    $response
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');

    expect($response->getContent())
        ->toContain('User-agent: *')
        ->toContain('Allow: /')
        ->toContain('Sitemap: '.route('sitemap', absolute: true));
});

test('sitemap.xml lists the home page', function () {
    $response = $this->get(route('sitemap'));

    $response
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

    expect($response->getContent())
        ->toContain('<?xml version="1.0" encoding="UTF-8"?>')
        ->toContain(route('home', absolute: true));
});
