<?php
declare(strict_types=1);

/**
 * Vercel giriş noktası: temiz URL ve *.php isteklerini src/pages altındaki
 * şablona yönlendirir. SCRIPT_NAME, pricing-assets-path.php ile uyumlu olacak şekilde ayarlanır.
 */
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

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$rawPath = parse_url($uri, PHP_URL_PATH);
$rawPath = is_string($rawPath) ? str_replace('\\', '/', $rawPath) : '/';
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
