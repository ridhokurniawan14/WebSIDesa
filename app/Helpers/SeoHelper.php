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

        // Pastikan image URL valid & HTTPS
        // Gunakan default image jika kosong
        $imageUrl = $image ?: 'https://desakembiritan.com/img/rk.png'; // Sesuaikan path defaultmu

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

        // --- PERBAIKAN UTAMA DI SINI ---
        // 1. Set Type (Menghilangkan warning og:type)
        SEOTools::opengraph()->setType('article');

        // 2. Add Image
        SEOTools::opengraph()->addImage($imageUrl);
        SEOTools::twitter()->setImage($imageUrl);

        // 3. Site Name (Opsional tapi disukai WA)
        SEOTools::opengraph()->setSiteName('Website Desa Kembiritan');

        // Site Defaults
        SEOTools::jsonLd()->setType('WebSite');
        SEOTools::jsonLd()->setUrl($fullUrl);
        SEOTools::jsonLd()->addImage($imageUrl);
    }
}
