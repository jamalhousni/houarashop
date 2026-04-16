# CLAUDE.md — HOUARA-SHOP Project Context

> This file gives Claude Code full context about the HOUARA-SHOP project.
> Read this at the start of every session before doing anything.
> Last updated: Apr 14 2026

---

## 🧑 About the Developer

- **Name:** Jamal Al-Housni
- **Location:** Ouled Teima / Taroudant, Morocco
- **Day job:** Alternative Punishments Office, Local Prison, Taroudant
- **Learning:** Java (Udemy course, Pomodoro — 7-9am and 9-11pm daily)
- **OS:** Ubuntu (primary), Windows (dual-boot, graphic design only)
- **Tools:** Notion, Claude Desktop, IntelliJ IDEA, Antigravity IDE

---

## 🛒 Project: HOUARA-SHOP

### Mission
Hyperlocal e-commerce for Ouled Teima / Houara region.
Core promise: order before 4:00 PM → delivered same day until 11:00 PM.
Long-term vision: become the Marjan/Carrefour of Houara — a trusted local brand.

### Domain & Hosting
| Item | Detail |
|---|---|
| Domain | houarashop.com |
| Registrar | Namecheap — purchased Apr 6 2026 — Order #199059860 |
| Hosting | Hostinger Business Plan — $59.88/yr |
| WordPress Admin | houarashop.com/wp-admin |
| Admin Email | houarashop.store@gmail.com |
| Admin Password | Houara@2026* |
| Theme | Astra (installed) |
| E-commerce | WooCommerce (installed) |
| Server | UK datacenter (Hostinger) |
| DNS | Propagated and LIVE |
| Site Status | LIVE at houarashop.com |

### Accounts & Credentials
| Service | Login | Password | Notes |
|---|---|---|---|
| Gmail (project) | houarashop.store@gmail.com | — | 2FA ON |
| Namecheap | jamalhousni2@gmail.com | 010973097@ | Enable 2FA! |
| WordPress Admin | houarashop.store@gmail.com | Houara@2026* | Updated Apr 7 |
| Hostinger Panel | jamalhousni2@gmail.com | 010203Houara | hpanel.hostinger.com |

---

## 👥 Team

| Role | Person | Hours |
|---|---|---|
| Project lead + evening delivery | Jamal | 17:00 – 23:00 |
| Delivery (available all day) | Nourdin (friend) | All day |
| Website + legal (RC) | Cousin | Part-time |

---

## 📦 Business Model

- **Phase 1:** Ouled Teima / Houara
- **Phase 2:** Agadir (agadir-shop.com) — early 2027
- **Payment:** Cash on Delivery (COD)
- **Order cutoff:** 4:00 PM → delivered same day until 11:00 PM
- **Delivery radius:** Ouled Teima city only at start
- **Sources Phase 1:** Derb Omar ONLY — no Alibaba yet
- **Sources Phase 2+:** Alibaba for proven winners only

### First 3 Products to Test (June 2026)
1. Magnetic Phone Holder (Car) — 15-25 MAD buy / 50-70 MAD sell
2. Fast Charging Cable (Type-C/iPhone) — 10-20 MAD buy / 40-60 MAD sell
3. Vegetable Cutter/Slicer — 30-50 MAD buy / 80-120 MAD sell

---

## 💰 Budget: 20,000–25,000 MAD

| Category | Amount | Status |
|---|---|---|
| Domain + Hosting | ~1,200 MAD | ✅ SPENT |
| Initial Stock (3 products) | 7,000-9,000 MAD | June/July 2026 |
| Packaging + Branding | 1,000 MAD | July 2026 |
| Facebook Ads testing | 20 MAD/day June | June |
| Facebook Ads launch | 3,000-4,000 MAD | Aug-Sep |
| Emergency Reserve | 8,000+ MAD | PROTECTED |

---

## 🗓️ Roadmap

| Month | Goals | Status |
|---|---|---|
| April 2026 | Domain + hosting + WordPress + DNS | ✅ DONE |
| May 2026 | Finish all pages, add first products | 🔄 IN PROGRESS |
| June 2026 | START TESTING — 3 products, 20 MAD/day ads | Pending |
| July 2026 | Identify winners, order more stock | Pending |
| August 2026 | Scale winners, expand to 10 products | Pending |
| September 2026 | Full public launch | Pending |
| Early 2027 | agadir-shop.com | Pending |
| 2027+ | Custom Java Spring Boot platform | Pending |

---

## 📄 Custom Page Templates

All templates live in: `public_html/wp-content/themes/astra/`
Local copies in: `/home/jamal-housni/antigravity/`

| File | Template Name | Status |
|---|---|---|
| houarashop-home.php | HOUARA-SHOP Homepage | ✅ LIVE |
| houarashop-myaccount.php | HOUARA-SHOP My Account | ✅ LIVE |
| houarashop-cart.php | HOUARA Cart | ✅ LIVE + fixed |
| houarashop-checkout.php | HOUARA Checkout | ✅ LIVE + fixed |
| houarashop-shop.php | HOUARA Shop | ✅ exists |
| houarashop-contact.php | HOUARA Contact | ✅ exists |
| single-product.php | Single Product | ✅ exists |
| houarashop-woo-style.css | Global WooCommerce CSS | ✅ in Additional CSS |

## 🔌 Plugin
| Plugin | Location | Status |
|---|---|---|
| houarashop-fixes | public_html/wp-content/plugins/houarashop-fixes/ | ✅ ACTIVE |

This plugin registers `.houara-cart-count` as a WooCommerce AJAX fragment so the cart counter auto-updates when items are removed.

---

## 🎨 Design System

- Deep Orange #FF6B00 — buttons, CTA
- White #FFFFFF — background
- Dark Navy #1A1A2E — header, footer
- Light Gray #F5F5F5 — section backgrounds
- Green #27AE60 — delivery badge, WhatsApp

Font: Cairo (Google Fonts) — Arabic + Latin, RTL

---

## ✅ What's Working (Apr 14 2026)

- ✅ Homepage — LIVE with countdown, hero, products, WhatsApp, mobile menu
- ✅ My Account — styled, customer registration enabled
- ✅ Cart page — mobile hamburger menu, cart counter AJAX auto-update
- ✅ Checkout page — classic checkout (not block), COD highlighted, duplicate removed
- ✅ WooCommerce Block Checkout → replaced with classic shortcode
- ✅ WooCommerce notifications hidden (CSS)
- ✅ houarashop-fixes plugin active (cart fragment)
- ✅ Global CSS (houarashop-woo-style.css) in Additional CSS

## ⚠️ TODO Next Session

- [ ] Style the Shop page (صفحة المتجر) — assign houarashop-shop.php template
- [ ] Style the Contact page — assign houarashop-contact.php template
- [ ] Style Single Product pages — upload single-product.php
- [ ] Add first 3 products in WooCommerce with photos
- [ ] Test complete purchase flow (add to cart → checkout → place order)
- [ ] Add logo image to header
- [ ] Mobile test all pages

---

## 🔗 Key Links

- **Live site:** https://houarashop.com
- **WordPress Admin:** https://houarashop.com/wp-admin
- **Hostinger Panel:** https://hpanel.hostinger.com
- **File Manager path:** public_html/wp-content/themes/astra/
- **Plugin path:** public_html/wp-content/plugins/houarashop-fixes/
- **Notion HQ:** https://www.notion.so/33a153206cd0815daacbe4ecdb661380
- **This file:** /home/jamal-housni/codewithclaude/houarashop/CLAUDE.md
