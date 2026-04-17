<?php
add_filter( 'woocommerce_cart_is_block_cart', '__return_false', 9999 );

/**
 * Template Name: HOUARA Cart
 * Description: صفحة سلة التسوق — هوارة شوب
 */

defined('ABSPATH') || exit;

// ✅ FIX: Register cart fragment so header count auto-updates via AJAX
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    $count = WC()->cart->get_cart_contents_count();
    $fragments['.houara-cart-count'] = '<span class="houara-cart-count">' . $count . ' منتج</span>';
    return $fragments;
});
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>سلة التسوق — هوارة شوب</title>
  <?php wp_head(); ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --orange: #FF6B00;
      --orange-light: #FF8C00;
      --navy: #1A1A2E;
      --navy-light: #2a2a45;
      --white: #ffffff;
      --gray-bg: #f8f8f8;
      --gray-light: #e8e8e8;
      --gray-text: #666;
      --shadow: 0 4px 20px rgba(0,0,0,0.08);
      --radius: 12px;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { direction: rtl; }
    body {
      font-family: 'Cairo', 'Segoe UI', sans-serif;
      background: var(--gray-bg);
      color: var(--navy);
      min-height: 100vh;
    }

    /* ── HEADER ─────────────────────────────────── */
    .houara-header {
      background: var(--navy);
      padding: 0 20px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 12px rgba(0,0,0,0.3);
    }
    .houara-header-inner {
      max-width: 1100px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 65px;
    }
    .houara-logo {
      font-size: 1.5rem;
      font-weight: 900;
      color: var(--white);
      text-decoration: none;
    }
    .houara-logo span { color: var(--orange); }

    /* Desktop nav */
    .houara-nav {
      display: flex;
      gap: 6px;
      align-items: center;
    }
    .houara-nav a {
      color: rgba(255,255,255,0.85);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 8px;
      transition: all 0.2s;
    }
    .houara-nav a:hover { background: rgba(255,107,0,0.15); color: var(--orange); }
    .houara-nav a.active { background: var(--orange); color: #fff; }

    /* Cart icon with live count */
    .houara-cart-icon {
      background: var(--orange);
      color: #fff;
      padding: 7px 16px;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 700;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }
    .houara-cart-count { font-weight: 900; }

    /* Hamburger */
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      background: none;
      border: none;
      padding: 5px;
    }
    .hamburger span { display: block; width: 22px; height: 3px; background: #fff; border-radius: 3px; }

    /* Mobile nav overlay */
    .mobile-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; }
    .mobile-overlay.open { display: block; }
    .mobile-nav-drawer {
      display: none;
      position: fixed;
      top: 0; right: 0;
      width: 260px; height: 100%;
      background: var(--navy);
      z-index: 9999;
      padding: 20px;
      transform: translateX(100%);
      transition: transform 0.3s;
      overflow-y: auto;
    }
    .mobile-nav-drawer.open { transform: translateX(0); }
    .mobile-nav-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .mobile-nav-logo { color: #fff; font-size: 1.2rem; font-weight: 900; }
    .mobile-nav-logo span { color: var(--orange); }
    .close-drawer { color: #fff; font-size: 22px; cursor: pointer; background: none; border: none; }
    .mobile-nav-drawer a {
      display: block;
      color: #ccc;
      font-size: 15px;
      font-weight: 600;
      padding: 14px 0;
      border-bottom: 1px solid rgba(255,255,255,0.07);
      text-decoration: none;
    }
    .mobile-nav-drawer a:hover { color: var(--orange); }

    /* ── PAGE HERO ───────────────────────────────── */
    .page-hero {
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
      padding: 35px 20px;
      text-align: center;
    }
    .page-hero h1 { color: #fff; font-size: 1.8rem; font-weight: 900; margin-bottom: 6px; }
    .page-hero p { color: rgba(255,255,255,0.7); font-size: 0.9rem; }
    .breadcrumb {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 10px;
      font-size: 0.85rem;
      color: rgba(255,255,255,0.6);
    }
    .breadcrumb a { color: var(--orange); text-decoration: none; }

    /* ── CART CONTAINER ─────────────────────────── */
    .cart-wrapper {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px 60px;
    }
    .empty-cart-box {
      background: #fff;
      border-radius: var(--radius);
      padding: 60px 20px;
      text-align: center;
      box-shadow: var(--shadow);
    }
    .empty-cart-box .icon { font-size: 4rem; margin-bottom: 16px; }
    .empty-cart-box h2 { font-size: 1.4rem; color: var(--navy); margin-bottom: 10px; }
    .empty-cart-box p { color: var(--gray-text); margin-bottom: 28px; }
    .btn-shop {
      display: inline-block;
      background: var(--orange);
      color: #fff;
      padding: 14px 32px;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 700;
      text-decoration: none;
    }
    .btn-shop:hover { background: var(--orange-light); }

    /* ── WOOCOMMERCE CART LAYOUT ─────────────────── */
    #primary .cart-wrapper .woocommerce {
      display: grid !important;
      grid-template-columns: minmax(0, 1fr) 360px !important;
      gap: 28px !important;
      align-items: start !important;
    }
    #primary .cart-wrapper .woocommerce form.woocommerce-cart-form { width: 100% !important; margin: 0 !important; }
    #primary .cart-wrapper .woocommerce .cart-collaterals { width: 100% !important; margin: 0 !important; float: none !important; }

    /* ── CART TABLE ──────────────────────────────── */
    .woocommerce table.shop_table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: var(--shadow);
      border: none;
    }
    .woocommerce table.shop_table thead tr { background: var(--navy); color: #fff; }
    .woocommerce table.shop_table th {
      padding: 14px 16px;
      font-size: 0.9rem;
      font-weight: 700;
      text-align: right;
      border: none;
    }
    .woocommerce table.shop_table td {
      padding: 16px;
      border-bottom: 1px solid var(--gray-light);
      vertical-align: middle;
      text-align: right;
    }
    .woocommerce table.shop_table tbody tr:last-child td { border-bottom: none; }
    .woocommerce table.shop_table .product-thumbnail img {
      width: 70px; height: 70px; object-fit: cover; border-radius: 8px;
    }
    .woocommerce table.shop_table .product-name a {
      color: var(--navy); font-weight: 700; text-decoration: none; font-size: 1rem;
    }
    .woocommerce table.shop_table .product-name a:hover { color: var(--orange); }
    .woocommerce table.shop_table .product-price,
    .woocommerce table.shop_table .product-subtotal { color: var(--orange); font-weight: 700; }
    .woocommerce .quantity input {
      width: 70px; padding: 8px;
      border: 2px solid var(--gray-light); border-radius: 8px;
      text-align: center; font-family: 'Cairo', sans-serif; font-size: 1rem; color: var(--navy);
    }
    .woocommerce .quantity input:focus { border-color: var(--orange); outline: none; }
    .woocommerce table.cart a.remove {
      color: #ccc !important; font-size: 1.4rem; text-decoration: none; transition: color 0.2s;
    }
    .woocommerce table.cart a.remove:hover { color: #e00 !important; }

    /* Actions row */
    .woocommerce table.cart td.actions {
      background: var(--gray-bg);
      border-top: 2px solid var(--gray-light);
      padding: 20px 16px;
    }
    .woocommerce table.cart td.actions .coupon {
      display: flex; flex-wrap: wrap; gap: 10px; float: right; align-items: center;
    }
    .woocommerce table.cart td.actions > .button[name="update_cart"] {
      float: left; background: var(--navy) !important; color: #fff !important; padding: 12px 24px;
    }
    .woocommerce table.cart td.actions::after { content: ""; display: table; clear: both; }
    .woocommerce #coupon_code {
      padding: 10px 14px; border: 2px solid var(--gray-light); border-radius: 8px;
      font-family: 'Cairo', sans-serif; font-size: 0.9rem; color: var(--navy); width: 180px;
    }
    .woocommerce #coupon_code:focus { border-color: var(--orange); outline: none; }
    .woocommerce .button.alt,
    .woocommerce button.button {
      background: var(--orange) !important; color: #fff !important;
      font-family: 'Cairo', sans-serif; font-size: 0.9rem; font-weight: 700;
      padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; transition: background 0.2s;
    }
    .woocommerce .button.alt:hover,
    .woocommerce button.button:hover { background: var(--orange-light) !important; }

    /* ── CART TOTALS ─────────────────────────────── */
    .cart_totals {
      background: #fff;
      border-radius: var(--radius);
      padding: 28px;
      box-shadow: var(--shadow);
      position: sticky;
      top: 85px;
    }
    .cart_totals h2 {
      font-size: 1.2rem; font-weight: 900; color: var(--navy);
      margin-bottom: 20px; padding-bottom: 14px; border-bottom: 2px solid var(--gray-light);
    }
    .woocommerce .cart-totals table { width: 100% !important; border: none !important; }
    .woocommerce .cart-totals table tr {
      display: flex !important; justify-content: space-between !important;
      align-items: center !important; border-bottom: 1px solid var(--gray-light) !important;
      padding: 14px 0 !important;
    }
    .woocommerce .cart-totals table th,
    .woocommerce .cart-totals table td {
      display: block !important; padding: 0 !important; border: none !important; background: transparent !important;
    }
    .woocommerce .cart-totals table .order-total th,
    .woocommerce .cart-totals table .order-total td { font-size: 1.1rem; font-weight: 900; }
    .woocommerce .cart-totals table .order-total .woocommerce-Price-amount { color: var(--orange); font-size: 1.3rem; }

    /* Free delivery badge */
    .free-delivery-badge {
      background: linear-gradient(135deg, #00a86b, #00c67f);
      color: #fff; padding: 10px 14px; border-radius: 8px;
      font-size: 0.85rem; font-weight: 700; text-align: center;
      margin-bottom: 16px; display: flex; align-items: center; justify-content: center; gap: 6px;
    }

    /* Checkout button */
    .woocommerce .wc-proceed-to-checkout { margin-top: 16px; }
    .woocommerce .wc-proceed-to-checkout .checkout-button {
      width: 100% !important;
      background: linear-gradient(135deg, var(--orange), var(--orange-light)) !important;
      color: #fff !important; font-size: 1.1rem !important; font-weight: 900 !important;
      padding: 16px !important; border-radius: 10px !important;
      text-align: center !important; display: block !important;
      text-decoration: none !important; border: none !important; cursor: pointer !important;
      box-shadow: 0 4px 15px rgba(255,107,0,0.4) !important;
      font-family: 'Cairo', sans-serif !important;
    }
    .woocommerce .wc-proceed-to-checkout .checkout-button:hover {
      transform: translateY(-2px) !important;
    }

    /* WhatsApp button */
    .whatsapp-order-btn {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      background: #25D366; color: #fff; padding: 13px 20px; border-radius: 10px;
      font-size: 0.95rem; font-weight: 700; text-decoration: none; margin-top: 10px;
      transition: background 0.2s;
    }
    .whatsapp-order-btn:hover { background: #1ebe5a; }
    .whatsapp-order-btn svg { width: 20px; height: 20px; fill: #fff; }

    /* Trust row */
    .trust-row {
      margin-top: 20px; padding-top: 16px;
      border-top: 1px solid var(--gray-light);
      display: flex; gap: 10px;
    }
    .trust-item { flex: 1; text-align: center; font-size: 0.78rem; color: var(--gray-text); font-weight: 600; }
    .trust-item .icon { font-size: 1.3rem; display: block; margin-bottom: 4px; }

    /* Hide WooCommerce notices */
    .woocommerce-notices-wrapper,
    .woocommerce-message,
    .woocommerce-error,
    .woocommerce-info { display: none !important; }

    /* ── FOOTER ──────────────────────────────────── */
    .houara-footer {
      background: var(--navy); color: rgba(255,255,255,0.7);
      text-align: center; padding: 24px 20px; font-size: 0.85rem;
    }
    .houara-footer a { color: var(--orange); text-decoration: none; }

    /* ── RESPONSIVE ──────────────────────────────── */
    @media (max-width: 900px) {
      #primary .cart-wrapper .woocommerce {
        grid-template-columns: 1fr !important;
      }
      .cart_totals { position: static; }
    }

    @media (max-width: 768px) {
      /* Hide desktop nav, show hamburger */
      .houara-nav { display: none !important; }
      .hamburger { display: flex; }
      .mobile-nav-drawer { display: block; }

      /* Page hero smaller on mobile */
      .page-hero { padding: 25px 15px; }
      .page-hero h1 { font-size: 1.4rem; }

      /* Cart table mobile stacking */
      .woocommerce table.shop_table thead { display: none; }
      .woocommerce table.shop_table tr { display: block; border-bottom: 2px solid var(--gray-light); }
      .woocommerce table.shop_table td {
        display: flex; justify-content: space-between;
        align-items: center; padding: 10px 16px;
        border-bottom: 1px solid var(--gray-light);
      }
      .woocommerce table.shop_table td::before {
        content: attr(data-title);
        font-weight: 700; color: var(--gray-text); font-size: 0.85rem;
      }
      .woocommerce table.shop_table .product-thumbnail { display: none; }

      .cart-wrapper { padding: 0 12px 40px; }
    }

    @media (max-width: 480px) {
      .houara-logo { font-size: 1.2rem; }
    }
  </style>
</head>
<body class="woocommerce-cart">

<!-- MOBILE OVERLAY -->
<div class="mobile-overlay" id="mobileOverlay" onclick="closeDrawer()"></div>

<!-- MOBILE NAV DRAWER -->
<div class="mobile-nav-drawer" id="mobileDrawer">
  <div class="mobile-nav-header">
    <div class="mobile-nav-logo">هوارة <span>شوب</span></div>
    <button class="close-drawer" onclick="closeDrawer()">✕</button>
  </div>
  <a href="<?php echo home_url('/'); ?>">🏠 الرئيسية</a>
  <a href="<?php echo home_url('/matjar/'); ?>">🛍️ المتجر</a>
  <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>">🛒 السلة</a>
  <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">👤 حسابي</a>
</div>

<!-- HEADER -->
<header class="houara-header">
  <div class="houara-header-inner">
    <div style="display:flex;align-items:center;gap:12px;">
      <button class="hamburger" onclick="openDrawer()">
        <span></span><span></span><span></span>
      </button>
      <a href="<?php echo home_url('/'); ?>" class="houara-logo">هوارة <span>شوب</span></a>
    </div>
    <nav class="houara-nav">
      <a href="<?php echo home_url('/'); ?>">الرئيسية</a>
      <a href="<?php echo home_url('/matjar/'); ?>">المتجر</a>
      <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="active">السلة</a>
      <?php if (is_user_logged_in()): ?>
        <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">حسابي</a>
      <?php else: ?>
        <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">تسجيل الدخول</a>
      <?php endif; ?>
    </nav>
    <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="houara-cart-icon">
      🛒 <span class="houara-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?> منتج</span>
    </a>
  </div>
</header>

<!-- PAGE HERO -->
<div class="page-hero">
  <h1>🛒 سلة التسوق</h1>
  <p>راجع طلبك واكمل عملية الشراء</p>
  <div class="breadcrumb">
    <a href="<?php echo home_url('/'); ?>">الرئيسية</a>
    <span>›</span>
    <span>سلة التسوق</span>
  </div>
</div>

<!-- CART CONTENT -->
<div class="cart-wrapper">
  <?php
  if (WC()->cart->is_empty()) {
    echo '<div class="empty-cart-box">
      <div class="icon">🛒</div>
      <h2>سلتك فارغة!</h2>
      <p>أضف بعض المنتجات وابدأ التسوق</p>
      <a href="' . (home_url('/matjar/')) . '" class="btn-shop">🛍️ تصفح المنتجات</a>
    </div>';
  } else {
    add_action('woocommerce_before_cart_totals', function() {
      echo '<div class="free-delivery-badge">🚚 التوصيل مجاني لأولاد تايمة</div>';
    });

    add_action('woocommerce_proceed_to_checkout', function() {
      $phone = '212702048470';
      $msg = urlencode('مرحبا، أريد الطلب عبر واتساب');
      echo '<a href="https://wa.me/' . $phone . '?text=' . $msg . '" target="_blank" class="whatsapp-order-btn">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        اطلب عبر واتساب
      </a>';
    }, 20);

    add_action('woocommerce_after_cart_totals', function() {
      echo '<div class="trust-row">
        <div class="trust-item"><span class="icon">💳</span>الدفع عند الاستلام</div>
        <div class="trust-item"><span class="icon">🔒</span>100% آمن</div>
        <div class="trust-item"><span class="icon">🚚</span>توصيل نفس اليوم</div>
      </div>';
    });

    echo do_shortcode('[woocommerce_cart]');
  }
  ?>
</div>

<!-- FOOTER -->
<footer class="houara-footer">
  <p>© <?php echo date('Y'); ?> هوارة شوب — جميع الحقوق محفوظة | <a href="https://wa.me/212702048470">تواصل معنا</a></p>
</footer>

<script>
// Mobile drawer
function openDrawer() {
  document.getElementById('mobileDrawer').classList.add('open');
  document.getElementById('mobileOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeDrawer() {
  document.getElementById('mobileDrawer').classList.remove('open');
  document.getElementById('mobileOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

// ✅ RELIABLE EMPTY CART DETECTION
// WooCommerce fires wc_fragments_refreshed after EVERY cart update (removal, quantity change etc.)
// We check if product rows are gone from the DOM → reload to show empty state

jQuery(document.body).on('wc_fragments_refreshed removed_from_cart', function() {
    var productRows = jQuery('table.cart tr.cart_item, table.woocommerce-cart-form__contents tr.cart_item');
    if (productRows.length === 0) {
        setTimeout(function() {
            window.location.reload();
        }, 400);
    }
});

// Also watch for WooCommerce AJAX cart updates via MutationObserver
// This catches cases where wc_fragments_refreshed doesn't fire
(function() {
    var cartTable = document.querySelector('form.woocommerce-cart-form, table.cart');
    if (!cartTable) return;
    var observer = new MutationObserver(function() {
        var rows = document.querySelectorAll('tr.cart_item');
        if (rows.length === 0) {
            observer.disconnect();
            setTimeout(function() { window.location.reload(); }, 400);
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
