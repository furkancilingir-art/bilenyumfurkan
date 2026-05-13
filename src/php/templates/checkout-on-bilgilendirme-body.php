<?php
/**
 * Ön Bilgilendirme Formu gövdesi — checkout adım 3 modal.
 * Üst dosya tanımlar: $h callback, $onb_* değişkenleri.
 *
 * @var callable $h
 * @var string $onb_satici_unvan
 * @var string $onb_satici_mersis
 * @var string $onb_satici_adres
 * @var string $onb_satici_tel
 * @var string $onb_satici_email
 * @var string $onb_satici_kep
 * @var string $onb_satici_web
 * @var string $onb_alici_ad
 * @var string $onb_alici_adres
 * @var string $onb_alici_tel
 * @var string $onb_alici_email
 * @var string $onb_paket_ad
 * @var string $onb_paket_aciklama
 * @var string $onb_toplam_tl
 */
declare(strict_types=1);

$h = $h ?? static fn (string $s): string => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
?>
<div class="checkout-legal-doc checkout-legal-doc--onbilgi">
  <h3 class="checkout-legal-doc__title">ÖN BİLGİLENDİRME FORMU</h3>

  <p class="checkout-legal-doc__p"><strong>1. KONU</strong></p>
  <p class="checkout-legal-doc__p">
    İşbu form, <?php echo $h($onb_satici_unvan); ?> (“SATICI”) ile internet üzerinden dijital eğitim içeriği satın alan tüketici (“ALICI”) arasındaki ön bilgilendirme yükümlülüğünün yerine getirilmesi amacıyla hazırlanmıştır.
    Satın alınan ürün niteliği itibarıyla dijital içerik ve çevrimiçi hizmetlerden oluşmaktadır.
  </p>

  <p class="checkout-legal-doc__p"><strong>2. TARAFLAR</strong></p>
  <p class="checkout-legal-doc__p"><strong>2.1. SATICI</strong></p>
  <ul class="checkout-legal-doc__list">
    <li><strong>Unvan:</strong> <?php echo $h($onb_satici_unvan); ?></li>
    <li><strong>MERSİS No:</strong> <?php echo $h($onb_satici_mersis); ?></li>
    <li><strong>Adres:</strong> <?php echo $h($onb_satici_adres); ?></li>
    <li><strong>Telefon:</strong> <?php echo $h($onb_satici_tel); ?></li>
    <li><strong>E-posta:</strong> <?php echo $h($onb_satici_email); ?></li>
    <li><strong>KEP adresi:</strong> <?php echo $h($onb_satici_kep); ?></li>
    <li><strong>Web:</strong> <?php echo $h($onb_satici_web); ?></li>
  </ul>

  <p class="checkout-legal-doc__p"><strong>2.2. ALICI</strong></p>
  <ul class="checkout-legal-doc__list">
    <li><strong>Adı Soyadı:</strong> <?php echo $h($onb_alici_ad); ?></li>
    <li><strong>Adres:</strong> <?php echo $h($onb_alici_adres); ?></li>
    <li><strong>Telefon:</strong> <?php echo $h($onb_alici_tel); ?></li>
    <li><strong>E-posta:</strong> <?php echo $h($onb_alici_email); ?></li>
  </ul>

  <p class="checkout-legal-doc__p">
    <strong>2.3.</strong> Alıcı’nın kısıtlılık veya temyiz kudretinin bulunmadığı hallerde veli/vasi onayı ve ilgili mevzuat hükümleri geçerlidir.
  </p>

  <p class="checkout-legal-doc__p"><strong>3. SÖZLEŞME KONUSU DİJİTAL ÜRÜN VE BEDELİ</strong></p>
  <p class="checkout-legal-doc__p">
    <strong>3.1.</strong> Dijital ürün; canlı veya kayıtlı ders içerikleri, platform erişimi ve paket kapsamında sunulan çevrimiçi materyallerden oluşur.
  </p>

  <div class="checkout-legal-table-wrap">
    <table class="checkout-legal-table">
      <thead>
        <tr>
          <th scope="col">Paket Adı</th>
          <th scope="col">Açıklama</th>
          <th scope="col">Toplam Tutar</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $h($onb_paket_ad); ?></td>
          <td><?php echo $h($onb_paket_aciklama); ?></td>
          <td><strong><?php echo $h($onb_toplam_tl); ?> TL</strong></td>
        </tr>
      </tbody>
    </table>
  </div>

  <p class="checkout-legal-doc__p">
    <strong>3.2.</strong> Ürün bedeli, sipariş özeti ve ödeme ekranında gösterilen tutar üzerinden tahsil edilir; vergiler ve yasal kesintiler ilgili mevzuata tabidir.
  </p>
  <p class="checkout-legal-doc__p">
    <strong>3.3.</strong> Dijital içeriğe erişim, ödemenin doğrulanması ve kullanıcı hesabının tanımlanmasıyla başlar; internet bağlantısı ve uyumlu cihaz Alıcı’nın sorumluluğundadır.
  </p>

  <p class="checkout-legal-doc__p"><strong>4. KULLANIM SÜRESİ</strong></p>
  <p class="checkout-legal-doc__p">
    Paket süresi siparişte belirtilen program süresi ile sınırlıdır (ör. 12 ay). Süre dolduğunda erişim ilan edilen koşullara göre sona erer.
  </p>

  <p class="checkout-legal-doc__p"><strong>5. ÖDEME YÖNTEMLERİ</strong></p>
  <ul class="checkout-legal-doc__list">
    <li><strong>Kredi kartı:</strong> Güvenli ödeme sayfası üzerinden; bankanızın sunduğu taksit koşulları bankanıza bağlıdır.</li>
    <li><strong>Havale / EFT:</strong> SATICI’nın bildirdiği hesaplara, sipariş referans numarası ile yapılır.</li>
    <li><strong>iyzico:</strong> Ödeme sayfasına yönlendirme ile güvenli tahsilat.</li>
  </ul>

  <p class="checkout-legal-doc__p"><strong>6. CAYMA HAKKI</strong></p>
  <p class="checkout-legal-doc__p">
    Elektronik ortamda anında ifa edilen dijital içerik ve çevrimiçi hizmetlerde, içerik ifaya başladıysa Mesafeli Sözleşmeler Yönetmeliği uyarınca cayma hakkı kullanılamayabilir.
    Ayrıntılar için Mesafeli Satış Sözleşmesi’ne bakınız.
  </p>

  <p class="checkout-legal-doc__p"><strong>7. KİŞİSEL VERİLER</strong></p>
  <p class="checkout-legal-doc__p">
    Alıcı bilgileri; sözleşmenin kurulması ve ifası, müşteri hizmetleri ve yasal yükümlülükler kapsamında işlenir. Ayrıntılar için Aydınlatma Metni’ne başvurabilirsiniz.
  </p>

  <p class="checkout-legal-doc__p"><strong>8. UYUŞMAZLIK</strong></p>
  <p class="checkout-legal-doc__p">
    İşbu metin Türkiye Cumhuriyeti kanunlarına tabidir. Tüketici uyuşmazlıklarında Tüketici Hakem Heyetleri ve Tüketici Mahkemeleri yetkilidir.
  </p>

  <p class="checkout-legal-doc__footnote">
    Bu metin özet bilgilendirme amaçlıdır; bağlayıcı hükümler için Mesafeli Satış Sözleşmesi ve ilgili politikalara bakınız.
  </p>
</div>
