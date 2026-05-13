<?php
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$nav_active = 'kadro';

$raw_id = isset($_GET['id']) ? (string) $_GET['id'] : '';
$id = preg_replace('/[^a-z0-9_-]/i', '', $raw_id);

$kadro_team = require __DIR__ . '/../php/data/kadro-team-data.php';
if (!is_array($kadro_team)) {
    $kadro_team = [];
}

$member = null;
foreach ($kadro_team as $m) {
    if (($m['id'] ?? '') === $id) {
        $member = $m;
        break;
    }
}

if (!$member) {
    header('Location: kadromuz.php', true, 302);
    exit;
}

$kadro_departments = require __DIR__ . '/../php/data/kadro-departments.php';
if (!is_array($kadro_departments)) {
    $kadro_departments = [];
}

$dept_key = $member['dept'] ?? '';
$dept_label = $kadro_departments[$dept_key] ?? $dept_key;

$member_id_safe = preg_replace('/[^a-z0-9_-]/i', '', (string) ($member['id'] ?? ''));
$kadro_detail_photo = '../components/images/kadro/' . rawurlencode($member_id_safe) . '.jpg';

require_once __DIR__ . '/../php/include/pricing-assets-path.php';

$page_title = htmlspecialchars((string) ($member['name'] ?? ''), ENT_QUOTES, 'UTF-8') . ' — Bilenyum Kadrosu';
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo $page_title; ?></title>
  <meta name="description" content="<?php echo htmlspecialchars((string) ($member['title'] ?? '') . ' · ' . $dept_label, ENT_QUOTES, 'UTF-8'); ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../components/styles/main.css">
  <link rel="stylesheet" href="../components/styles/landing-reference.css">
</head>
<body class="page-kadro-detay">
<div class="site-header"><?php include __DIR__ . '/../php/templates/topbar.php'; ?><?php include __DIR__ . '/../php/templates/header.php'; ?></div>

<nav class="kadro-detail-breadcrumb" aria-label="Gezinti">
  <div class="kadro-detail-breadcrumb-inner">
    <a href="kadromuz.php" class="kadro-detail-back">← Eğitmen kadromuz</a>
  </div>
</nav>

<section class="sec sec-kadro-detail light" aria-labelledby="kadro-detail-name">
  <div class="sec-inner kadro-detail-inner">
    <div class="kadro-detail-layout">
      <div class="kadro-detail-visual-col">
        <div class="kadro-detail-portrait kadro-detail-portrait--photo">
          <div class="kadro-detail-photo-frame">
            <img
              class="kadro-detail-photo"
              src="<?php echo htmlspecialchars($kadro_detail_photo, ENT_QUOTES, 'UTF-8'); ?>"
              alt="<?php echo htmlspecialchars((string) ($member['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
              width="480"
              height="600"
              loading="eager"
              decoding="async"
            />
          </div>
        </div>
      </div>
      <div class="kadro-detail-content-col">
        <header class="kadro-detail-header">
          <p class="kadro-detail-eyebrow"><?php echo htmlspecialchars($dept_label, ENT_QUOTES, 'UTF-8'); ?></p>
          <h1 id="kadro-detail-name" class="kadro-detail-name"><?php echo htmlspecialchars((string) ($member['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h1>
          <p class="kadro-detail-role"><?php echo htmlspecialchars((string) ($member['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
        </header>

        <div class="kadro-detail-section">
          <h2 class="kadro-detail-label">LinkedIn</h2>
          <a href="<?php echo htmlspecialchars((string) ($member['linkedin'] ?? '#'), ENT_QUOTES, 'UTF-8'); ?>" class="kadro-li-button" target="_blank" rel="noopener noreferrer">
            <span class="kadro-li-button__icon" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" focusable="false"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </span>
            <span class="kadro-li-button__text">Profili LinkedIn’de görüntüle</span>
          </a>
        </div>

        <div class="kadro-detail-section">
          <h2 class="kadro-detail-label">Mezun olunan okul</h2>
          <p class="kadro-detail-text"><?php echo htmlspecialchars((string) ($member['school'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="kadro-detail-section">
          <h2 class="kadro-detail-label">Uzman olduğu alanlar</h2>
          <ul class="kadro-tag-list">
            <?php foreach ($member['expertise'] ?? [] as $tag): ?>
              <li><?php echo htmlspecialchars((string) $tag, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="kadro-detail-section">
          <h2 class="kadro-detail-label">Biyografi</h2>
          <p class="kadro-detail-text kadro-detail-text--bio"><?php echo htmlspecialchars((string) ($member['bio'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="kadro-detail-section kadro-detail-section--spark">
          <h2 class="kadro-detail-label">Bilenyum notu</h2>
          <p class="kadro-detail-text kadro-detail-spark"><?php echo htmlspecialchars((string) ($member['spark'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <?php if (!empty($member['extra']) && is_array($member['extra'])): ?>
        <div class="kadro-detail-section">
          <h2 class="kadro-detail-label">Daha fazla detay</h2>
          <dl class="kadro-detail-dl">
            <?php foreach ($member['extra'] as $k => $v): ?>
              <dt><?php echo htmlspecialchars((string) $k, ENT_QUOTES, 'UTF-8'); ?></dt>
              <dd><?php echo htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); ?></dd>
            <?php endforeach; ?>
          </dl>
        </div>
        <?php endif; ?>

        <p class="kadro-detail-footer-nav">
          <a href="kadromuz.php" class="kadro-detail-back-foot">← Kadro listesine dön</a>
        </p>
      </div>
    </div>
  </div>
</section>

<div class="space-divider-light space-divider-light--footer-bridge">
  <div class="geo-circle-light"></div>
  <div class="geo-dot-light d1"></div>
  <div class="geo-dot-light d2"></div>
  <div class="geo-line-light"></div>
  <div class="geo-tri-light"></div>
  <svg class="space-wave-light" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,120 C320,160 640,90 960,140 C1180,175 1320,115 1440,150 L1440,200 L0,200 Z" fill="rgba(62,58,142,0.14)"/>
    <path d="M0,150 C260,195 540,115 820,165 C1080,210 1300,140 1440,175 L1440,200 L0,200 Z" fill="rgba(227,92,151,0.15)"/>
    <path d="M0,175 C200,215 460,145 720,178 C960,208 1180,148 1440,178 L1440,200 L0,200 Z" fill="#ffffff"/>
  </svg>
</div>

<?php include __DIR__ . '/../php/templates/footer.php'; ?>
<?php include __DIR__ . '/../php/templates/fab.php'; ?>
<?php include __DIR__ . '/../php/templates/video-modal.php'; ?>
<script>window.__pricingImgBase=<?php echo json_encode($pricingImgWebBase, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;</script>
<script src="../components/scripts/pricing-catalog.js" charset="utf-8"></script>
<script src="../components/scripts/landing-reference.js" charset="utf-8"></script>
<script src="../components/scripts/yumi-assistant.js" charset="utf-8"></script>
<script src="../components/scripts/main.js"></script>
</body>
</html>
