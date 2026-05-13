# Pricing cards layout - developer notes (landing packages)

This note explains why installment blocks looked inconsistent across themes and how it was fixed. Stack references: **PHP** templates, **HTML** skeleton, **CSS** (`landing-reference.css`), **jQuery-ready JS** (`landing-reference.js`). CMS teams should keep the same DOM shape when mirroring content.

---

## 1. Symptom

On some cards (e.g. wider amounts such as `1.290`), the block under features stacked vertically and looked **centered**, unlike the orange **LGS Hizlandirma** card where monthly price stays **left** and total + installment stay **right**, stacked.

---

## 2. Root cause

- `.price-row` used **`flex-wrap: wrap`**.
- With narrow cards (`min-width: 260px` etc.), **monthly amount + right meta** did not fit one flex line, so the meta column **wrapped below**. After wrapping, layout looked like a centered column block.
- This was **not** theme-specific CSS; all themes share the same markup (`price-card--*` only changes colors).

---

## 3. Fix (implemented)

**File:** `public/assets/css/landing-reference.css`

| Before | After |
|--------|--------|
| `display: flex` + `flex-wrap: wrap` | `display: grid` + `grid-template-columns: minmax(0, 1fr) auto` |

- Left: `.price-amount` with `min-width: 0` (allows shrinking).
- Right: `.price-meta` with `justify-self: end` (keeps total + installment aligned to the right).
- Font sizes use **`clamp(...)`** so large numbers still fit without breaking the row.

Bootstrap grid is **not** used inside the card body for this row; layout is custom CSS. You may wrap the section in Bootstrap elsewhere; just preserve `.price-row` children.

---

## 4. Data flow

| Piece | Location |
|-------|----------|
| Copy / numbers | `public/assets/js/pricing-catalog.js` -> `window.BILENYUM_PRICING_CATALOG` |
| Card HTML | `public/assets/js/landing-reference.js` -> `renderPricingCards()` |
| Empty mount point | `app/views/partials/main-content.php` -> `#pricingGrid` filled by JS on load |

---

## 5. CMS / PHP HTML reference (must match classes)

```html
<div class="price-card price-card--tum-dersler">
  <div class="price-card-image">
    <img src="..." alt="..." width="800" height="320" loading="lazy" decoding="async" />
  </div>
  <div class="price-card-body">
    <h3 class="title">Package title</h3>
    <ul class="price-features"><li>...</li></ul>
    <div class="price-row">
      <div class="price-amount">
        <span class="num">&#8378; 1.290</span><span class="per">/ ay</span>
      </div>
      <div class="price-meta">
        <span>Toplam <strong>&#8378; 15.480</strong></span>
        <span class="price-installment">9 taksit imkan&#305;</span>
      </div>
    </div>
    <div class="price-users">...</div>
    <div class="price-actions">...</div>
  </div>
</div>
```

Use theme modifier classes: `price-card--hizlandirma`, `price-card--tum-dersler`, `price-card--sayisal`, `price-card--sozel`, `price-card--birebir`.

Theme overrides for `.price-installment` color live under `.sec-pricing .price-card--*`.

---

## 6. QA checklist

- [ ] Every grade tab (8 / 7 / 6 / 5): price row is **one horizontal band**: amount left, meta right.
- [ ] Longest prices still readable without overlapping.
- [ ] ~280px card width still acceptable.

---

## 7. Related files

- `public/assets/css/landing-reference.css` - `.price-row`, `.price-meta`, `.sec-pricing`
- `public/assets/js/landing-reference.js` - `renderPricingCards`
- `public/assets/js/pricing-catalog.js` - catalog source data
