/**
 * Vercel build: src/components (ve varsa assets) -> public/ altına kopyalanır.
 * Böylece /src/components/... istekleri CDN'den sunulabilir.
 */
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { cpSync, mkdirSync, existsSync } from 'node:fs';

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

const assetsSrc = path.join(root, 'assets');
const assetsDest = path.join(root, 'public', 'assets');
if (existsSync(assetsSrc)) {
  mkdirSync(path.join(root, 'public'), { recursive: true });
  cpSync(assetsSrc, assetsDest, { recursive: true });
  console.log('vercel-build: assets -> public/assets');
}
