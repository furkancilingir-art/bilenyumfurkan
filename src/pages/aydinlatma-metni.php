<?php
declare(strict_types=1);

if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$aydinlatma_show_back_link = true;
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Aydınlatma metni — Bilenyum</title>
  <meta name="description" content="6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında veri sorumlusu sıfatıyla aydınlatma metni." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../components/styles/checkout-odeme.css">
  <style>
    body { margin: 0; background: #f6f7fb; color: #12152a; font-family: 'Montserrat', system-ui, sans-serif; }
    .wrap { max-width: 720px; margin: 0 auto; padding: 40px 22px 64px; }
  </style>
</head>
<body>
  <div class="wrap">
    <?php include __DIR__ . '/../php/templates/aydinlatma-metni-body.php'; ?>
  </div>
</body>
</html>
