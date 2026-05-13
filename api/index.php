<?php
declare(strict_types=1);

/**
 * Vercel tek giriş: sadece sayfa PHP'leri. CSS/JS/SVG Vercel CDN'den
 * public/src/components/... yoluyla sunulur; burada <base> veya http şeması yok.
 */
$pagesRealDir = realpath(__DIR__ . '/../src/pages') ?: (dirname(__DIR__) . '/src/pages');
if (!is_dir($pagesRealDir)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'src/pages bulunamadı.';
    exit;
}

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$rawPath = parse_url($uri, PHP_URL_PATH);
$rawPath = is_string($rawPath) ? str_replace('\\', '/', $rawPath) : '/';
if ($rawPath === '') {
    $rawPath = '/';
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

ob_start();
require $fullPath;
$html = ob_get_clean();
if ($html === false) {
    exit;
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

// Bu dosya yalnızca Vercel üzerinden sunulur; göreli yollar /slug sayfalarında kırılır.
// PHP ortamında VERCEL=1 her zaman gelmeyebilir — bu yüzden dönüşümler her zaman uygulanır.
$pairs = [
    'href="../components/' => 'href="/src/components/',
    "href='../components/" => "href='/src/components/",
    'src="../components/' => 'src="/src/components/',
    "src='../components/" => "src='/src/components/",
    'srcset="../components/' => 'srcset="/src/components/',
    "srcset='../components/" => "srcset='/src/components/",
    'href="../../assets/' => 'href="/assets/',
    "href='../../assets/" => "href='/assets/",
    'src="../../assets/' => 'src="/assets/',
    "src='../../assets/" => "src='/assets/",
    'srcset="../../assets/' => 'srcset="/assets/',
    "srcset='../../assets/" => "srcset='/assets/",
];
foreach ($pairs as $from => $to) {
    $html = str_replace($from, $to, $html);
}

echo $html;
