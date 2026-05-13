<?php
/**
 * Paket / görseller için web taban yolu ($pricingImgWebBase).
 * SCRIPT_NAME üzerinden /src/pages konumundan /src köküne çıkar; göreli ../ tek başına kırılmaz.
 */
if (getenv('VERCEL') === '1' || getenv('VERCEL') === 'true') {
    $pricingImgWebBase = '/src/components/images/';
    return;
}
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$pricingImgWebBase = '../components/images/';
if ($scriptName !== '') {
    $pagesDir = dirname($scriptName);
    $srcDir = dirname($pagesDir);
    $srcDir = str_replace('\\', '/', $srcDir);
    if ($srcDir !== '/' && $srcDir !== '.' && $srcDir !== '') {
        $pricingImgWebBase = rtrim($srcDir, '/') . '/components/images/';
    }
}
