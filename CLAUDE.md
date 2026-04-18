# CLAUDE.md — HOUARA-SHOP Project Context

> This file gives Claude full context about the HOUARA-SHOP project.
> Read this at the start of every session before doing anything.
> Last updated: Apr 18 2026

---

## 🧑 About the Developer

- **Name:** Jamal Al-Housni
- **Location:** Ouled Teima / Taroudant, Morocco
- **Day job:** Alternative Punishments Office, Local Prison, Taroudant
- **Learning:** Java (Udemy course, Pomodoro — 7-9am and 9-11pm daily)
- **OS:** Ubuntu (primary), Windows (dual-boot, graphic design only)
- **Tools:** Notion, Claude Desktop, IntelliJ IDEA

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
| Registrar | Namecheap |
| Hosting | Hostinger Business Plan |
| WordPress Admin | houarashop.com/wp-admin |
| Admin Email | houarashop.store@gmail.com |
| Admin Password | Houara@2026* |
| Theme | Astra (parent) + astra-child (custom) |
| E-commerce | WooCommerce |
| Server | UK datacenter (Hostinger) |
| Site Status | LIVE |

### Accounts & Credentials
| Service | Login | Notes |
|---|---|---|
| Gmail (project) | houarashop.store@gmail.com | 2FA ON |
| Namecheap | jamalhousni2@gmail.com | |
| WordPress Admin | houarashop.store@gmail.com | |
| Hostinger Panel | jamalhousni2@gmail.com | hpanel.hostinger.com |

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
- **Payment:** Cash on Delivery (COD) only
- **Order cutoff:** 4:00 PM → delivered same day until 11:00 PM
- **Delivery:** Outsourced local delivery team in Ouled Teima
- **Sources Phase 1:** Derb Omar ONLY — no Alibaba yet

### First 3 Products (Live)
1. **Magnetic Phone Holder** → houarashop.com/product/magnetic-phone-holder/ — 46 MAD
2. **Fast Charging Cable** → houarashop.com/product/fast-charging-cable/ — 39 MAD
3. **Vegetable Slicer** → houarashop.com/product/vegetable-slicer/ — 79 MAD

---

## 💰 Budget: 20,000–25,000 MAD

| Category | Amount | Status |
|---|---|---|
| Domain + Hosting | ~1,200 MAD | ✅ SPENT |
| Initial Stock (3 products) | 7,000-9,000 MAD | June/July 2026 |
| Packaging + Branding | 1,000 MAD | July 2026 |
| Facebook Ads testing | 20 MAD/day | June 2026 |
| Facebook Ads launch | 3,000-4,000 MAD | Aug-Sep 2026 |
| Emergency Reserve | 8,000+ MAD | PROTECTED |

---

## 🗓️ Roadmap

| Month | Goals | Status |
|---|---|---|
| April 2026 | Domain + hosting + WordPress + all pages + products | ✅ DONE |
| May 2026 | Final polish + stock ready | 🔄 IN PROGRESS |
| June 2026 | START TESTING — 3 products, 20 MAD/day ads | Pending |
| July 2026 | Identify winners, order more stock | Pending |
| August 2026 | Scale winners, expand to 10 products | Pending |
| September 2026 | Full public launch | Pending |
| Early 2027 | agadir-shop.com | Pending |
| 2027+ | Custom Java Spring Boot platform | Pending |

---

## 📄 File Structure

### Local Project Root
```
/home/jamal-housni/Houarashop-project/
├── astra-child/
│   ├── functions.php          ← ALL custom PHP logic lives here
│   └── style.css
├── houarashop-home.php        ← Homepage template
├── houarashop-shop.php        ← Shop/matjar template
├── houarashop-checkout.php    ← Checkout template
├── houarashop-cart.php        ← Cart template
├── houarashop-contact.php     ← Contact template
├── houarashop-myaccount.php   ← My account template
├── single-product.php         ← Single product template
├── houarashop-tg-notifier/    ← Telegram plugin
│   └── houarashop-tg-notifier.php
└── houarashop-wa-notifier/    ← Old CallMeBot plugin (backup, unused)
```

### Server Paths
- Templates → `public_html/wp-content/themes/astra-child/`
- single-product.php → `public_html/wp-content/themes/astra-child/woocommerce/`
- Telegram plugin → `public_html/wp-content/plugins/houarashop-tg-notifier/`
- functions.php → `public_html/wp-content/themes/astra-child/functions.php`

---

## 🎨 Design System

- Deep Orange `#FF6B00` — buttons, CTA, accents
- Navy `#1A1A2E` — header, footer, headings
- Light Gray `#f8f9fa` — section backgrounds
- Green `#25D366` — WhatsApp buttons only
- Font: **Cairo** (Google Fonts) — Arabic + Latin, RTL

---

## ✅ COMPLETED TASKS (Apr 18 2026 Session)

### Functionality
- ✅ Checkout works end-to-end (COD, 3 fields only: name/address/phone)
- ✅ Phone field mandatory with server-side + client-side validation
- ✅ AIOSEO plugin conflict fixed (was causing HTTP 500 on checkout)
- ✅ Cart quantity locked to 1 per product (add-to-cart is idempotent)
- ✅ Cart badge always syncs with real server count
- ✅ "Create account" checkbox removed from checkout
- ✅ Coupon field hidden from checkout
- ✅ "هل لديك قسيمة" field removed

### UX / Design
- ✅ Fake social proof popup removed (home, shop, single-product)
- ✅ Return policy removed from all pages
- ✅ Buy Now ⚡ button on single product page
- ✅ WhatsApp order button on single product (product-specific message)
- ✅ WhatsApp CTA section made compact (padding: 28px instead of 60px)
- ✅ Buy Now + WA button CSS fixed on mobile
- ✅ "Added to cart" green notice hidden everywhere except cart page
- ✅ "عرض السلة" ugly button hidden on shop cards
- ✅ Favicon uploaded
- ✅ Arabic URLs fixed (3 products now have clean Latin slugs)

### SEO & Tracking
- ✅ SEO setup: Rank Math + Google Search Console (done with Antigravity)
- ✅ AIOSEO deleted (was conflicting with Rank Math)
- ✅ Google Analytics 4: `G-BDBDXF3PJX` — LIVE on all pages
- ✅ Facebook Pixel: `1709168983788060` — LIVE on all pages
- ✅ Events tracked: PageView, AddToCart, Purchase
- ✅ Advanced Matching enabled on Facebook Pixel
- ✅ Product descriptions written for all 3 products (Arabic, SEO-friendly)

### Scarcity & Conversion
- ✅ Stock indicators on product cards (✅ متوفر / 🔴 باقي X فقط / ❌ نفذ)
- ✅ Viewer counter: "X شخص يشاهد هذا الآن" on cards + single product

### Notifications
- ✅ Telegram order notifications (bot: @houarashop_orders_bot or similar)
  - Shows: customer name, phone, address, products, total, order time
  - Buttons: 📋 إدارة الطلب | 💬 تواصل مع العميل (WhatsApp)
  - Smart urgency: ⚡ توصيل اليوم (before 4PM) / 🌙 توصيل الغد (after 4PM)
  - Plugin: `houarashop-tg-notifier` (v1.0.1)

### Operations
- ✅ Facebook Business Account created (Houara Shop)
- ✅ Facebook Page created (needed for running ads)
- ✅ WooCommerce order management workflow established

---

## 🔴 REMAINING — High Priority (Before June Launch)

| Task | Notes |
|------|-------|
| **Logo** | No logo image yet — just text in header |
| **#10 Checkout trust badges** | 🔒 "طلبك آمن 100%" section below confirm button |
| **#12 Duplicate header check** | Quick visual audit needed |
| **#15 Cart page consistency** | Menu/header consistency check |
| **#21 Customer testimonials** | After first real orders come in |

---

## 🟢 DEFERRED (Post-Launch)

| Task | When |
|------|------|
| #19 Exit intent popup | After launch, when you have traffic |
| #22 Product variants | When products need size/color options |
| Google Analytics goals setup | After 1 month of data |
| Facebook ad creative design | June 2026 |
| Agadir expansion | Early 2027 |

---

## ⚙️ functions.php — What's Inside

The `astra-child/functions.php` is the central hub. It contains:

1. **Stylesheet enqueue** (parent + child theme)
2. **GA4 script** (loads on every page via wp_head)
3. **Facebook Pixel script** (loads on every page via wp_head)
4. **WooCommerce event tracking** (AddToCart queue → flush, Purchase on thankyou)
5. **One-item-per-product cart lock** (prevents quantity > 1 from add-to-cart)
6. **Cart badge AJAX sync** (real count from server after add-to-cart)
7. **AJAX handler** `houara_cart_count` (returns real count + Arabic text)
8. **WC notice clearing** (clears notices on non-cart pages)
9. **Stock indicator CSS** (.houara-stock-badge styles)
10. **Shop stock badge hook** (woocommerce_after_shop_loop_item_title)
11. **Out-of-stock CSS class** (woocommerce_post_class filter)
12. **Cart badge page-load sync** (PHP-rendered real count on every page)
13. **Viewer counter** (#17 — "X شخص يشاهد هذا الآن" on cards + single product)

---

## 🔌 Active Plugins

| Plugin | Purpose |
|--------|---------|
| WooCommerce | E-commerce engine |
| Rank Math SEO | SEO + sitemap + Search Console |
| houarashop-tg-notifier | Telegram order notifications |
| LiteSpeed Cache | Page caching (Hostinger) |
| Astra (theme) | Parent theme |

**Deleted/Deactivated:**
- AIOSEO — caused PHP 500 errors on checkout (conflicted with Rank Math)

---

## 🔗 Key Links

- **Live site:** https://houarashop.com
- **WordPress Admin:** https://houarashop.com/wp-admin
- **Hostinger Panel:** https://hpanel.hostinger.com
- **Shop page:** https://houarashop.com/matjar/
- **GA4:** https://analytics.google.com
- **Facebook Events Manager:** https://business.facebook.com/events_manager
- **Notion HQ:** https://www.notion.so/33a153206cd0815daacbe4ecdb661380
