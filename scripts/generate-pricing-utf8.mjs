/**
 * Generates pricing-catalog.js and paket-detay.js as UTF-8 on disk.
 * Source uses only ASCII + \\u escapes so editors/agents never mangle bytes.
 */
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const scriptsDir = path.join(__dirname, '..', 'src', 'components', 'scripts');

const pricingCatalogJs = `/**
 * Ortak e\\u011fitim paketi katalo\\u011fu \\u2014 landing fiyat kartlar\\u0131 + paket detay (landing-reference.js, paket-detay.js)
 * UTF-8 \\u2014 T\\u00fcrk\\u00e7e karakterler bu dosyada saklan\\u0131r.
 */
(function () {
  window.BILENYUM_PRICING_CATALOG = {
    '8': [
      {
        theme: 'hizlandirma',
        name: 'LGS H\\u0131zland\\u0131rma',
        price: '899',
        total: '10.788',
        users: '1.120',
        img: '../components/images/pricing-hizlandirma.svg',
        alt: 'LGS h\\u0131zland\\u0131rma paketi g\\u00f6rseli',
        features: [
          'S\\u0131nava yak\\u0131n d\\u00f6nem yo\\u011fun LGS tekrar ve peki\\u015ftirme',
          'G\\u00fcnl\\u00fck canl\\u0131 / kay\\u0131ttan izlenebilir ak\\u0131\\u015f ve \\u00f6dev bloklar\\u0131',
          'Bran\\u015f bazl\\u0131 mini deneme ve eksik kapan\\u0131\\u015f \\u00f6nerileri',
          'Veli panelinde haftal\\u0131k \\u00f6zet ve uyar\\u0131lar',
        ],
      },
      {
        theme: 'tum-dersler',
        name: 'LGS T\\u00fcm Dersler Paketi',
        price: '1.290',
        total: '15.480',
        users: '2.050',
        img: '../components/images/pricing-tum-dersler.svg',
        alt: 'LGS t\\u00fcm dersler paketi g\\u00f6rseli',
        features: [
          'LGS kapsam\\u0131ndaki t\\u00fcm derslerde canl\\u0131 ders eri\\u015fimi',
          'Dijital i\\u00e7erik ve kay\\u0131t ar\\u015fivi',
          'Veli bilgilendirme paneli ve d\\u00fczenli rapor',
          'Telafi ve kat\\u0131l\\u0131m takibi',
        ],
      },
      {
        theme: 'sayisal',
        name: 'LGS Say\\u0131sal Paketi',
        price: '1.190',
        total: '14.280',
        users: '1.580',
        img: '../components/images/pricing-sayisal.svg',
        alt: 'LGS say\\u0131sal paket g\\u00f6rseli',
        features: [
          'Matematik, Fen Bilimleri ve say\\u0131sal odakl\\u0131 i\\u00e7erikler',
          'Konu + soru tipi bazl\\u0131 deneme ve analiz',
          'Hedeflenen net ve s\\u0131ralama i\\u00e7in \\u00e7al\\u0131\\u015fma \\u00f6nerileri',
          '\\u00d6\\u011fretmen geri bildirimi ve veli \\u00f6zeti',
        ],
      },
      {
        theme: 'sozel',
        name: 'LGS S\\u00f6zel Paketi',
        price: '1.190',
        total: '14.280',
        users: '1.420',
        img: '../components/images/pricing-sozel.svg',
        alt: 'LGS s\\u00f6zel paket g\\u00f6rseli',
        features: [
          'T\\u00fcrk\\u00e7e, T.C. \\u0130nk\\u0131lap, Din ve \\u0130ngilizce odakl\\u0131 program',
          'Okuma anlama ve paragraf \\u00e7al\\u0131\\u015fma parkurlar\\u0131',
          'Yaz\\u0131l\\u0131 / s\\u00f6zel s\\u0131navlara uygun kaynaklar',
          'D\\u00fczenli performans raporu',
        ],
      },
      {
        theme: 'birebir',
        name: 'Birebir \\u00d6zel Ders Paketi',
        price: '2.590',
        total: '31.080',
        users: '520',
        img: '../components/images/pricing-birebir.svg',
        alt: 'Birebir \\u00f6zel ders paketi g\\u00f6rseli',
        features: [
          'Birebir \\u00f6zel ders saatleri ve esnek planlama',
          '\\u00d6\\u011frenciye \\u00f6zel i\\u00e7erik ve \\u00f6dev takibi',
          'Veli ile d\\u00fczenli g\\u00f6r\\u00fc\\u015fme \\u00f6zeti',
          '\\u00d6ncelikli akademik destek hatt\\u0131',
        ],
      },
    ],
    '7': [
      {
        theme: 'tum-dersler',
        name: 'T\\u00fcm Dersler Paketi',
        price: '1.090',
        total: '13.080',
        users: '1.780',
        img: '../components/images/pricing-tum-dersler.svg',
        alt: 'T\\u00fcm dersler paketi g\\u00f6rseli',
        features: [
          'S\\u0131n\\u0131f m\\u00fcfredat\\u0131na uygun t\\u00fcm derslerde canl\\u0131 ders',
          'Kay\\u0131tl\\u0131 i\\u00e7erik ve tekrar imk\\u00e2n\\u0131',
          'Veli paneli ve d\\u00f6nem raporu',
          'Telafi ve devams\\u0131zl\\u0131k bildirimi',
        ],
      },
      {
        theme: 'sayisal',
        name: 'Say\\u0131sal Paketi',
        price: '990',
        total: '11.880',
        users: '1.340',
        img: '../components/images/pricing-sayisal.svg',
        alt: 'Say\\u0131sal paket g\\u00f6rseli',
        features: [
          'Matematik ve fen bilimleri a\\u011f\\u0131rl\\u0131kl\\u0131 program',
          'Konu testleri ve geli\\u015fim grafi\\u011fi',
          'Deneme sonu\\u00e7lar\\u0131yla eksik kazan\\u0131m uyar\\u0131s\\u0131',
          '\\u00d6\\u011fretmen geri bildirimi',
        ],
      },
      {
        theme: 'sozel',
        name: 'S\\u00f6zel Paketi',
        price: '990',
        total: '11.880',
        users: '1.260',
        img: '../components/images/pricing-sozel.svg',
        alt: 'S\\u00f6zel paket g\\u00f6rseli',
        features: [
          'T\\u00fcrk\\u00e7e ve sosyal alan dersleri ile dil geli\\u015fimi',
          'Paragraf ve yaz\\u0131l\\u0131 haz\\u0131rl\\u0131k i\\u00e7erikleri',
          'Okuma al\\u0131\\u015fkanl\\u0131\\u011f\\u0131 ve kelime \\u00e7al\\u0131\\u015fmalar\\u0131',
          'Veliye d\\u00fczenli geli\\u015fim \\u00f6zeti',
        ],
      },
      {
        theme: 'birebir',
        name: 'Birebir \\u00d6zel Ders Paketi',
        price: '2.290',
        total: '27.480',
        users: '440',
        img: '../components/images/pricing-birebir.svg',
        alt: 'Birebir \\u00f6zel ders paketi g\\u00f6rseli',
        features: [
          'Tek \\u00f6\\u011frenciye \\u00f6zel ders saatleri',
          'Ki\\u015fisel eksik analizi ve \\u00f6dev plan\\u0131',
          'Veli bilgilendirme g\\u00f6r\\u00fc\\u015fmeleri',
          '\\u00d6ncelikli destek',
        ],
      },
    ],
    '6': [
      {
        theme: 'tum-dersler',
        name: 'T\\u00fcm Dersler Paketi',
        price: '990',
        total: '11.880',
        users: '1.520',
        img: '../components/images/pricing-tum-dersler.svg',
        alt: 'T\\u00fcm dersler paketi g\\u00f6rseli',
        features: [
          '6. s\\u0131n\\u0131f m\\u00fcfredat\\u0131nda t\\u00fcm dersler',
          'Etkile\\u015fimli canl\\u0131 dersler ve ar\\u015fiv',
          'Veli paneli ve ba\\u015far\\u0131 takibi',
          'Telafi imk\\u00e2n\\u0131',
        ],
      },
      {
        theme: 'sayisal',
        name: 'Say\\u0131sal Paketi',
        price: '890',
        total: '10.680',
        users: '1.180',
        img: '../components/images/pricing-sayisal.svg',
        alt: 'Say\\u0131sal paket g\\u00f6rseli',
        features: [
          'Matematik ve fen i\\u00e7in ek soru ve tekrar setleri',
          'Mini denemeler ve grafiksel ilerleme',
          'Kavram peki\\u015ftirme videolar\\u0131',
          '\\u00d6\\u011fretmen yorumlar\\u0131',
        ],
      },
      {
        theme: 'sozel',
        name: 'S\\u00f6zel Paketi',
        price: '890',
        total: '10.680',
        users: '1.090',
        img: '../components/images/pricing-sozel.svg',
        alt: 'S\\u00f6zel paket g\\u00f6rseli',
        features: [
          'T\\u00fcrk\\u00e7e ve sosyal bilgiler odakl\\u0131 i\\u00e7erik',
          'Okuma ve yazma \\u00e7al\\u0131\\u015fmalar\\u0131',
          'Proje ve \\u00f6dev deste\\u011fi',
          'Geli\\u015fim raporu',
        ],
      },
      {
        theme: 'birebir',
        name: 'Birebir \\u00d6zel Ders Paketi',
        price: '2.090',
        total: '25.080',
        users: '380',
        img: '../components/images/pricing-birebir.svg',
        alt: 'Birebir \\u00f6zel ders paketi g\\u00f6rseli',
        features: [
          'Birebir ders ile ki\\u015fiselle\\u015ftirilmi\\u015f tempo',
          'Eksik konu kapatma ve \\u00f6dev kontrol\\u00fc',
          'Veliye d\\u00fczenli geri bildirim',
          'Esnek saat plan\\u0131',
        ],
      },
    ],
    '5': [
      {
        theme: 'tum-dersler',
        name: 'T\\u00fcm Dersler Paketi',
        price: '890',
        total: '10.680',
        users: '1.340',
        img: '../components/images/pricing-tum-dersler.svg',
        alt: 'T\\u00fcm dersler paketi g\\u00f6rseli',
        features: [
          '5. s\\u0131n\\u0131f i\\u00e7in t\\u00fcm bran\\u015flarda canl\\u0131 ders',
          'Oyunla\\u015ft\\u0131r\\u0131lm\\u0131\\u015f i\\u00e7erik ve \\u00f6d\\u00fcller',
          'Veli paneli ve devams\\u0131zl\\u0131k uyar\\u0131s\\u0131',
          'Kay\\u0131ttan tekrar',
        ],
      },
      {
        theme: 'sayisal',
        name: 'Say\\u0131sal Paketi',
        price: '790',
        total: '9.480',
        users: '990',
        img: '../components/images/pricing-sayisal.svg',
        alt: 'Say\\u0131sal paket g\\u00f6rseli',
        features: [
          'Matematik ve fen i\\u00e7in temel g\\u00fc\\u00e7lendirme',
          'K\\u0131sa testler ve al\\u0131\\u015ft\\u0131rmalar',
          'G\\u00f6rsel materyaller',
          '\\u00d6\\u011fretmen deste\\u011fi',
        ],
      },
      {
        theme: 'sozel',
        name: 'S\\u00f6zel Paketi',
        price: '790',
        total: '9.480',
        users: '940',
        img: '../components/images/pricing-sozel.svg',
        alt: 'S\\u00f6zel paket g\\u00f6rseli',
        features: [
          'T\\u00fcrk\\u00e7e ve sosyal alan i\\u00e7in temel beceriler',
          'Hik\\u00e2ye ve paragraf \\u00e7al\\u0131\\u015fmalar\\u0131',
          'Diksiyon ve okuma saati',
          'Veli \\u00f6zet raporu',
        ],
      },
      {
        theme: 'birebir',
        name: 'Birebir \\u00d6zel Ders Paketi',
        price: '1.990',
        total: '23.880',
        users: '310',
        img: '../components/images/pricing-birebir.svg',
        alt: 'Birebir \\u00f6zel ders paketi g\\u00f6rseli',
        features: [
          'Birebir \\u00f6zel ders ile okula uyum deste\\u011fi',
          '\\u00d6\\u011frenciye \\u00f6zel \\u00f6dev ve takip',
          'Veli g\\u00f6r\\u00fc\\u015fmeleri',
          'Esnek program',
        ],
      },
    ],
  };
})();
`;

const paketDetayJs = `/**
 * Paket detay \\u2014 URL: ?paket=hizlandirma|tum-dersler|sayisal|sozel|birebir &sinif=8|7|6|5
 */
(function () {
  const CATALOG = window.BILENYUM_PRICING_CATALOG;
  if (!CATALOG) return;

  const VALID_THEMES = new Set(['hizlandirma', 'tum-dersler', 'sayisal', 'sozel', 'birebir']);
  const GRADE_LABEL = {
    '8': '8. S\\u0131n\\u0131f (LGS)',
    '7': '7. S\\u0131n\\u0131f',
    '6': '6. S\\u0131n\\u0131f',
    '5': '5. S\\u0131n\\u0131f',
  };
  const THEME_LEAD = {
    hizlandirma:
      'S\\u0131nava yak\\u0131n d\\u00f6nemde yo\\u011fun tekrar, bran\\u015f bazl\\u0131 peki\\u015ftirme ve veli \\u00f6zetleriyle hedefe odaklan\\u0131n.',
    'tum-dersler':
      'M\\u00fcfredat kapsam\\u0131ndaki derslerde canl\\u0131 yay\\u0131n, kay\\u0131t ar\\u015fivi ve \\u015feffaf veli paneli tek pakette.',
    sayisal:
      'Matematik ve fen bilimleri a\\u011f\\u0131rl\\u0131kl\\u0131 i\\u00e7erik, deneme analizi ve net odakl\\u0131 \\u00e7al\\u0131\\u015fma \\u00f6nerileri.',
    sozel:
      'T\\u00fcrk\\u00e7e, ink\\u0131lap, din ve dil derslerinde paragraf, okuma ve yaz\\u0131l\\u0131 haz\\u0131rl\\u0131k i\\u00e7erikleri.',
    birebir:
      'Size \\u00f6zel ders saatleri, birebir \\u00f6\\u011fretmen e\\u015fle\\u015fmesi ve ki\\u015fiselle\\u015ftirilmi\\u015f \\u00f6dev / geli\\u015fim takibi.',
  };

  function escapeHtml(text) {
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/"/g, '&quot;');
  }

  function pricingImgUrl(file) {
    let base =
      typeof window !== 'undefined' && window.__pricingImgBase
        ? String(window.__pricingImgBase).replace(/\\/?$/, '/')
        : '../components/images/';
    const raw = String(file || '').trim();
    if (!raw) return base + 'pricing-tum-dersler.svg';
    if (/^https?:\\/\\//i.test(raw)) return raw;
    const stripped = raw
      .replace(/^\\.\\.\\/components\\/images\\//, '')
      .replace(/^\\/?components\\/images\\//, '')
      .replace(/^assets\\/img\\//, '')
      .replace(/^\\/+/, '');
    return base + stripped;
  }

  const params = new URLSearchParams(window.location.search);
  let theme = params.get('paket') || 'tum-dersler';
  let grade = params.get('sinif') || '8';
  if (!VALID_THEMES.has(theme)) theme = 'tum-dersler';
  if (!CATALOG[grade]) grade = '8';

  let card = (CATALOG[grade] || []).find((c) => c.theme === theme);
  if (!card) {
    theme = 'tum-dersler';
    card = (CATALOG[grade] || []).find((c) => c.theme === theme);
  }
  if (!card) return;

  document.body.classList.remove(
    'paket-detail-theme--hizlandirma',
    'paket-detail-theme--tum-dersler',
    'paket-detail-theme--sayisal',
    'paket-detail-theme--sozel',
    'paket-detail-theme--birebir'
  );
  document.body.classList.add('paket-detail-theme', 'paket-detail-theme--' + theme);

  const gradeEyebrow = GRADE_LABEL[grade] || '8. S\\u0131n\\u0131f (LGS)';
  const leadLine = THEME_LEAD[theme] || THEME_LEAD['tum-dersler'];
  const heroLead = leadLine + ' ' + card.users + ' \\u00f6\\u011frenci bu paketi kullan\\u0131yor.';

  document.title = card.name + ' \\u2014 Bilenyum';

  const setText = (sel, text) => {
    const el = document.querySelector(sel);
    if (el) el.textContent = text;
  };

  setText('[data-pkg="breadcrumb"]', card.name);
  setText('[data-pkg="eyebrow"]', gradeEyebrow);
  setText('[data-pkg="title"]', card.name);
  setText('[data-pkg="lead"]', heroLead);
  setText('[data-pkg="price"]', '\\u20ba ' + card.price);
  setText('[data-pkg="sticky-price-num"]', '\\u20ba ' + card.price);
  setText('[data-pkg="rating-blurb"]', '\\u2605 ' + card.users + ' \\u00f6\\u011frenci \\u00b7 aktif paket');
  setText(
    '[data-pkg="features-lead"]',
    card.name + ' ile ihtiyac\\u0131n\\u0131z olan i\\u00e7erikler tek pakette toplan\\u0131r.'
  );
  setText(
    '[data-pkg="reviews-lead"]',
    'Bu paketi tercih eden ' + card.users + ' ailenin ger\\u00e7ek deneyimi.'
  );
  setText('[data-pkg="purchase-title"]', card.name);
  setText(
    '[data-pkg="purchase-sub"]',
    gradeEyebrow.replace(/\\s*\\(LGS\\)\\s*$/, '') + ' \\u00b7 12 ay s\\u00fcreli \\u00b7 Bilenyum online'
  );
  setText('[data-pkg="purchase-users"]', card.users);
  setText('[data-pkg="sticky-title"]', card.name);
  setText('[data-pkg="sticky-meta"]', gradeEyebrow + ' \\u00b7 12 ay s\\u00fcreli');
  setText('[data-pkg="sticky-total"]', 'Toplam \\u20ba ' + card.total + ' \\u00b7 9 taksit imk\\u00e2n\\u0131');

  const totalStrong = document.querySelector('[data-pkg="total-strong"]');
  if (totalStrong) totalStrong.textContent = '\\u20ba ' + card.total;

  const purchasePrice = document.querySelector('[data-pkg="purchase-price"]');
  if (purchasePrice) purchasePrice.textContent = '\\u20ba ' + card.price;

  const purchaseTotalLine = document.querySelector('[data-pkg="purchase-total-line"]');
  if (purchaseTotalLine) {
    purchaseTotalLine.innerHTML = '12 ay toplam: <strong>\\u20ba ' + escapeHtml(card.total) + '</strong>';
  }

  const highlights = document.querySelector('[data-pkg="highlights"]');
  if (highlights && card.features) {
    highlights.innerHTML = card.features
      .map((f) => '<li><span>' + escapeHtml(f) + '</span></li>')
      .join('');
  }

  const grid = document.getElementById('pkgFeaturesGrid');
  if (grid && card.features) {
    grid.innerHTML = card.features
      .map(
        (f) =>
          '<div class="feature-card">' +
          '<div class="feature-icon">\\u2713</div>' +
          '<p>' +
          escapeHtml(f) +
          '</p>' +
          '</div>'
      )
      .join('');
  }

  const heroImg = document.querySelector('[data-pkg="hero-img"]');
  if (heroImg && card.img) {
    heroImg.src = encodeURI(pricingImgUrl(card.img));
    heroImg.alt = card.alt || card.name;
  }

  const summaryCount = document.querySelector('[data-pkg="reviews-summary-count"]');
  if (summaryCount) summaryCount.textContent = card.users + ' de\\u011ferlendirme';

  const q1 = document.querySelector('[data-pkg="review-quote-1"]');
  if (q1) {
    q1.textContent =
      '"' +
      card.name +
      ' ile hedefimize net \\u015fekilde ilerledik; \\u00f6\\u011fretmenler \\u00e7ok ilgili."';
  }

  const metaDesc = document.querySelector('meta[name="description"]');
  if (metaDesc) {
    metaDesc.setAttribute(
      'content',
      card.name + ': ' + ((card.features && card.features[0]) || 'Bilenyum online e\\u011fitim paketi') + '.'
    );
  }

  const checkoutHref =
    '/odeme-bilgileri?' +
    new URLSearchParams({ paket: theme, sinif: grade }).toString();
  document.querySelectorAll('[data-pkg-checkout]').forEach((el) => {
    el.setAttribute('href', checkoutHref);
  });
})();
`;

fs.writeFileSync(path.join(scriptsDir, 'pricing-catalog.js'), pricingCatalogJs, 'utf8');
fs.writeFileSync(path.join(scriptsDir, 'paket-detay.js'), paketDetayJs, 'utf8');
console.log('Wrote UTF-8:', path.join(scriptsDir, 'pricing-catalog.js'));
console.log('Wrote UTF-8:', path.join(scriptsDir, 'paket-detay.js'));
