<?php
declare(strict_types=1);

/**
 * Vercel giriş noktası: önce statik dosyaları diskten döndürür (CSS/JS/SVG vb.),
 * sonra temiz URL ve *.php isteklerini src/pages şablonlarına yönlendirir.
 */
$projectRoot = realpath(__DIR__ . '/..');
if ($projectRoot === false) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Proje kökü çözülemedi.';
    exit;
}

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$rawPath = parse_url($uri, PHP_URL_PATH);
$rawPath = is_string($rawPath) ? str_replace('\\', '/', $rawPath) : '/';

// --- Statik dosyalar (Vercel'de hepsi buraya düşebilir; slug mantığına sokma)
if (preg_match('#\.([a-z0-9]+)$#i', $rawPath, $xm)) {
    $ext = strtolower($xm[1]);
    $staticExt = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'mjs' => 'application/javascript; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'map' => 'application/json',
        'json' => 'application/json; charset=UTF-8',
        'html' => 'text/html; charset=UTF-8',
    ];
    if (isset($staticExt[$ext])) {
        $candidate = $projectRoot . $rawPath;
        $real = realpath($candidate);
        if ($real !== false
            && str_starts_with($real, $projectRoot)
            && is_file($real)
        ) {
            header('Content-Type: ' . $staticExt[$ext]);
            header('Cache-Control: public, max-age=86400');
            readfile($real);
            exit;
        }
        http_response_code(404);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'Dosya bulunamadı.';
        exit;
    }
}

$pagesRealDir = realpath(__DIR__ . '/../src/pages');
if ($pagesRealDir === false) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'src/pages bulunamadı.';
    exit;
}

$allowed = [
    'landing-reference' => 'landing-reference.php',
    'egitim-setleri' => 'egitim-setleri.php',
    'kadromuz' => 'kadromuz.php',
    'neden-biz' => 'neden-biz.php',
    'aydinlatma-metni' => 'aydinlatma-metni.php',
    'ornek-videolar' => 'ornek-videolar.php',
    'bize-ulasin' => 'bize-ulasin.php',
    'kadro-detay' => 'kadro-detay.php',
    'odeme-bilgileri' => 'odeme-bilgileri.php',
    'sikca-sorulan-sorular' => 'sikca-sorulan-sorular.php',
    'giris-kayit' => 'giris-kayit.php',
];

$trimmed = trim($rawPath, '/');

if ($trimmed === '') {
    $slug = 'landing-reference';
} else {
    $base = basename($rawPath);
    $slug = str_ends_with($base, '.php') ? substr($base, 0, -4) : $base;
}

if (!isset($allowed[$slug])) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Sayfa bulunamadı.';
    exit;
}

$file = $allowed[$slug];
$fullPath = $pagesRealDir . DIRECTORY_SEPARATOR . $file;
if (!is_file($fullPath)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Sayfa bulunamadı.';
    exit;
}

$_SERVER['SCRIPT_NAME'] = '/src/pages/' . $file;
$_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];
chdir($pagesRealDir);

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseHref = $scheme . '://' . $host . '/src/pages/';

ob_start();
require $fullPath;
$html = ob_get_clean();

if ($html === false) {
    exit;
}

if (stripos($html, '<base ') === false && preg_match('/<head(\s[^>]*)?>/i', $html, $m, PREG_OFFSET_CAPTURE)) {
    $inject = $m[0][0] . "\n  <base href=\"" . htmlspecialchars($baseHref, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "\" />";
    $html = substr_replace($html, $inject, $m[0][1], strlen($m[0][0]));
}

$phpToPath = [];
foreach ($allowed as $s => $fn) {
    $phpToPath[$fn] = '/' . $s;
}
$phpToPath['landing-reference.php'] = '/';

$html = preg_replace_callback(
    '/\b(href|src)=(["\'])([a-z0-9_-]+\.php)(\?[^"\']*)?\2/i',
    static function (array $m) use ($phpToPath): string {
        $phpFile = $m[3];
        $query = $m[4] ?? '';
        if (!isset($phpToPath[$phpFile])) {
            return $m[0];
        }
        return $m[1] . '=' . $m[2] . $phpToPath[$phpFile] . $query . $m[2];
    },
    $html
);

echo $html;
