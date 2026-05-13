<?php
/**
 * Paket özeti (ödeme adımları) — veri: pricing-catalog.json (pricing-catalog.js ile senkron).
 * JSON güncellemek için repo kökünde:
 * node -e "const fs=require('fs');const vm=require('vm');const c={window:{}};vm.runInNewContext(fs.readFileSync('src/components/scripts/pricing-catalog.js','utf8'),c);fs.writeFileSync('src/php/data/pricing-catalog.json',JSON.stringify(c.window.BILENYUM_PRICING_CATALOG,null,2));"
 */
declare(strict_types=1);

/**
 * UTF-8 karakter sayısı (mbstring yüklü değilse PCRE ile sayar).
 */
function bilenyum_utf8_strlen(string $s): int
{
    if ($s === '') {
        return 0;
    }
    if (function_exists('mb_strlen')) {
        return (int) mb_strlen($s, 'UTF-8');
    }
    $n = preg_match_all('/./u', $s, $unused);
    if ($n !== false) {
        return $n;
    }

    return strlen($s);
}

/**
 * @return array<string, list<array<string, mixed>>>
 */
function bilenyum_checkout_pricing_catalog(): array
{
    static $catalog = null;
    if ($catalog !== null) {
        return $catalog;
    }
    $path = __DIR__ . '/../data/pricing-catalog.json';
    if (!is_readable($path)) {
        $catalog = [];
        return $catalog;
    }
    $raw = file_get_contents($path);
    $decoded = json_decode($raw ?: '[]', true);
    $catalog = is_array($decoded) ? $decoded : [];
    return $catalog;
}

/**
 * @return array<string, mixed>|null
 */
function bilenyum_checkout_resolve_card(string $grade, string $theme): ?array
{
    $catalog = bilenyum_checkout_pricing_catalog();
    $row = $catalog[$grade] ?? null;
    if (!is_array($row)) {
        return null;
    }
    foreach ($row as $item) {
        if (is_array($item) && ($item['theme'] ?? '') === $theme) {
            return $item;
        }
    }
    return null;
}

function bilenyum_checkout_grade_label(string $grade): string
{
    return match ($grade) {
        '8' => '8. Sınıf (LGS)',
        '7' => '7. Sınıf',
        '6' => '6. Sınıf',
        '5' => '5. Sınıf',
        default => '8. Sınıf (LGS)',
    };
}

function bilenyum_checkout_pricing_img_url(string $img, string $webBase): string
{
    $img = trim($img);
    $base = rtrim($webBase, '/') . '/';
    if ($img === '') {
        return $base . 'pricing-tum-dersler.svg';
    }
    if (preg_match('#^https?://#i', $img)) {
        return $img;
    }
    $stripped = preg_replace('#^\.\./components/images/#', '', $img);
    $stripped = preg_replace('#^/?components/images/#', '', $stripped);
    $stripped = ltrim((string) $stripped, '/');
    return $base . $stripped;
}

/** Türkçe binlik noktalı tutar (katalogdaki "15.480" → 15480) */
function bilenyum_checkout_parse_amount(string $s): int
{
    $s = preg_replace('/[^\d]/', '', $s);
    return (int) ($s !== '' ? $s : '0');
}

/** Tam sayı lirayı "34.900" biçiminde döndürür */
function bilenyum_checkout_format_tl(int $lira): string
{
    return number_format($lira, 0, '', '.');
}

/**
 * Tek isim/soyad parçası: 2 harf veya daha uzun; harf ile biter; ara tire/apostrof.
 */
function bilenyum_checkout_name_part_valid(string $p): bool
{
    $len = bilenyum_utf8_strlen($p);
    if ($len < 2 || $len > 40) {
        return false;
    }
    if ($len === 2) {
        return (bool) preg_match('/^\p{L}{2}$/u', $p);
    }

    return (bool) preg_match('/^\p{L}(?:[\p{L}\'\-]*\p{L})$/u', $p);
}

/** Geçerliyse null; aksi Türkçe hata metni */
function bilenyum_checkout_validate_name(string $name): ?string
{
    $t = trim(preg_replace('/\s+/u', ' ', $name));
    if ($t === '') {
        return 'Ad ve soyad zorunludur.';
    }
    if (preg_match('/\d/u', $t)) {
        return 'Ad ve soyad alanında rakam kullanılamaz; yalnızca harf, tire ve apostrof kullanın.';
    }
    if (bilenyum_utf8_strlen($t) > 120) {
        return 'Ad ve soyad toplamda en fazla 120 karakter olabilir.';
    }
    $parts = preg_split('/\s+/u', $t, -1, PREG_SPLIT_NO_EMPTY);
    if ($parts === false) {
        return 'Ad ve soyad formatı geçersiz.';
    }
    if (count($parts) < 2) {
        return 'Ad ve soyad en az iki kelime olmalıdır; kelimeler arasında boşluk kullanın (ör. Ayşe Yılmaz veya Mehmet Ali Yılmaz).';
    }
    if (count($parts) > 8) {
        return 'En fazla 8 kelime girebilirsiniz.';
    }
    foreach ($parts as $p) {
        if (!bilenyum_checkout_name_part_valid($p)) {
            return 'Her kelime 2–40 karakter olmalı, harf ile başlayıp harf ile bitmeli; ara karakter olarak yalnızca tire (-) veya apostrof (\') kullanılabilir.';
        }
    }

    return null;
}

function bilenyum_checkout_valid_name(string $name): bool
{
    return bilenyum_checkout_validate_name($name) === null;
}

/**
 * Ulusal cep: tam 10 hane, 5 ile başlar (5XXXXXXXXX).
 * Kabul: 5xxxxxxxxx | 05xxxxxxxxxx | 90 5xxxxxxxxx (12 rakam).
 */
function bilenyum_checkout_normalize_phone(string $raw): ?string
{
    $d = preg_replace('/\D+/', '', $raw);
    if ($d === '') {
        return null;
    }
    if (strlen($d) === 12 && str_starts_with($d, '90')) {
        $d = substr($d, 2);
    } elseif (strlen($d) === 11 && $d[0] === '0') {
        if ($d[1] !== '5') {
            return null;
        }
        $d = substr($d, 1);
    } elseif (strlen($d) === 10) {
        // zaten ulusal
    } else {
        return null;
    }
    if (strlen($d) !== 10 || $d[0] !== '5') {
        return null;
    }
    if (!preg_match('/^5\d{9}$/', $d)) {
        return null;
    }

    return $d;
}

/** Görünüm: 5XX XXX XX XX (başta 0 yok; giriş alanında kullanıcı 5 ile yazar) */
function bilenyum_checkout_format_phone_display(string $tenDigits): string
{
    if (!preg_match('/^5\d{9}$/', $tenDigits)) {
        return '';
    }

    return substr($tenDigits, 0, 3) . ' ' . substr($tenDigits, 3, 3) . ' ' . substr($tenDigits, 6, 2) . ' ' . substr($tenDigits, 8, 2);
}

function bilenyum_checkout_validate_phone(string $raw): ?string
{
    if (bilenyum_checkout_normalize_phone($raw) !== null) {
        return null;
    }

    return 'Cep telefonu 10 hanedir, 5 ile başlar. Örnek: 5XX XXX XX XX (başta 0 yazmadan; yapıştırmada 0 veya +90 kabul edilir).';
}

function bilenyum_checkout_self_url(string $theme, string $grade, array $extra = []): string
{
    $q = array_merge(['paket' => $theme, 'sinif' => $grade], $extra);
    return 'odeme-bilgileri.php?' . http_build_query($q);
}

/** @return list<string> */
function bilenyum_checkout_tr_cities(): array
{
    static $cities = null;
    if ($cities !== null) {
        return $cities;
    }
    $path = __DIR__ . '/../data/tr-iller-data.php';
    $list = is_readable($path) ? require $path : [];
    $cities = is_array($list) ? array_values($list) : [];
    sort($cities, SORT_LOCALE_STRING);

    return $cities;
}

/**
 * ASCII tabanlı e-posta yapısı (bot / sahte Unicode karışımlarına karşı).
 * Geçerliyse null.
 */
function bilenyum_checkout_validate_email_structure(string $email): ?string
{
    if (preg_match('/\s/u', $email)) {
        return 'E-posta adresinde boşluk kullanılamaz.';
    }
    if (substr_count($email, '@') !== 1) {
        return 'E-posta adresinde tek bir @ işareti bulunmalıdır.';
    }
    $atPos = strpos($email, '@');
    if ($atPos === false) {
        return 'Geçerli bir e-posta adresi girin.';
    }
    $local = substr($email, 0, $atPos);
    $domain = substr($email, $atPos + 1);
    if ($local === '' || $domain === '') {
        return 'Geçerli bir e-posta adresi girin.';
    }
    $localLen = bilenyum_utf8_strlen($local);
    if ($localLen < 1 || $localLen > 64) {
        return 'E-posta kullanıcı adı 1–64 karakter olmalıdır.';
    }
    if (str_contains($local, '..') || str_starts_with($local, '.') || str_ends_with($local, '.')) {
        return 'E-posta kullanıcı adında nokta kullanımı geçersiz.';
    }
    if (!preg_match('/^[A-Za-z0-9.!#$%&\'*+\/=?^_`{|}~-]+$/', $local)) {
        return 'E-posta adresinde yalnızca İngilizce harf, rakam ve izin verilen özel karakterler kullanılabilir.';
    }
    if (bilenyum_utf8_strlen($domain) > 253) {
        return 'E-posta alan adı çok uzun.';
    }
    if (!str_contains($domain, '.')) {
        return 'E-posta alan adı geçersiz görünüyor.';
    }
    if (str_starts_with($domain, '.') || str_ends_with($domain, '.') || str_contains($domain, '..')) {
        return 'E-posta alan adı geçersiz.';
    }
    $labels = explode('.', $domain);
    foreach ($labels as $label) {
        if ($label === '' || bilenyum_utf8_strlen($label) > 63) {
            return 'E-posta alan adı geçersiz.';
        }
        if (!preg_match('/^[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?$/', $label)) {
            return 'E-posta alan adı geçersiz.';
        }
    }
    $tld = strtolower((string) ($labels[count($labels) - 1] ?? ''));
    if (strlen($tld) < 2) {
        return 'E-posta alan adı geçersiz.';
    }

    return null;
}

function bilenyum_checkout_validate_email(string $email): ?string
{
    $email = trim($email);
    if ($email === '') {
        return 'Lütfen e-posta adresinizi girin.';
    }
    if (bilenyum_utf8_strlen($email) > 254) {
        return 'E-posta adresi çok uzun.';
    }
    $struct = bilenyum_checkout_validate_email_structure($email);
    if ($struct !== null) {
        return $struct;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Geçerli bir e-posta adresi girin.';
    }

    return null;
}

/** Bot tuzak alanı doldurulmuşsa true (normal kullanıcı boş bırakır). */
function bilenyum_checkout_honeypot_filled(array $post): bool
{
    return trim((string) ($post['bilenyum_hp_website'] ?? '')) !== '';
}

/**
 * Form için tek kullanımlık token üretir (session’a yazar).
 */
function bilenyum_checkout_form_token_issue(string $scope): string
{
    if (!isset($_SESSION['checkout_form_tokens']) || !is_array($_SESSION['checkout_form_tokens'])) {
        $_SESSION['checkout_form_tokens'] = [];
    }
    $t = bin2hex(random_bytes(16));
    $_SESSION['checkout_form_tokens'][$scope] = [
        't' => $t,
        'iat' => time(),
    ];

    return $t;
}

/**
 * Token süresi ve eşleşmesi. Geçerliyse null; hata metni döner. Tüketmez.
 *
 * @param positive-int $minAgeSec İnsan doğrulaması için minimum süre (çok hızlı POST’ları reddeder)
 * @param positive-int $maxAgeSec Formun maksimum yaşı (saniye)
 */
function bilenyum_checkout_form_token_verify(
    string $scope,
    ?string $posted,
    int $minAgeSec = 2,
    int $maxAgeSec = 7200
): ?string {
    $sess = $_SESSION['checkout_form_tokens'][$scope] ?? null;
    if (!is_array($sess) || !isset($sess['t'], $sess['iat']) || !is_string($sess['t'])) {
        return 'Güvenlik doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.';
    }
    if (!is_string($posted) || $posted === '') {
        return 'Güvenlik doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.';
    }
    if (!hash_equals($sess['t'], $posted)) {
        return 'Güvenlik doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.';
    }
    $iat = (int) $sess['iat'];
    $age = time() - $iat;
    if ($age < $minAgeSec) {
        return 'İşleminiz çok hızlı tamamlandı. Lütfen birkaç saniye sonra tekrar deneyin.';
    }
    if ($age > $maxAgeSec) {
        return 'Formun süresi doldu. Sayfayı yenileyip tekrar deneyin.';
    }

    return null;
}

function bilenyum_checkout_form_token_consume(string $scope): void
{
    unset($_SESSION['checkout_form_tokens'][$scope]);
}

/** Özet şeridi: 0(5XX) XXX XX XX */
function bilenyum_checkout_format_phone_recap(string $tenDigits): string
{
    if (!preg_match('/^5\d{9}$/', $tenDigits)) {
        return '';
    }

    return '0(' . substr($tenDigits, 0, 3) . ') ' . substr($tenDigits, 3, 3) . ' ' . substr($tenDigits, 6, 2) . ' ' . substr($tenDigits, 8, 2);
}

/** Geçerliyse null; aksi Türkçe hata metni */
function bilenyum_checkout_validate_city(string $city): ?string
{
    $city = trim($city);
    if ($city === '') {
        return 'Lütfen şehrinizi seçin.';
    }
    $cities = bilenyum_checkout_tr_cities();
    if (!in_array($city, $cities, true)) {
        return 'Geçerli bir şehir seçin.';
    }

    return null;
}
