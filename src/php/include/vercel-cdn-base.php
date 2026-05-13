<?php
/**
 * Vercel üretiminde statik dosyalar (CSS/JS/SVG) aynı origin’den güvenilir gelmeyebilir.
 * Bu yardımcı, jsDelivr üzerinden GitHub kaynağına işaret eden kök URL üretir.
 *
 * Öncelik:
 * 1) BILENYUM_CDN_BASE — Vercel’de Project → Environment Variables ile (sonunda / olmasın)
 * 2) VERCEL_GIT_* sistem değişkenleri (Dashboard’da “System Environment Variables” açık olmalı)
 * 3) Sabit yedek: furkancilingir-art/bilenyumfurkan (repo taşındıysa burayı güncelleyin)
 */
declare(strict_types=1);

function bilenyum_vercel_cdn_base(): string
{
    if (getenv('VERCEL') !== '1' && getenv('VERCEL') !== 'true') {
        return '';
    }

    $manual = getenv('BILENYUM_CDN_BASE');
    if (is_string($manual) && $manual !== '') {
        return rtrim($manual, '/');
    }

    $owner = getenv('VERCEL_GIT_REPO_OWNER');
    $repo = getenv('VERCEL_GIT_REPO_SLUG');
    $sha = getenv('VERCEL_GIT_COMMIT_SHA');
    $branch = getenv('VERCEL_GIT_COMMIT_REF');

    if (!is_string($owner) || $owner === '') {
        $owner = 'furkancilingir-art';
    }
    if (!is_string($repo) || $repo === '') {
        $repo = 'bilenyumfurkan';
    }

    $ref = 'main';
    if (is_string($sha) && $sha !== '' && preg_match('/^[a-f0-9]{7,40}$/i', $sha)) {
        $ref = $sha;
    } elseif (is_string($branch) && $branch !== '' && preg_match('/^[a-zA-Z0-9._/-]+$/', $branch)) {
        $ref = $branch;
    }

    return 'https://cdn.jsdelivr.net/gh/'
        . rawurlencode($owner) . '/'
        . rawurlencode($repo) . '@'
        . rawurlencode($ref);
}
