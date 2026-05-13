/**
 * Vercel build: CDN üzerinden /src/components/... yollarıyla sunulması için
 * src/components (ve varsa assets) -> public/ altına kopyalanır.
 * Rewrites tüm istekleri PHP'ye verse bile, Vercel önce public'teki dosyayı sunar.
 */
import { cpSync, mkdirSync, existsSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join(dirname(fileURLToPath(import.meta.url))), '..');

const componentsSrc = join(root, 'src', 'components');
const componentsDest = join(root, 'public', 'src', 'components');
if (existsSync(componentsSrc)) {
  mkdirSync(dirname(componentsDest), { recursive: true });
  cpSync(componentsSrc, componentsDest, { recursive: true });
  console.log('vercel-build: src/components -> public/src/components');
} else {
  console.warn('vercel-build: src/components bulunamadı, atlanıyor.');
}

const assetsSrc = join(root, 'assets');
const assetsDest = join(root, 'public', 'assets');
if (existsSync(assetsSrc)) {
  mkdirSync(join(root, 'public'), { recursive: true });
  cpSync(assetsSrc, assetsDest, { recursive: true });
  console.log('vercel-build: assets -> public/assets');
}
