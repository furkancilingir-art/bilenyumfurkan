import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const partialDir = path.join(__dirname, 'landing-reference');
const mainPath = path.join(__dirname, 'landing-reference.css');

function slugify(s) {
  const map = {
    'ı': 'i',
    'ğ': 'g',
    'ü': 'u',
    'ş': 's',
    'ö': 'o',
    'ç': 'c',
    İ: 'i',
    Ğ: 'g',
    Ü: 'u',
    Ş: 's',
    Ö: 'o',
    Ç: 'c',
  };
  let t = s.split('');
  t = t.map((c) => map[c] ?? c).join('');
  return t
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '')
    .slice(0, 56);
}

/** Önceki hatadan kalan parçaları sırayla birleştir */
function readMergedFromChunks() {
  const files = fs
    .readdirSync(partialDir)
    .filter((f) => f.endsWith('.css'))
    .sort((a, b) => {
      const na = parseInt(a, 10);
      const nb = parseInt(b, 10);
      return na - nb;
    });
  let out = '';
  for (const f of files) {
    out += fs.readFileSync(path.join(partialDir, f), 'utf8');
  }
  return out;
}

function chunkName(trimmed, index) {
  const head = trimmed.replace(/^\s+/, '');
  const m = head.match(/^\/\* -{10,}\s*(.+?)\s*-{10,}\s*\*\//);
  if (m) {
    return `${String(index).padStart(2, '0')}-${slugify(m[1])}.css`;
  }
  if (head.startsWith(':root')) {
    return `${String(index).padStart(2, '0')}-root-tokens-base.css`;
  }
  return `${String(index).padStart(2, '0')}-fragment.css`;
}

const src = readMergedFromChunks();
const parts = src.split(/(?=\n  \/\* -{10,})/);

fs.rmSync(partialDir, { recursive: true, force: true });
fs.mkdirSync(partialDir, { recursive: true });

const imports = [];
let idx = 0;
parts.forEach((chunk) => {
  const trimmed = chunk.trimEnd();
  if (!trimmed.trim()) return;

  const baseName = chunkName(trimmed, idx);
  idx += 1;
  const outPath = path.join(partialDir, baseName);
  fs.writeFileSync(outPath, trimmed.endsWith('\n') ? trimmed : `${trimmed}\n`);
  imports.push(`@import url("./landing-reference/${baseName}");`);
});

const banner = `/* Parçalar landing-reference/ içinde; yeniden bölmek için: node _split-landing-ref.mjs */\n`;
fs.writeFileSync(mainPath, banner + imports.join('\n') + '\n');
console.log('Wrote', imports.length, 'chunks with descriptive names.');
