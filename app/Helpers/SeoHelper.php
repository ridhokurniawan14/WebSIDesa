<?php

namespace App\Helpers;

use Artesaos\SEOTools\Facades\SEOTools;

class SeoHelper
{
    public static function set(
        string $title,
        string $description = '',
        string $image = '',
        string $url = ''
    ) {
        $fullUrl = $url ?: url()->current();
        $imageUrl = $image ?: 'https://ridhokurniawan.my.id/img/rk.png';

        // Title
        SEOTools::setTitle($title);
        SEOTools::opengraph()->setTitle($title);
        SEOTools::twitter()->setTitle($title);

        // Description
        SEOTools::setDescription($description);
        SEOTools::opengraph()->setDescription($description);
        SEOTools::twitter()->setDescription($description);

        // URL
        SEOTools::opengraph()->setUrl($fullUrl);
        SEOTools::setCanonical($fullUrl);

        // Image
        SEOTools::opengraph()->addImage($imageUrl);
        SEOTools::twitter()->setImage($imageUrl);

        // Site Defaults
        SEOTools::jsonLd()->setType('WebSite');
        SEOTools::jsonLd()->setUrl($fullUrl);
        SEOTools::jsonLd()->addImage($imageUrl);
    }
}
