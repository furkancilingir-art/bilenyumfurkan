<?php
declare(strict_types=1);

if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../php/include/pricing-assets-path.php';
require_once __DIR__ . '/../php/include/checkout-pricing.php';

$validThemes = ['hizlandirma', 'tum-dersler', 'sayisal', 'sozel', 'birebir'];
$themeRaw = isset($_GET['paket']) ? (string) $_GET['paket'] : 'tum-dersler';
$theme = preg_replace('/[^a-z0-9_-]/i', '', $themeRaw);
$gradeRaw = isset($_GET['sinif']) ? (string) $_GET['sinif'] : '8';
$grade = preg_replace('/[^0-9]/', '', $gradeRaw);
if (!in_array($grade, ['5', '6', '7', '8'], true)) {
    $grade = '8';
}
if (!in_array($theme, $validThemes, true)) {
    $theme = 'tum-dersler';
}

$card = bilenyum_checkout_resolve_card($grade, $theme);
if ($card === null) {
    header('Location: egitim-setleri.php', true, 302);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_GET['duzenle']) && (string) $_GET['duzenle'] === '1') {
    unset(
        $_SESSION['checkout_step2'],
        $_SESSION['checkout_errors_step2'],
        $_SESSION['checkout_old_step2'],
        $_SESSION['checkout_step3'],
        $_SESSION['checkout_errors_step3'],
        $_SESSION['checkout_step3_submitted']
    );
    header('Location: ' . bilenyum_checkout_self_url($theme, $grade), true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postTheme = preg_replace('/[^a-z0-9_-]/i', '', (string) ($_POST['paket'] ?? ''));
    $postGrade = preg_replace('/[^0-9]/', '', (string) ($_POST['sinif'] ?? ''));
    if (!in_array($postTheme, $validThemes, true)) {
        $postTheme = $theme;
    }
    if (!in_array($postGrade, ['5', '6', '7', '8'], true)) {
        $postGrade = $grade;
    }
    $postCard = bilenyum_checkout_resolve_card($postGrade, $postTheme);
    if ($postCard === null) {
        header('Location: egitim-setleri.php', true, 302);
        exit;
    }

    $checkoutAdim = (int) ($_POST['checkout_adim'] ?? 1);

    if ($checkoutAdim === 3) {
        if (bilenyum_checkout_honeypot_filled($_POST)) {
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '3']), true, 303);
            exit;
        }
        $s1p = $_SESSION['checkout_step1'] ?? null;
        $s2p = $_SESSION['checkout_step2'] ?? null;
        $s1PostOk = is_array($s1p)
            && (string) ($s1p['paket'] ?? '') === $postTheme
            && (string) ($s1p['sinif'] ?? '') === $postGrade;
        $s2PostOk = is_array($s2p)
            && trim((string) ($s2p['eposta'] ?? '')) !== ''
            && trim((string) ($s2p['sehir'] ?? '')) !== '';
        if (!$s1PostOk || !$s2PostOk) {
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade), true, 303);
            exit;
        }
        $tokErr = bilenyum_checkout_form_token_verify('step3', (string) ($_POST['checkout_form_token'] ?? ''));
        if ($tokErr !== null) {
            $_SESSION['checkout_errors_step3'] = ['genel' => $tokErr];
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '3']), true, 303);
            exit;
        }
        if (!isset($_POST['mesafeli_onay'])) {
            $_SESSION['checkout_errors_step3'] = [
                'mesafeli' => 'Devam etmek için Ön Bilgilendirme ve Mesafeli Satış Sözleşmesi\'ni onaylamanız gerekir.',
            ];
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '3']), true, 303);
            exit;
        }
        bilenyum_checkout_form_token_consume('step3');
        $_SESSION['checkout_step3'] = [
            'ticari_izin' => isset($_POST['ticari_izin']),
            'submitted_at' => time(),
        ];
        $_SESSION['checkout_step3_submitted'] = 1;
        header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '3', 'bitir' => '1']), true, 303);
        exit;
    }

    if ($checkoutAdim === 2) {
        if (bilenyum_checkout_honeypot_filled($_POST)) {
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '2']), true, 303);
            exit;
        }
        $s1p = $_SESSION['checkout_step1'] ?? null;
        if (
            !is_array($s1p)
            || (string) ($s1p['paket'] ?? '') !== $postTheme
            || (string) ($s1p['sinif'] ?? '') !== $postGrade
        ) {
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade), true, 303);
            exit;
        }
        $tokErr = bilenyum_checkout_form_token_verify('step2', (string) ($_POST['checkout_form_token'] ?? ''));
        if ($tokErr !== null) {
            $_SESSION['checkout_errors_step2'] = ['eposta' => $tokErr];
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '2']), true, 303);
            exit;
        }
        $eposta = trim((string) ($_POST['eposta'] ?? ''));
        $sehir = trim((string) ($_POST['sehir'] ?? ''));
        $err2 = [];
        $eEmail = bilenyum_checkout_validate_email($eposta);
        if ($eEmail !== null) {
            $err2['eposta'] = $eEmail;
        }
        $eCity = bilenyum_checkout_validate_city($sehir);
        if ($eCity !== null) {
            $err2['sehir'] = $eCity;
        }
        if ($err2 !== []) {
            $_SESSION['checkout_errors_step2'] = $err2;
            $_SESSION['checkout_old_step2'] = ['eposta' => $eposta, 'sehir' => $sehir];
            header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '2']), true, 303);
            exit;
        }
        bilenyum_checkout_form_token_consume('step2');
        $_SESSION['checkout_step2'] = [
            'eposta' => $eposta,
            'sehir' => $sehir,
            'submitted_at' => time(),
        ];
        header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '3']), true, 303);
        exit;
    }

    if (bilenyum_checkout_honeypot_filled($_POST)) {
        header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade), true, 303);
        exit;
    }
    $tokErr1 = bilenyum_checkout_form_token_verify('step1', (string) ($_POST['checkout_form_token'] ?? ''));
    if ($tokErr1 !== null) {
        $_SESSION['checkout_top_alert'] = $tokErr1;
        header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade), true, 303);
        exit;
    }

    $ad_soyad = trim(preg_replace('/\s+/u', ' ', (string) ($_POST['ad_soyad'] ?? '')));
    $telefon = trim((string) ($_POST['telefon'] ?? ''));
    $kvkk = isset($_POST['kvkk_onay']);
    $err = [];
    $errName = bilenyum_checkout_validate_name($ad_soyad);
    if ($errName !== null) {
        $err['ad_soyad'] = $errName;
    }
    $errPhone = bilenyum_checkout_validate_phone($telefon);
    if ($errPhone !== null) {
        $err['telefon'] = $errPhone;
    }
    if (!$kvkk) {
        $err['kvkk'] = 'Devam etmek için aydınlatma metnini onaylamanız gerekir.';
    }
    if ($err !== []) {
        $_SESSION['checkout_errors'] = $err;
        $_SESSION['checkout_old'] = ['ad_soyad' => $ad_soyad, 'telefon' => $telefon];
        header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade), true, 303);
        exit;
    }
    bilenyum_checkout_form_token_consume('step1');
    $norm = bilenyum_checkout_normalize_phone($telefon);
    $_SESSION['checkout_step1'] = [
        'ad_soyad' => $ad_soyad,
        'telefon' => $norm,
        'paket' => $postTheme,
        'sinif' => $postGrade,
        'submitted_at' => time(),
    ];
    unset(
        $_SESSION['checkout_step2'],
        $_SESSION['checkout_errors_step2'],
        $_SESSION['checkout_old_step2'],
        $_SESSION['checkout_step3'],
        $_SESSION['checkout_errors_step3'],
        $_SESSION['checkout_step3_submitted']
    );
    header('Location: ' . bilenyum_checkout_self_url($postTheme, $postGrade, ['adim' => '2']), true, 303);
    exit;
}

$adim = 1;
if (isset($_GET['adim'])) {
    $a = (int) $_GET['adim'];
    if ($a >= 1 && $a <= 3) {
        $adim = $a;
    }
}

$s1 = $_SESSION['checkout_step1'] ?? null;
$s1Ok = is_array($s1) && (string) ($s1['paket'] ?? '') === $theme && (string) ($s1['sinif'] ?? '') === $grade;
$s2 = $_SESSION['checkout_step2'] ?? null;
$s2Ok = is_array($s2)
    && trim((string) ($s2['eposta'] ?? '')) !== ''
    && trim((string) ($s2['sehir'] ?? '')) !== '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (isset($_GET['tamam']) && (string) $_GET['tamam'] === '1') {
        if ($s1Ok) {
            header('Location: ' . bilenyum_checkout_self_url($theme, $grade, ['adim' => '2']), true, 303);
        } else {
            header('Location: ' . bilenyum_checkout_self_url($theme, $grade), true, 303);
        }
        exit;
    }
    if ($adim >= 2 && !$s1Ok) {
        header('Location: ' . bilenyum_checkout_self_url($theme, $grade), true, 303);
        exit;
    }
    if ($adim >= 3 && !$s2Ok) {
        $q = $s1Ok ? ['adim' => '2'] : [];
        header('Location: ' . bilenyum_checkout_self_url($theme, $grade, $q), true, 303);
        exit;
    }
}

$showBitirSuccess = false;
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST'
    && $adim === 3
    && $s2Ok
    && isset($_GET['bitir'])
    && (string) $_GET['bitir'] === '1'
) {
    if (!empty($_SESSION['checkout_step3_submitted'])) {
        unset($_SESSION['checkout_step3_submitted']);
        $showBitirSuccess = true;
    } else {
        header('Location: ' . bilenyum_checkout_self_url($theme, $grade, ['adim' => '3']), true, 303);
        exit;
    }
}

$errors = [];
$old = ['ad_soyad' => '', 'telefon' => ''];
if (!empty($_SESSION['checkout_errors']) && is_array($_SESSION['checkout_errors'])) {
    $errors = $_SESSION['checkout_errors'];
    unset($_SESSION['checkout_errors']);
}
if (!empty($_SESSION['checkout_old']) && is_array($_SESSION['checkout_old'])) {
    $old = array_merge($old, $_SESSION['checkout_old']);
    unset($_SESSION['checkout_old']);
}

$errorsStep2 = [];
$oldStep2 = ['eposta' => '', 'sehir' => ''];
if (!empty($_SESSION['checkout_errors_step2']) && is_array($_SESSION['checkout_errors_step2'])) {
    $errorsStep2 = $_SESSION['checkout_errors_step2'];
    unset($_SESSION['checkout_errors_step2']);
}
if (!empty($_SESSION['checkout_old_step2']) && is_array($_SESSION['checkout_old_step2'])) {
    $oldStep2 = array_merge($oldStep2, $_SESSION['checkout_old_step2']);
    unset($_SESSION['checkout_old_step2']);
}

$errorsStep3 = [];
if (!empty($_SESSION['checkout_errors_step3']) && is_array($_SESSION['checkout_errors_step3'])) {
    $errorsStep3 = $_SESSION['checkout_errors_step3'];
    unset($_SESSION['checkout_errors_step3']);
}

$topAlert = '';
if (!empty($_SESSION['checkout_top_alert']) && is_string($_SESSION['checkout_top_alert'])) {
    $topAlert = trim($_SESSION['checkout_top_alert']);
    unset($_SESSION['checkout_top_alert']);
}

if ($s1Ok) {
    if (trim((string) ($old['ad_soyad'] ?? '')) === '') {
        $old['ad_soyad'] = (string) ($s1['ad_soyad'] ?? '');
    }
    if (trim((string) ($old['telefon'] ?? '')) === '') {
        $td = (string) ($s1['telefon'] ?? '');
        if (preg_match('/^5\d{9}$/', $td)) {
            $old['telefon'] = bilenyum_checkout_format_phone_display($td);
        }
    }
}

$tokenStep1 = '';
if ($adim === 1) {
    $tokenStep1 = bilenyum_checkout_form_token_issue('step1');
}
$tokenStep2 = '';
if ($adim === 2) {
    $tokenStep2 = bilenyum_checkout_form_token_issue('step2');
}
$tokenStep3 = '';
if ($adim === 3 && !$showBitirSuccess) {
    $tokenStep3 = bilenyum_checkout_form_token_issue('step3');
}

$cities = bilenyum_checkout_tr_cities();
$recapName = $s1Ok ? (string) ($s1['ad_soyad'] ?? '') : '';
$recapPhone = '';
if ($s1Ok && is_string($s1['telefon'] ?? null) && preg_match('/^5\d{9}$/', (string) $s1['telefon'])) {
    $recapPhone = bilenyum_checkout_format_phone_recap((string) $s1['telefon']);
}
$duzenleUrl = bilenyum_checkout_self_url($theme, $grade, ['duzenle' => '1']);

$gradeLabel = bilenyum_checkout_grade_label($grade);
$imgUrl = bilenyum_checkout_pricing_img_url((string) ($card['img'] ?? ''), $pricingImgWebBase);
$totalLira = bilenyum_checkout_parse_amount((string) ($card['total'] ?? '0'));
$monthlyInstall = $totalLira > 0 ? (int) round($totalLira / 12) : 0;
$totalFmt = bilenyum_checkout_format_tl($totalLira);
$installFmt = bilenyum_checkout_format_tl($monthlyInstall);
$pkgTitle = (string) ($card['name'] ?? 'Paket');

$pkgFeaturesLine = '';
if (!empty($card['features']) && is_array($card['features'])) {
    $pkgFeaturesLine = implode(' · ', array_map('strval', $card['features']));
}
if ($pkgFeaturesLine === '') {
    $pkgFeaturesLine = 'Canlı ve kayıtlı ders içerikleri, platform erişimi.';
}

$bilenyumSellerUnvan = 'Bilenyum Eğitim Teknolojileri Anonim Şirketi';
$onb_satici_unvan = $bilenyumSellerUnvan;
$onb_satici_mersis = '—';
$onb_satici_adres = 'Türkiye — merkez adres bilgisi güncellenecektir.';
$onb_satici_tel = '+90 850 123 45 67';
$onb_satici_email = 'info@bilenyum.com';
$onb_satici_kep = 'bilenyum@hs01.kep.tr';
$onb_satici_web = 'www.bilenyum.com';
$onb_alici_ad = $recapName !== '' ? $recapName : '—';
$onb_alici_adres = ($s2Ok && isset($s2['sehir'])) ? trim((string) $s2['sehir']) : '—';
$onb_alici_tel = $recapPhone !== '' ? $recapPhone : '—';
$onb_alici_email = ($s2Ok && isset($s2['eposta'])) ? trim((string) $s2['eposta']) : '—';
$onb_paket_ad = $pkgTitle;
$onb_paket_aciklama = $pkgFeaturesLine;
$onb_toplam_tl = $totalFmt;
$ticari_sirket_unvan = $bilenyumSellerUnvan;

$h = static function (string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
};

$phoneOld = $old['telefon'] ?? '';
$normOld = bilenyum_checkout_normalize_phone($phoneOld);
if ($normOld !== null) {
    $phoneOld = bilenyum_checkout_format_phone_display($normOld);
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Ödeme bilgileri — <?php echo $h($pkgTitle); ?> — Bilenyum</title>
  <meta name="description" content="Satın alma işleminiz için ödeme bilgileri adımı. Kişisel verileriniz KVKK kapsamında işlenir." />
  <meta name="robots" content="noindex, nofollow" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../components/styles/checkout-odeme.css">
</head>
<body class="checkout-page">

<header class="checkout-top">
  <div class="checkout-top-inner">
    <a class="checkout-logo" href="landing-reference.php" aria-label="Bilenyum ana sayfa">
      <img src="../../assets/logo.png" alt="Bilenyum" width="160" height="40" decoding="async" />
    </a>
    <div class="checkout-top-help">
      <p>Satın alma işlemleriniz ile ilgili bilgi almak isterseniz bize ulaşabilirsiniz.</p>
      <div class="checkout-top-contacts">
        <a href="https://wa.me/905551234567" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.6 6.32A7.85 7.85 0 0 0 12.05 4a7.94 7.94 0 0 0-6.88 11.9L4 20l4.2-1.1A7.93 7.93 0 0 0 12.05 20h.01a7.95 7.95 0 0 0 5.55-13.68zM12.06 18.5h-.01a6.59 6.59 0 0 1-3.36-.92l-.24-.14-2.5.65.67-2.43-.16-.25a6.6 6.6 0 1 1 12.24-3.46 6.6 6.6 0 0 1-6.64 6.55z"/></svg>
          +90 555 123 45 67
        </a>
        <a href="tel:+908501234567">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57a1.02 1.02 0 0 0-1.02.24l-2.2 2.2a15.07 15.07 0 0 1-6.59-6.59l2.2-2.21a.96.96 0 0 0 .25-1A11.36 11.36 0 0 1 8.5 4c0-.55-.45-1-1-1H4a1 1 0 0 0-1 1 17 17 0 0 0 17 17c.55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z"/></svg>
          0850 123 45 67
        </a>
        <a href="mailto:info@bilenyum.com">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 6.75A2.75 2.75 0 0 1 5.75 4h12.5A2.75 2.75 0 0 1 21 6.75v10.5A2.75 2.75 0 0 1 18.25 20H5.75A2.75 2.75 0 0 1 3 17.25V6.75zm2.1-.25L12 11.33 18.9 6.5H5.1zM19 8.42l-6.43 4.5a1 1 0 0 1-1.14 0L5 8.42v8.83c0 .41.34.75.75.75h12.5c.41 0 .75-.34.75-.75V8.42z"/></svg>
          info@bilenyum.com
        </a>
      </div>
    </div>
  </div>
</header>

<main class="checkout-main">
  <?php if ($topAlert !== '') : ?>
    <div class="checkout-alert checkout-alert--error" role="alert"><?php echo $h($topAlert); ?></div>
  <?php endif; ?>
  <div class="checkout-columns<?php echo $adim === 3 ? ' checkout-columns--step3' : ''; ?>">
    <section class="checkout-col checkout-col--form" aria-labelledby="checkout-form-title">
      <header class="checkout-col-head">
        <?php if ($adim === 3) : ?>
        <h1 class="checkout-section-title" id="checkout-form-title">Ödeme</h1>
        <?php else : ?>
        <h1 class="checkout-section-title" id="checkout-form-title">Ödeme Bilgileri</h1>
        <?php endif; ?>
        <?php if ($adim === 1) : ?>
        <p class="checkout-section-lead">
          Ödemeyi yapacak kişinin bilgilerini eksiksiz doldurun. Giriş ve erişim bilgileri kayıtlı e-posta ve telefonunuza iletilir.
        </p>
        <?php elseif ($adim === 2) : ?>
        <p class="checkout-section-lead">
          Satın alma işlemini başlatmak için ödeme yapacak kişinin bilgilerini doldurunuz. İşlemler tamamlandıktan sonra mail adresiniz ve telefon numaranıza gelen bilgilerle ders çalışmaya hemen başlayabilirsiniz.
        </p>
        <?php elseif ($adim === 3 && $showBitirSuccess) : ?>
        <p class="checkout-section-lead">
          Sipariş kaydınız alındı. Ödeme altyapısı tamamlandığında bu adımdan güvenli ödemeye yönlendirileceksiniz.
        </p>
        <?php elseif ($adim === 3) : ?>
        <p class="checkout-section-lead">
          Ödeme yönteminizi seçin. Özet ve sözleşme onaylarını sağdaki kutudan tamamlayabilirsiniz.
        </p>
        <?php endif; ?>
      </header>

      <?php if ($adim === 1) : ?>
      <div class="checkout-card">
        <form method="post" action="" data-checkout-form novalidate>
          <input type="hidden" name="checkout_adim" value="1" />
          <input type="hidden" name="checkout_form_token" value="<?php echo $h($tokenStep1); ?>" />
          <input type="hidden" name="paket" value="<?php echo $h($theme); ?>" />
          <input type="hidden" name="sinif" value="<?php echo $h($grade); ?>" />

          <div class="checkout-honeypot" aria-hidden="true">
            <label for="bilenyum-hp-step1">Web sitesi (doldurmayın)</label>
            <input type="text" name="bilenyum_hp_website" id="bilenyum-hp-step1" value="" tabindex="-1" autocomplete="off" />
          </div>

          <div class="checkout-form-grid">
            <div class="checkout-field<?php echo isset($errors['ad_soyad']) ? ' is-error' : ''; ?>">
              <label for="checkout-ad-soyad">Ad &amp; Soyad</label>
              <input
                type="text"
                id="checkout-ad-soyad"
                name="ad_soyad"
                autocomplete="name"
                placeholder="Örn. Ayşe Yılmaz"
                maxlength="120"
                title="Rakam yok; en az iki kelime; her kelime 2–40 harf; kelimeler arasında tek boşluk."
                value="<?php echo $h($old['ad_soyad'] ?? ''); ?>"
                required
              />
              <p class="checkout-field-error" data-msg-default="Rakam kullanılamaz. En az iki kelime; her kelime harf ile biter (ör. Ayşe Yılmaz veya Jean-Luc Demir)."<?php echo empty($errors['ad_soyad']) ? ' hidden' : ''; ?>><?php echo isset($errors['ad_soyad']) ? $h($errors['ad_soyad']) : ''; ?></p>
            </div>
            <div class="checkout-field<?php echo isset($errors['telefon']) ? ' is-error' : ''; ?>">
              <label for="checkout-telefon">Telefon numarası</label>
              <input
                type="tel"
                id="checkout-telefon"
                name="telefon"
                autocomplete="tel"
                inputmode="numeric"
                placeholder="5XX XXX XX XX"
                maxlength="13"
                title="10 hane, 5 ile başlar; başta 0 yazmadan 5XX XXX XX XX. Yapıştırmada 0 veya +90 kabul edilir."
                value="<?php echo $h($phoneOld); ?>"
                required
              />
              <p class="checkout-field-error" data-msg-default="Cep numarası 10 hanedir (5 ile başlar). Örnek: 5XX XXX XX XX."<?php echo empty($errors['telefon']) ? ' hidden' : ''; ?>><?php echo isset($errors['telefon']) ? $h($errors['telefon']) : ''; ?></p>
            </div>
          </div>

          <div class="checkout-notice" role="note">
            <span class="checkout-notice-icon" aria-hidden="true">!</span>
            <div>
              Kişisel verileriniz
              <button type="button" class="checkout-inline-link" data-open-aydinlatma>Aydınlatma Metni</button>
              kapsamında işlenmektedir.
            </div>
          </div>

          <div class="checkout-kvkk<?php echo isset($errors['kvkk']) ? ' is-error' : ''; ?>">
            <input type="checkbox" id="checkout-kvkk" name="kvkk_onay" value="1" />
            <div class="checkout-kvkk-text">
              <button type="button" class="checkout-inline-link" data-open-aydinlatma>Aydınlatma Metni</button>
              <label for="checkout-kvkk" class="checkout-kvkk-after">’ni okudum; kişisel verilerimin işlenmesini kabul ediyorum.</label>
            </div>
          </div>
          <p class="checkout-field-error" data-checkout-kvkk-error data-msg-default="Devam etmek için aydınlatma metnini onaylamanız gerekir."<?php echo empty($errors['kvkk']) ? ' hidden' : ''; ?> style="margin-top:8px"><?php echo isset($errors['kvkk']) ? $h($errors['kvkk']) : ''; ?></p>

          <div class="checkout-actions">
            <button type="submit" class="checkout-btn-confirm">
              Sepeti onayla
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
            </button>
          </div>
        </form>
      </div>
      <?php elseif ($adim === 2) : ?>
      <div class="checkout-card">
        <form id="checkout-step2-form" method="post" action="" data-checkout-form-step2 novalidate>
          <input type="hidden" name="checkout_adim" value="2" />
          <input type="hidden" name="checkout_form_token" value="<?php echo $h($tokenStep2); ?>" />
          <input type="hidden" name="paket" value="<?php echo $h($theme); ?>" />
          <input type="hidden" name="sinif" value="<?php echo $h($grade); ?>" />

          <div class="checkout-honeypot" aria-hidden="true">
            <label for="bilenyum-hp-step2">Web sitesi (doldurmayın)</label>
            <input type="text" name="bilenyum_hp_website" id="bilenyum-hp-step2" value="" tabindex="-1" autocomplete="off" />
          </div>

          <div class="checkout-recap" role="group" aria-label="Önceki adımda girdiğiniz iletişim özeti">
            <span class="checkout-recap-text"><?php echo $h($recapName); ?> | <?php echo $h($recapPhone); ?></span>
            <a class="checkout-recap-edit" href="<?php echo $h($duzenleUrl); ?>" aria-label="Ad ve telefonu düzenle">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            </a>
          </div>

          <div class="checkout-form-stack">
            <div class="checkout-field<?php echo isset($errorsStep2['eposta']) ? ' is-error' : ''; ?>">
              <label for="checkout-eposta">E-posta Adresi</label>
              <input
                type="email"
                id="checkout-eposta"
                name="eposta"
                autocomplete="email"
                inputmode="email"
                spellcheck="false"
                autocapitalize="off"
                autocorrect="off"
                maxlength="254"
                placeholder="ornek@alanadi.com"
                title="Örnek: ad.soyad@alanadi.com — Türkçe karakter kullanmayın; boşluk yok."
                value="<?php echo $h($oldStep2['eposta'] ?? ''); ?>"
                required
              />
              <p class="checkout-field-error" data-msg-default="Lütfen e-posta adresinizi girin."<?php echo empty($errorsStep2['eposta']) ? ' hidden' : ''; ?>><?php echo isset($errorsStep2['eposta']) ? $h($errorsStep2['eposta']) : ''; ?></p>
            </div>
            <div class="checkout-field<?php echo isset($errorsStep2['sehir']) ? ' is-error' : ''; ?>">
              <label for="checkout-sehir">Şehir</label>
              <select id="checkout-sehir" name="sehir" required>
                <option value="" disabled<?php echo ($oldStep2['sehir'] ?? '') === '' ? ' selected' : ''; ?>>Şehir seçiniz</option>
                <?php foreach ($cities as $il) :
                    $sel = ($oldStep2['sehir'] ?? '') === $il ? ' selected' : '';
                    ?>
                <option value="<?php echo $h($il); ?>"<?php echo $sel; ?>><?php echo $h($il); ?></option>
                <?php endforeach; ?>
              </select>
              <p class="checkout-field-error" data-msg-default="Lütfen şehrinizi seçin."<?php echo empty($errorsStep2['sehir']) ? ' hidden' : ''; ?>><?php echo isset($errorsStep2['sehir']) ? $h($errorsStep2['sehir']) : ''; ?></p>
            </div>
          </div>

          <div class="checkout-notice" role="note">
            <span class="checkout-notice-icon" aria-hidden="true">!</span>
            <div>
              Kişisel verileriniz
              <button type="button" class="checkout-inline-link" data-open-aydinlatma>Aydınlatma Metni</button>
              kapsamında işlenmektedir.
            </div>
          </div>

          <div class="checkout-actions">
            <button type="submit" class="checkout-btn-confirm">
              Devam Et
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
            </button>
          </div>
        </form>
      </div>
      <?php elseif ($adim === 3 && $showBitirSuccess) : ?>
      <div class="checkout-card checkout-card--done">
        <p class="checkout-done-text">Teşekkürler. Sipariş özetiniz ve iletişim bilgileriniz kaydedildi. Güvenli ödeme bağlantısı hazır olduğunda bu süreçten devam edebileceksiniz.</p>
      </div>
      <?php elseif ($adim === 3) : ?>
      <div
        class="checkout-card checkout-payment-card"
        data-checkout-payment-root
        data-checkout-total-lira="<?php echo $h((string) $totalLira); ?>"
        data-checkout-total-fmt="<?php echo $h($totalFmt); ?>"
      >
        <p class="checkout-payment-note" role="note">
          Ödeme yönteminizi seçin. Kart bilgileri güvenli ödeme sayfasında alınacaktır; aşağıdaki alanlar arayüz önizlemesidir.
        </p>
        <ul class="checkout-payment-list" role="list">
          <li class="checkout-payment-item">
            <button type="button" class="checkout-payment-row checkout-payment-row--accent" data-checkout-payment-toggle aria-expanded="true">
              <span class="checkout-payment-ico checkout-payment-ico--red" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
              </span>
              <span class="checkout-payment-label">Kredi kartı ile öde (Vade Farksız Taksit)</span>
              <span class="checkout-payment-chev" aria-hidden="true"><span class="checkout-payment-chev-plus" hidden>+</span><span class="checkout-payment-chev-minus">−</span></span>
            </button>
            <div class="checkout-payment-panel">
              <div class="checkout-cc-layout">
                <div class="checkout-cc-form">
                  <p class="checkout-cc-section-title">Kart Bilgileri</p>
                  <div class="checkout-field">
                    <label for="checkout-cc-name">Ad &amp; Soyad</label>
                    <input type="text" id="checkout-cc-name" class="checkout-cc-input" placeholder="Ad &amp; Soyad" autocomplete="cc-name" inputmode="text" />
                  </div>
                  <div class="checkout-field">
                    <label for="checkout-cc-num">Kart Numarası</label>
                    <input type="text" id="checkout-cc-num" class="checkout-cc-input" placeholder="0000 0000 0000 0000" inputmode="numeric" maxlength="19" autocomplete="cc-number" />
                  </div>
                  <div class="checkout-cc-exp-row">
                    <div class="checkout-field">
                      <label for="checkout-cc-mm">Ay</label>
                      <select id="checkout-cc-mm" class="checkout-cc-input" autocomplete="cc-exp-month" aria-label="Son kullanma ayı">
                        <?php for ($m = 1; $m <= 12; $m++) :
                            $mv = str_pad((string) $m, 2, '0', STR_PAD_LEFT);
                            ?>
                        <option value="<?php echo $h($mv); ?>"><?php echo $h($mv); ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="checkout-field">
                      <label for="checkout-cc-yy">Yıl</label>
                      <select id="checkout-cc-yy" class="checkout-cc-input" autocomplete="cc-exp-year" aria-label="Son kullanma yılı">
                        <?php
                        $y0 = (int) date('Y');
                        for ($y = $y0; $y <= $y0 + 15; $y++) :
                            ?>
                        <option value="<?php echo $h((string) $y); ?>"><?php echo $h((string) $y); ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="checkout-field">
                      <label for="checkout-cc-cvv">CCV2</label>
                      <input type="password" id="checkout-cc-cvv" class="checkout-cc-input" placeholder="•••" maxlength="4" inputmode="numeric" autocomplete="cc-csc" />
                    </div>
                  </div>
                </div>
                <div class="checkout-cc-aside">
                  <div class="checkout-cc-trust-strip" aria-hidden="true">
                    <span class="checkout-cc-trust-pill">Güvenli alışveriş</span>
                    <span class="checkout-cc-trust-pill">VISA</span>
                    <span class="checkout-cc-trust-pill">Mastercard</span>
                    <span class="checkout-cc-trust-pill">SECURE</span>
                  </div>
                  <div class="checkout-cc-preview" aria-hidden="true" data-cc-preview-card>
                    <div class="checkout-cc-preview-inner">
                      <div class="checkout-cc-face checkout-cc-face--front">
                        <div class="checkout-cc-preview-chip"></div>
                        <p class="checkout-cc-preview-num" data-cc-preview-num>•••• •••• •••• ••••</p>
                        <p class="checkout-cc-preview-name" data-cc-preview-name>AD SOYAD</p>
                        <p class="checkout-cc-preview-exp"><span>VALID THRU</span> <span data-cc-preview-exp>•• / ••</span></p>
                      </div>
                      <div class="checkout-cc-face checkout-cc-face--back">
                        <div class="checkout-cc-preview-strip"></div>
                        <div class="checkout-cc-preview-cvv-wrap">
                          <span class="checkout-cc-preview-cvv-label">CVV</span>
                          <span class="checkout-cc-preview-cvv" data-cc-preview-cvv>•••</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="checkout-payment-inline-notice" role="note">
                <span class="checkout-notice-icon" aria-hidden="true">!</span>
                <span>Kredi kartınıza ait taksit seçenekleri kart bilgilerinizi girdikten sonra gösterilecektir.</span>
              </div>
            </div>
          </li>
          <li class="checkout-payment-item">
            <button type="button" class="checkout-payment-row checkout-payment-row--accent" data-checkout-payment-toggle aria-expanded="false">
              <span class="checkout-payment-ico checkout-payment-ico--red" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M16 12h-5l2 3"/><path d="M8 16h8"/></svg>
              </span>
              <span class="checkout-payment-label">Havale / EFT ile Öde</span>
              <span class="checkout-payment-chev" aria-hidden="true"><span class="checkout-payment-chev-plus">+</span><span class="checkout-payment-chev-minus" hidden>−</span></span>
            </button>
            <div class="checkout-payment-panel" hidden>
              <div class="checkout-eft-warn" role="note">
                <span class="checkout-eft-warn-ico" aria-hidden="true">!</span>
                <p>Havale / EFT işlemlerinizde alıcı olarak <strong class="checkout-eft-strong"><?php echo $h($bilenyumSellerUnvan); ?></strong> yazınız; açıklama kısmına sipariş <strong class="checkout-eft-strong">referans numaranızı</strong> yazınız.</p>
              </div>
              <div class="checkout-bank-cards">
                <label class="checkout-bank-card">
                  <input type="radio" name="checkout_demo_bank" value="is" checked />
                  <span class="checkout-bank-card-inner">
                    <span class="checkout-bank-head">
                      <span class="checkout-bank-radio"></span>
                      <span class="checkout-bank-name">Türkiye İş Bankası</span>
                    </span>
                    <span class="checkout-bank-rows">
                      <span class="checkout-bank-row"><span class="checkout-bank-k">Ödeme</span><span class="checkout-bank-v">Havale, EFT</span></span>
                      <span class="checkout-bank-row">
                        <span class="checkout-bank-k">Ünvan</span>
                        <span class="checkout-bank-v checkout-bank-v--flex">
                          <span><?php echo $h($bilenyumSellerUnvan); ?></span>
                          <button type="button" class="checkout-copy-btn" data-copy="<?php echo $h($bilenyumSellerUnvan); ?>" title="Kopyala">⎘</button>
                        </span>
                      </span>
                      <span class="checkout-bank-row">
                        <span class="checkout-bank-k">IBAN</span>
                        <span class="checkout-bank-v checkout-bank-v--flex">
                          <strong data-checkout-iban-demo-is>TR12 0006 4000 0011 2233 4455 66</strong>
                          <button type="button" class="checkout-copy-btn" data-copy="TR120006400000112233445566" title="IBAN kopyala">⎘</button>
                        </span>
                      </span>
                    </span>
                  </span>
                </label>
                <label class="checkout-bank-card">
                  <input type="radio" name="checkout_demo_bank" value="gar" />
                  <span class="checkout-bank-card-inner">
                    <span class="checkout-bank-head">
                      <span class="checkout-bank-radio"></span>
                      <span class="checkout-bank-name">Garanti BBVA</span>
                    </span>
                    <span class="checkout-bank-rows">
                      <span class="checkout-bank-row"><span class="checkout-bank-k">Ödeme</span><span class="checkout-bank-v">Havale, EFT</span></span>
                      <span class="checkout-bank-row">
                        <span class="checkout-bank-k">Ünvan</span>
                        <span class="checkout-bank-v checkout-bank-v--flex">
                          <span><?php echo $h($bilenyumSellerUnvan); ?></span>
                          <button type="button" class="checkout-copy-btn" data-copy="<?php echo $h($bilenyumSellerUnvan); ?>" title="Kopyala">⎘</button>
                        </span>
                      </span>
                      <span class="checkout-bank-row">
                        <span class="checkout-bank-k">IBAN</span>
                        <span class="checkout-bank-v checkout-bank-v--flex">
                          <strong data-checkout-iban-demo-gar>TR34 0006 2000 1234 5678 9012 34</strong>
                          <button type="button" class="checkout-copy-btn" data-copy="TR340006200012345678901234" title="IBAN kopyala">⎘</button>
                        </span>
                      </span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
          </li>
          <li class="checkout-payment-item">
            <button type="button" class="checkout-payment-row checkout-payment-row--accent" data-checkout-payment-toggle aria-expanded="false">
              <span class="checkout-payment-ico checkout-payment-ico--red" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="6" width="7" height="12" rx="1"/><rect x="14" y="6" width="7" height="12" rx="1"/></svg>
              </span>
              <span class="checkout-payment-label">Çoklu Kredi kartı ile öde</span>
              <span class="checkout-payment-chev" aria-hidden="true"><span class="checkout-payment-chev-plus">+</span><span class="checkout-payment-chev-minus" hidden>−</span></span>
            </button>
            <div class="checkout-payment-panel" hidden>
              <p class="checkout-multi-lead">Ödeyeceğiniz toplam tutarı kartlarınıza paylaştırarak tamamlayabilirsiniz.</p>
              <div class="checkout-cc-layout checkout-multi-layout">
                <div class="checkout-cc-form">
                  <p class="checkout-cc-section-title">1. Kart Bilgileri</p>
                  <div class="checkout-field">
                    <label for="checkout-m1-amt">1. karttan çekilecek tutar (TL)</label>
                    <input type="number" id="checkout-m1-amt" class="checkout-cc-input" min="1" max="<?php echo $h((string) $totalLira); ?>" value="<?php echo $h((string) min(250, $totalLira)); ?>" inputmode="numeric" />
                  </div>
                  <div class="checkout-field">
                    <label for="checkout-m1-name">Ad &amp; Soyad</label>
                    <input type="text" id="checkout-m1-name" class="checkout-cc-input" placeholder="Ad &amp; Soyad" />
                  </div>
                  <div class="checkout-field">
                    <label for="checkout-m1-num">Kart Numarası</label>
                    <input type="text" id="checkout-m1-num" class="checkout-cc-input" placeholder="0000 0000 0000 0000" maxlength="19" inputmode="numeric" />
                  </div>
                  <div class="checkout-cc-exp-row">
                    <div class="checkout-field">
                      <label for="checkout-m1-mm">Ay</label>
                      <select id="checkout-m1-mm" class="checkout-cc-input"><?php for ($m = 1; $m <= 12; $m++) :
                          $mv = str_pad((string) $m, 2, '0', STR_PAD_LEFT); ?>
                        <option value="<?php echo $h($mv); ?>"><?php echo $h($mv); ?></option><?php endfor; ?></select>
                    </div>
                    <div class="checkout-field">
                      <label for="checkout-m1-yy">Yıl</label>
                      <select id="checkout-m1-yy" class="checkout-cc-input"><?php
                      $y0 = (int) date('Y');
                      for ($y = $y0; $y <= $y0 + 15; $y++) :
                          ?>
                        <option value="<?php echo $h((string) $y); ?>"><?php echo $h((string) $y); ?></option><?php endfor; ?></select>
                    </div>
                    <div class="checkout-field">
                      <label for="checkout-m1-cvv">CCV2</label>
                      <input type="password" id="checkout-m1-cvv" class="checkout-cc-input" maxlength="4" inputmode="numeric" />
                    </div>
                  </div>
                  <div class="checkout-payment-inline-notice" role="note">
                    <span class="checkout-notice-icon" aria-hidden="true">!</span>
                    <span>Kredi kartınıza ait taksit seçenekleri kart bilgilerinizi girdikten sonra gösterilecektir.</span>
                  </div>
                </div>
                <div class="checkout-cc-aside">
                  <p class="checkout-multi-remain" data-checkout-multi-remain>
                    2. kart için kalan tutar: <?php echo $h($totalFmt); ?> TL
                  </p>
                  <div class="checkout-cc-trust-strip" aria-hidden="true">
                    <span class="checkout-cc-trust-pill">Güvenli</span>
                    <span class="checkout-cc-trust-pill">VISA</span>
                    <span class="checkout-cc-trust-pill">MC</span>
                  </div>
                  <div class="checkout-cc-preview" aria-hidden="true" data-cc-preview-card>
                    <div class="checkout-cc-preview-inner">
                      <div class="checkout-cc-face checkout-cc-face--front">
                        <div class="checkout-cc-preview-chip"></div>
                        <p class="checkout-cc-preview-num">•••• •••• •••• ••••</p>
                        <p class="checkout-cc-preview-name">AD SOYAD</p>
                        <p class="checkout-cc-preview-exp"><span>VALID THRU</span> •• / ••</p>
                      </div>
                      <div class="checkout-cc-face checkout-cc-face--back">
                        <div class="checkout-cc-preview-strip"></div>
                        <div class="checkout-cc-preview-cvv-wrap">
                          <span class="checkout-cc-preview-cvv-label">CVV</span>
                          <span class="checkout-cc-preview-cvv">•••</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="checkout-multi-locked" role="note">
                <span class="checkout-multi-lock-ico" aria-hidden="true">🔒</span>
                <p>Birinci kredi kartı bilgileriniz ödeme sayfasında onaylandıktan sonra ikinci kart bilgilerinizi girebilirsiniz.</p>
              </div>
            </div>
          </li>
          <li class="checkout-payment-item">
            <button type="button" class="checkout-payment-row checkout-payment-row--accent" data-checkout-payment-toggle aria-expanded="false">
              <span class="checkout-payment-ico checkout-payment-ico--iyzbrand" aria-hidden="true">iyzico</span>
              <span class="checkout-payment-label checkout-payment-label--iyz"><span class="checkout-iyz-word">iyzico</span> ile Öde</span>
              <span class="checkout-payment-chev" aria-hidden="true"><span class="checkout-payment-chev-plus">+</span><span class="checkout-payment-chev-minus" hidden>−</span></span>
            </button>
            <div class="checkout-payment-panel" hidden>
              <div class="checkout-iyz-info" role="note">
                <span class="checkout-notice-icon" aria-hidden="true">!</span>
                <p>
                  iyzico, kart bilgilerinizi paylaşmadan güvenle alışveriş yapmanızı sağlayan bir ödeme çözümüdür.
                  İşlem tamamlandığında bankanızın sunduğu taksit ve kampanyalardan yararlanmaya devam edebilirsiniz.
                </p>
              </div>
              <label class="checkout-iyz-select">
                <input type="radio" name="checkout_demo_paygate" value="iyzico" checked />
                <span class="checkout-iyz-select-mark" aria-hidden="true">✓</span>
                <span class="checkout-iyz-logo" aria-hidden="true">iyzico</span>
                <span class="checkout-iyz-select-label">Güvenli ödeme ile devam etmek için seçili bırakın</span>
              </label>
            </div>
          </li>
        </ul>
      </div>
      <?php endif; ?>

      <a class="checkout-back" href="paket-detay.html?<?php echo $h(http_build_query(['paket' => $theme, 'sinif' => $grade])); ?>">← Paket sayfasına dön</a>
    </section>

    <aside class="checkout-col checkout-col--summary" aria-labelledby="checkout-summary-title">
      <header class="checkout-col-head">
        <h2 class="checkout-section-title checkout-section-title--h2" id="checkout-summary-title">Özet</h2>
        <p class="checkout-section-lead checkout-section-lead--summary">
          Seçtiğiniz paket ve ödeme tutarı özeti. Devam adımlarında tutar doğrulanır.
        </p>
      </header>
      <div class="checkout-card checkout-summary-card<?php echo $adim === 3 ? ' checkout-summary-card--sticky' : ''; ?>">
        <?php if ($adim === 3 && !$showBitirSuccess && isset($errorsStep3['genel'])) : ?>
          <p class="checkout-step3-inline-error" role="alert"><?php echo $h((string) $errorsStep3['genel']); ?></p>
        <?php endif; ?>
        <div class="checkout-product">
          <img class="checkout-product-thumb" src="<?php echo $h($imgUrl); ?>" alt="" width="72" height="52" decoding="async" />
          <div class="checkout-product-body">
            <p class="checkout-product-title"><?php echo $h($pkgTitle); ?></p>
            <p class="checkout-product-meta"><?php echo $h($gradeLabel); ?> · 12 ay</p>
            <p class="checkout-product-price"><?php echo $h($totalFmt); ?> TL</p>
          </div>
        </div>
        <?php if ($adim >= 2) : ?>
        <div class="checkout-summary-payable">
          <span class="checkout-summary-payable-label">Ödenecek Tutar</span>
        </div>
        <?php endif; ?>
        <div class="checkout-summary-total">
          <span>Toplam</span>
          <span class="checkout-summary-total-amount"><?php echo $h($totalFmt); ?> TL</span>
        </div>
        <div class="checkout-installment">Vade Farksız 12 Taksit (Aylık <?php echo $h($installFmt); ?> TL)</div>

        <?php if ($adim === 3 && !$showBitirSuccess) : ?>
        <form id="checkout-step3-form" method="post" action="" class="checkout-step3-form" data-checkout-form-step3 novalidate>
          <input type="hidden" name="checkout_adim" value="3" />
          <input type="hidden" name="checkout_form_token" value="<?php echo $h($tokenStep3); ?>" />
          <input type="hidden" name="paket" value="<?php echo $h($theme); ?>" />
          <input type="hidden" name="sinif" value="<?php echo $h($grade); ?>" />
          <div class="checkout-honeypot" aria-hidden="true">
            <label for="bilenyum-hp-step3">Web sitesi (doldurmayın)</label>
            <input type="text" name="bilenyum_hp_website" id="bilenyum-hp-step3" value="" tabindex="-1" autocomplete="off" />
          </div>

          <div class="checkout-actions checkout-actions--step3">
            <button type="submit" class="checkout-btn-confirm">
              Onayla ve Bitir
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
            </button>
          </div>

          <div class="checkout-step3-legal<?php echo isset($errorsStep3['mesafeli']) ? ' is-error' : ''; ?>">
            <label class="checkout-step3-check">
              <input type="checkbox" name="mesafeli_onay" value="1" />
              <span>
                <button type="button" class="checkout-inline-link" data-open-onbilgilendirme>Ön Bilgilendirme Formu</button>’nu okudum,
                Mesafeli Satış Sözleşmesi’ni kabul ediyorum.
              </span>
            </label>
            <?php if (!empty($errorsStep3['mesafeli'])) : ?>
              <p class="checkout-field-error"><?php echo $h((string) $errorsStep3['mesafeli']); ?></p>
            <?php endif; ?>
            <label class="checkout-step3-check">
              <input type="checkbox" name="ticari_izin" value="1" />
              <span>
                <button type="button" class="checkout-inline-link" data-open-ticari>Ticari iletişim metni</button> kapsamında ticari iletişime izin veriyorum.
              </span>
            </label>
          </div>
        </form>
        <?php endif; ?>
      </div>
    </aside>
  </div>
</main>

<footer class="checkout-footer" aria-label="Satın alma alt bilgisi">
  <div class="checkout-footer-inner">
    <div class="checkout-footer-tier1">
      <div class="checkout-footer-brand">
        <a class="checkout-footer-logo" href="landing-reference.php">
          <img src="../../assets/logo.png" alt="Bilenyum" width="180" height="44" decoding="async" />
        </a>
        <p class="checkout-footer-tagline">Öğrenmenin dijital hali</p>
        <p class="checkout-footer-desc">Canlı dersler, kayıt arşivi ve veli paneli ile Türkiye’de online eğitimde şeffaf deneyim.</p>
      </div>
      <ul class="checkout-footer-badges" aria-label="Öne çıkanlar">
        <li class="checkout-footer-badge checkout-footer-badge--stat">
          <div class="checkout-footer-badge-num" aria-hidden="true">
            <span class="checkout-footer-badge-k">12</span><span class="checkout-footer-badge-t"> ay</span>
          </div>
          <span class="checkout-footer-badge-s">Program süresi</span>
        </li>
        <li class="checkout-footer-badge">
          <span class="checkout-footer-badge-ico" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
          </span>
          <span class="checkout-footer-badge-s">Veli paneli</span>
        </li>
        <li class="checkout-footer-badge">
          <span class="checkout-footer-badge-ico" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </span>
          <span class="checkout-footer-badge-s">Canlı &amp; kayıt</span>
        </li>
        <li class="checkout-footer-badge">
          <span class="checkout-footer-badge-ico" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </span>
          <span class="checkout-footer-badge-s">KVKK uyumlu</span>
        </li>
      </ul>
    </div>
    <div class="checkout-footer-rule" role="presentation"></div>
    <div class="checkout-footer-tier2">
      <p class="checkout-footer-copy">© <?php echo $h((string) date('Y')); ?> Bilenyum — Tüm hakları saklıdır.</p>
      <div class="checkout-footer-trust" aria-label="Ödeme yöntemleri">
        <span class="checkout-trust-band" title="Kabul edilen ödeme yöntemleri">
          <img
            src="../components/images/logo_band_white.svg"
            alt="Kabul edilen ödeme yöntemleri"
            width="620"
            height="40"
            loading="lazy"
            decoding="async"
          />
        </span>
      </div>
    </div>
  </div>
</footer>

<?php if ($adim === 3 && !$showBitirSuccess) : ?>
<dialog id="checkoutOnBilgilendirmeDialog" class="checkout-aydinlatma-dialog checkout-legal-dialog" aria-labelledby="checkoutOnBilgilendirmeTitle">
  <div class="checkout-aydinlatma-dialog-surface checkout-legal-dialog-surface">
    <header class="checkout-aydinlatma-dialog-header">
      <h2 id="checkoutOnBilgilendirmeTitle" class="checkout-aydinlatma-dialog-title">Ön Bilgilendirme Formu</h2>
      <button type="button" class="checkout-aydinlatma-close" data-close-onbilgilendirme aria-label="Kapat">
        <span aria-hidden="true">×</span>
      </button>
    </header>
    <div class="checkout-aydinlatma-dialog-body checkout-legal-dialog-body">
      <?php include __DIR__ . '/../php/templates/checkout-on-bilgilendirme-body.php'; ?>
    </div>
  </div>
</dialog>

<dialog id="checkoutTicariDialog" class="checkout-aydinlatma-dialog checkout-legal-dialog" aria-labelledby="checkoutTicariTitle">
  <div class="checkout-aydinlatma-dialog-surface checkout-legal-dialog-surface">
    <header class="checkout-aydinlatma-dialog-header">
      <h2 id="checkoutTicariTitle" class="checkout-aydinlatma-dialog-title checkout-ticari-dialog-title">Ticari iletişim ve açık rıza</h2>
      <button type="button" class="checkout-aydinlatma-close" data-close-ticari aria-label="Kapat">
        <span aria-hidden="true">×</span>
      </button>
    </header>
    <div class="checkout-aydinlatma-dialog-body checkout-legal-dialog-body">
      <?php include __DIR__ . '/../php/templates/checkout-ticari-iletisim-body.php'; ?>
    </div>
  </div>
</dialog>
<?php endif; ?>

<dialog id="checkoutAydinlatmaDialog" class="checkout-aydinlatma-dialog" aria-labelledby="checkoutAydinlatmaTitle">
  <div class="checkout-aydinlatma-dialog-surface">
    <header class="checkout-aydinlatma-dialog-header">
      <h2 id="checkoutAydinlatmaTitle" class="checkout-aydinlatma-dialog-title">Aydınlatma metni</h2>
      <button type="button" class="checkout-aydinlatma-close" data-close-aydinlatma aria-label="Kapat">
        <span aria-hidden="true">×</span>
      </button>
    </header>
    <div class="checkout-aydinlatma-dialog-body">
      <?php
      $aydinlatma_show_back_link = false;
      include __DIR__ . '/../php/templates/aydinlatma-metni-body.php';
      ?>
    </div>
    <div class="checkout-aydinlatma-dialog-footer">
      <a class="checkout-aydinlatma-fullpage" href="aydinlatma-metni.php" target="_blank" rel="noopener">Yeni sekmede tam sayfa aç</a>
    </div>
  </div>
</dialog>

<div id="checkoutPageLoading" class="checkout-page-loading" hidden role="status" aria-live="polite" aria-busy="false">
  <div class="checkout-page-loading-inner">
    <span class="checkout-page-loading-spinner" aria-hidden="true"></span>
    <span class="checkout-page-loading-text">Yükleniyor…</span>
  </div>
</div>

<script src="../components/scripts/checkout-odeme.js" charset="utf-8"></script>
</body>
</html>
