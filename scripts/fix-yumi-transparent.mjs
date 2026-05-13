/**
 * Karakter PNG etrafındaki düz siyah / çok koyu arka planı şeffaflaştırır.
 * Koyu kıyafet tonlarına zarar vermemek için yalnızca düşük parlaklık + düşük renk çeşitliliği olan pikseller hedeflenir.
 */
import sharp from 'sharp';
import { readFile, writeFile, copyFile } from 'fs/promises';
import { dirname, join } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = join(__dirname, '..');
const pngPath = join(root, 'src/components/images/yumi-mascot.png');
const bakPath = join(root, 'src/components/images/yumi-mascot.before-fix.png');

async function main() {
  await copyFile(pngPath, bakPath);
  const img = sharp(pngPath).ensureAlpha();
  const { data, info } = await img.raw().toBuffer({ resolveWithObject: true });
  const { width, height, channels } = info;
  if (channels !== 4) throw new Error('RGBA bekleniyordu');

  const out = Buffer.from(data);
  const thrBright = 52;
  const thrSpread = 38;

  for (let i = 0; i < out.length; i += 4) {
    const r = out[i];
    const g = out[i + 1];
    const b = out[i + 2];
    const maxc = Math.max(r, g, b);
    const minc = Math.min(r, g, b);
    const spread = maxc - minc;
    const lum = 0.299 * r + 0.587 * g + 0.114 * b;
    if (lum < thrBright && spread < thrSpread) {
      out[i + 3] = 0;
    }
  }

  const tmpPath = join(root, 'src/components/images/yumi-mascot.fixed.png');
  await sharp(out, { raw: { width, height, channels: 4 } })
    .png({ compressionLevel: 9 })
    .toFile(tmpPath);

  const fs = await import('node:fs/promises');
  await fs.unlink(pngPath);
  await fs.rename(tmpPath, pngPath);

  console.log('OK:', pngPath, '| yedek:', bakPath);
}

main().catch((e) => {
  console.error(e);
  process.exit(1);
});
