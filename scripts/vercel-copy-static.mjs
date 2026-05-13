/**
 * Vercel build: src/components (ve varsa assets) -> public/ altına kopyalanır.
 * Böylece /src/components/... istekleri CDN'den sunulabilir.
 */
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { cpSync, mkdirSync, existsSync, readFileSync, writeFileSync } from 'node:fs';

const here = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(here, '..');

const componentsSrc = path.join(root, 'src', 'components');
const componentsDest = path.join(root, 'public', 'src', 'components');
if (existsSync(componentsSrc)) {
  mkdirSync(path.dirname(componentsDest), { recursive: true });
  cpSync(componentsSrc, componentsDest, { recursive: true });
  console.log('vercel-build: src/components -> public/src/components');
} else {
  console.warn('vercel-build: src/components bulunamadı, atlanıyor.');
}

const assetsDest = path.join(root, 'public', 'assets');
let assetsSrc = path.join(root, 'assets');
if (!existsSync(assetsSrc)) {
  const assetsAlt = path.join(root, 'Assets');
  if (existsSync(assetsAlt)) {
    assetsSrc = assetsAlt;
  }
}
if (existsSync(assetsSrc)) {
  mkdirSync(path.join(root, 'public'), { recursive: true });
  cpSync(assetsSrc, assetsDest, { recursive: true });
  console.log('vercel-build: assets -> public/assets');
}

/** Paket detay HTML: Vercel yalnızca public/ sunar; göreli ../components kırılır — kök mutlak yollara çevrilir. */
const paketSrc = path.join(root, 'src', 'pages', 'paket-detay.html');
const paketDest = path.join(root, 'public', 'paket-detay.html');
if (existsSync(paketSrc)) {
  let html = readFileSync(paketSrc, 'utf8');
  const pairs = [
    ['href="../components/', 'href="/src/components/'],
    ["href='../components/", "href='/src/components/"],
    ['src="../components/', 'src="/src/components/'],
    ["src='../components/", "src='/src/components/"],
    ['srcset="../components/', 'srcset="/src/components/'],
    ["srcset='../components/", "srcset='/src/components/"],
    ['href="../../assets/', 'href="/assets/'],
    ["href='../../assets/", "href='/assets/"],
    ['src="../../assets/', 'src="/assets/'],
    ["src='../../assets/", "src='/assets/"],
    ['href="./index.html"', 'href="/"'],
    ["href='./index.html'", "href='/'"],
    ['href="index.html#', 'href="/#'],
    ["href='index.html#", "href='/#"],
    ['odeme-bilgileri.php', '/odeme-bilgileri'],
    ['bize-ulasin.php', '/bize-ulasin'],
    ['ornek-videolar.php', '/ornek-videolar'],
    ['../components/images/', '/src/components/images/'],
  ];
  for (const [from, to] of pairs) {
    html = html.split(from).join(to);
  }
  mkdirSync(path.dirname(paketDest), { recursive: true });
  writeFileSync(paketDest, html, 'utf8');
  console.log('vercel-build: src/pages/paket-detay.html -> public/paket-detay.html (kök yollar)');
}
