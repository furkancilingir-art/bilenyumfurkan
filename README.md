# Bilenyum v2

Proje tekrar **klasik `src/` yapısına** döndürüldü (sayfalar buradan çalışır).

## Klasörler

| Yol | İçerik |
|-----|--------|
| `src/pages/` | `landing-reference.php`, `egitim-setleri.php`, `paket-detay.html`, … |
| `src/components/styles/` | CSS |
| `src/components/scripts/` | JS (`pricing-catalog.js`, `landing-reference.js`, …) |
| `src/components/images/` | SVG görseller |
| `src/php/templates/` | PHP parçaları (header, footer, main-content, …) |

## Sayfaları nasıl açarsınız?

### 1) Landing (PHP şart)

Terminalde proje kökünde (`Bilenyum v2`):

```bash
php -S 127.0.0.1:8080 -t src/pages
```

Tarayıcı: **http://127.0.0.1:8080/landing-reference.php**

### 2) Paket detay (HTML — doğrudan dosya veya aynı sunucu)

- Aynı PHP sunucusunda: **http://127.0.0.1:8080/paket-detay.html?paket=tum-dersler&sinif=8**
- veya `src/pages/paket-detay.html` dosyasını çift tıklayıp tarayıcıda açın (`../components/…` yolları bu klasör yapısına göre çalışır).

**Not:** `landing-reference.php` için mutlaka PHP yerleşik sunucusu veya Apache/Nginx kullanın; sadece “dosyayı aç” çalışmaz.

## Türkçe metinler (katalog JS)

Gerekirse:

```bash
node scripts/generate-pricing-utf8.mjs
```

Çıktı: `src/components/scripts/pricing-catalog.js` ve `paket-detay.js`

## GitHub ve Vercel (önerilen kök: bu klasör)

**Komut satırı kullanmak istemiyorsanız:** `Bilenyum v2` klasöründe **`git-ilk-push.bat`** dosyasına çift tıklayın (Git kurulu olmalı). Token yalnızca istenirse yapıştırılır.

1. Bu klasörde git başlatıp GitHub’a itin (boş repo, token ile HTTPS).
2. Vercel’de **Import** → aynı repo → **Root Directory** `.` (repo kökü `Bilenyum v2` ise).
3. Deploy sonrası PHP sayfaları **temiz URL** ile açılır (ör. `/giris-kayit`); `vercel-php` için `vercel.json` ve `api/index.php` kullanılır. Her deploy öncesi `npm run vercel-build` ile `src/components` dosyaları `public/` altına kopyalanır; böylece CSS/JS/SVG Vercel CDN’den doğru yüklenir.

Yerel geliştirme yine `php -S 127.0.0.1:8080 -t src/pages` ile yapılır; Vercel ortamında `VERCEL` değişkeni ile görsel taban yolu otomatik ayarlanır.
