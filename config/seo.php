<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Search engine indexing
    |--------------------------------------------------------------------------
    |
    | Only the real production site should be indexed. UAT / staging / local
    | copies are served with "noindex" and a "Disallow: /" robots.txt so they
    | never compete with the live site in search results.
    |
    | Set SEO_INDEXABLE=true on the live server only (it is also enabled
    | automatically when APP_ENV=production and SEO_INDEXABLE is not set).
    |
    */
    'indexable' => env('SEO_INDEXABLE', env('APP_ENV') === 'production'),

    /*
    |--------------------------------------------------------------------------
    | Canonical host
    |--------------------------------------------------------------------------
    |
    | In production, requests on any other host (for example www.) or over
    | plain http are redirected (301) to APP_URL, so there is only one
    | version of every page for search engines and visitors.
    |
    */
    'enforce_canonical_url' => env('SEO_ENFORCE_CANONICAL_URL', env('APP_ENV') === 'production'),

    'site_name' => 'Jaffna International Cinema Festival',

    'description' => 'Jaffna International Cinema Festival (JaffnaICF) celebrates cinema, culture, and community with programmes, master classes, and screenings.',

    // Used when a page has no image of its own and no site logo is uploaded.
    'default_image' => 'images/og-default.jpg',

    'social' => [
        'https://www.facebook.com/JaffnaICF',
    ],

];