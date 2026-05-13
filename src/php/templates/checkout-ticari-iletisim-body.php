<?php
/**
 * Ticari elektronik ileti / açık rıza metni — checkout adım 3 modal.
 * @var callable $h
 * @var string $ticari_sirket_unvan
 */
declare(strict_types=1);

$h = $h ?? static fn (string $s): string => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
$ticari_sirket_unvan = $ticari_sirket_unvan ?? 'Bilenyum';
?>
<div class="checkout-legal-doc checkout-legal-doc--ticari">
  <h3 class="checkout-legal-doc__title checkout-legal-doc__title--ticari">TİCARİ İLETİ VE AÇIK RIZA</h3>

  <p class="checkout-legal-doc__p">
    6698 sayılı Kişisel Verilerin Korunması Kanunu (“KVKK”) ve 6563 sayılı Elektronik Ticaretin Düzenlenmesi Hakkında Kanun ile ilgili mevzuat kapsamında;
    <?php echo $h($ticari_sirket_unvan); ?> tarafından, tarafınıza kampanya, tanıtım, anket, etkinlik ve benzeri ticari elektronik iletilerin
    e-posta, telefon (arama/SMS), anlık bildirim ve diğer elektronik kanallar üzerinden gönderilmesi için
    <strong>açık rızanız</strong> talep edilmektedir.
  </p>

  <p class="checkout-legal-doc__p"><strong>Ticari ileti hakkında</strong></p>
  <p class="checkout-legal-doc__p">
    Onay vermeniz halinde; ürün ve hizmetlere ilişkin duyurular, fırsatlar, bilgilendirmeler ve pazarlama içerikleri tarafınıza iletilebilir.
    İletişim tercihlerinizi dilediğiniz zaman güncelleyebilir veya izninizi geri çekebilirsiniz (ör. iletilerdeki link veya müşteri hizmetleri).
  </p>

  <p class="checkout-legal-doc__p">
    Bu kutu işaretlenmezse tarafınıza yalnızca mevcut sipariş ve yasal zorunluluklarla sınırlı iletişim yapılabilir; ticari tanıtım gönderimi yapılmaz.
  </p>

  <p class="checkout-legal-doc__footnote">
    Kişisel verilerin işlenmesine ilişkin ayrıntılar için site üzerindeki Aydınlatma Metni’ne başvurunuz.
  </p>
</div>
