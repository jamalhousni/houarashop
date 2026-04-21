<?php
/**
 * Template Name: HOUARA Shop
 * Description: صفحة المتجر المخصصة
 */
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هوارة-شوب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', sans-serif; direction: rtl; background: #fff; color: #333; }
        a { text-decoration: none; color: inherit; }
        .countdown-bar { background: #FF6B00; padding: 10px 20px; text-align: center; position: relative; z-index: 1001; }
        .countdown-bar p { color: #fff; font-size: 18px; margin: 0; line-height: 1.2; font-weight: 700; }
        #timer { color: #FFE000; font-weight: 900; direction: ltr; display: inline-block; }
        .site-header { background: #1A1A2E; padding: 15px 40px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .header-nav { display: flex; gap: 20px; align-items: center; }
        .header-nav a { color: #ccc; font-size: 15px; font-weight: 600; transition: color 0.2s; }
        .header-nav a:hover { color: #FF6B00; }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-cart { background: #FF6B00; color: #fff; padding: 8px 20px; border-radius: 25px; font-weight: 700; font-size: 15px; }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; padding: 5px; }
        .hamburger span { display: block; width: 25px; height: 3px; background: #fff; border-radius: 3px; }
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; }
        .overlay.open { display: block; }
        .mobile-nav { display: none; position: fixed; top: 0; right: 0; width: 280px; height: 100%; background: #1A1A2E; z-index: 9999; padding: 20px; box-shadow: -5px 0 20px rgba(0,0,0,0.3); transform: translateX(100%); transition: transform 0.3s; overflow-y: auto; }
        .mobile-nav.open { transform: translateX(0); }
        .mobile-nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .mobile-nav-logo { color: #fff; font-size: 20px; font-weight: 900; }
        .close-nav { color: #fff; font-size: 24px; cursor: pointer; background: none; border: none; }
        .mobile-nav a { display: block; color: #ccc; font-size: 16px; font-weight: 600; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .mobile-nav a:hover { color: #FF6B00; }
        .mobile-nav-cart { margin-top: 20px; background: #FF6B00 !important; color: #fff !important; padding: 14px 20px !important; border-radius: 8px; text-align: center; font-weight: 700 !important; border: none !important; }
        .section-title { text-align: center; padding: 50px 20px 30px; }
        .section-title h2 { font-size: 30px; font-weight: 900; color: #1A1A2E; margin-bottom: 10px; }
        .section-title h2 span { color: #FF6B00; }
        .section-title p { color: #777; font-size: 16px; }
        .title-line { width: 60px; height: 4px; background: #FF6B00; margin: 12px auto 0; border-radius: 2px; }
        .products-section { padding: 0 40px 60px; max-width: 1200px; margin: 0 auto; }
        .whatsapp-section { background: #25D366; padding: 20px 40px; text-align: center; }
        .whatsapp-section h2 { color: #fff; font-size: 20px; font-weight: 900; margin-bottom: 6px; }
        .whatsapp-section p { color: rgba(255,255,255,0.85); font-size: 14px; margin-bottom: 16px; }
        .btn-wa-big { background: #fff; color: #25D366; padding: 12px 32px; border-radius: 8px; font-size: 15px; font-weight: 900; display: inline-flex; align-items: center; gap: 10px; font-family: 'Cairo', sans-serif; transition: all 0.3s; }
        .btn-wa-big:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .site-footer { background: #111122; padding: 40px; text-align: center; }
        .footer-logo { margin-bottom: 12px; }
        .footer-tagline { color: #aab4c8; font-size: 14px; margin-bottom: 20px; }
        .footer-links { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; }
        .footer-links a { color: #aab4c8; font-size: 14px; }
        .footer-links a:hover { color: #FF6B00; }
        .footer-copy { color: #555; font-size: 13px; }
        .woocommerce-message { display: none !important; }
        /* Hide Astra theme's site-title TEXT — keep only H-bag icon */
        .ast-site-identity .site-title,
        .ast-site-identity .site-description,
        .site-branding .site-title,
        .site-branding .site-description,
        span.site-title, h1.site-title, h2.site-title, p.site-title,
        .ast-site-identity .ast-site-title-wrap,
        #masthead .site-title,
        .main-header-bar .site-title { display: none !important; visibility: hidden !important; }
        /* Force our H-bag logo to always be visible */
        #houara-logo { display: block !important; visibility: visible !important; opacity: 1 !important; height: 44px !important; width: auto !important; max-width: 160px !important; object-fit: contain !important; }
        @media (max-width: 768px) { #houara-logo { height: 36px !important; } }
        /* Hide ALL floating WhatsApp buttons/widgets */
        [class*="whatsapp"]:not(.whatsapp-section):not(.btn-wa-big),
        [class*="WhatsApp"], [id*="whatsapp"], [id*="WhatsApp"],
        [class*="wa-float"], [class*="wa-btn"], [class*="wa-widget"],
        [class*="qlwapp"], [class*="ctc-"], [class*="wabiz"],
        div[style*="position: fixed"][style*="z-index"][style*="bottom"],
        a[href*="wa.me"][style*="position: fixed"],
        .floating-wpp, .wpp-btn { display: none !important; visibility: hidden !important; }
        @media (max-width: 768px) {
            .site-header { padding: 12px 20px; }
            .header-nav { display: none; }
            .hamburger { display: flex; }
            .mobile-nav { display: block; }
            .products-section { padding: 0 15px 40px; }
            .whatsapp-section { padding: 15px 20px; }
            .site-footer { padding: 30px 20px; }
        }
/* --- WOOCOMMERCE SHOP STYLES --- */
.woocommerce, .woocommerce-page, .woocommerce *, .woocommerce-page * { font-family: 'Cairo', 'Segoe UI', sans-serif !important; direction: rtl; }
.woocommerce .woocommerce-result-count { float: right !important; color: #666; font-size: 0.95rem; font-weight: 700; margin: 0 0 20px 0 !important; padding: 10px 0 !important; }
.woocommerce .woocommerce-ordering { float: left !important; margin: 0 0 20px 0 !important; }
.woocommerce .woocommerce-ordering select { border: 2px solid #e8e8e8; border-radius: 8px; padding: 8px 14px; font-family: 'Cairo', sans-serif; font-size: 0.9rem; color: #1A1A2E; cursor: pointer; background: #fff; }
.woocommerce ul.products { display: grid !important; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)) !important; width: 100% !important; clear: both !important; gap: 20px !important; list-style: none !important; padding: 0 !important; margin: 0 !important; }
.woocommerce ul.products li.product { background: #fff !important; border-radius: 14px !important; overflow: hidden !important; box-shadow: 0 4px 16px rgba(0,0,0,0.07) !important; transition: transform 0.25s, box-shadow 0.25s !important; position: relative !important; border: none !important; }
.woocommerce ul.products li.product:hover { transform: translateY(-5px) !important; box-shadow: 0 10px 30px rgba(0,0,0,0.12) !important; }
.woocommerce ul.products li.product a img.wp-post-image,
.woocommerce ul.products li.product a img.attachment-woocommerce_thumbnail,
.woocommerce ul.products li.product a img.woocommerce-placeholder { width: 100% !important; height: 200px !important; object-fit: cover !important; display: block !important; transition: transform 0.3s !important; }
img.emoji, img.wp-smiley, .houara-stock-badge img { width: 1em !important; height: 1em !important; vertical-align: -0.1em !important; display: inline !important; margin: 0 !important; padding: 0 !important; box-shadow: none !important; }
.woocommerce ul.products li.product .woocommerce-loop-product__title { font-size: 1rem !important; font-weight: 700 !important; color: #1A1A2E !important; padding: 14px 16px 6px !important; line-height: 1.4 !important; }
.woocommerce ul.products li.product .price { color: #FF6B00 !important; font-size: 1.05rem !important; font-weight: 900 !important; padding: 0 16px 6px !important; display: block !important; }
.woocommerce ul.products li.product .price del { color: #aaa !important; font-size: 0.85rem !important; font-weight: 400 !important; margin-left: 6px !important; text-decoration: line-through !important; }
.woocommerce ul.products li.product .price ins { text-decoration: none !important; color: #FF6B00 !important; }
.woocommerce .star-rating span::before { color: #FF6B00 !important; }
.woocommerce .star-rating::before { color: #e0e0e0 !important; }
.woocommerce ul.products li.product .onsale { background: #FF6B00 !important; color: #fff !important; border-radius: 6px !important; padding: 4px 10px !important; font-size: 0.8rem !important; font-weight: 700 !important; top: 12px !important; right: 12px !important; left: auto !important; min-height: auto !important; min-width: auto !important; line-height: 1.4 !important; }
.woocommerce ul.products li.product .button.add_to_cart_button, .woocommerce ul.products li.product a.add_to_cart_button { background: #1A1A2E !important; color: #fff !important; font-family: 'Cairo', sans-serif !important; font-size: 0.9rem !important; font-weight: 700 !important; padding: 12px 16px !important; margin: 8px 16px 16px !important; border-radius: 10px !important; border: none !important; cursor: pointer !important; transition: background 0.2s !important; display: block !important; text-align: center !important; text-decoration: none !important; width: calc(100% - 32px) !important; }
.woocommerce ul.products li.product .button.add_to_cart_button:hover, .woocommerce ul.products li.product a.add_to_cart_button:hover { background: #FF6B00 !important; }
.woocommerce ul.products li.product .added_to_cart { display: none !important; }
.woocommerce nav.woocommerce-pagination ul { border: none !important; display: flex !important; gap: 6px !important; justify-content: center !important; padding: 24px 0 !important; }
.woocommerce nav.woocommerce-pagination ul li { border: none !important; }
.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span { background: #fff !important; border: 2px solid #e8e8e8 !important; border-radius: 8px !important; color: #1A1A2E !important; font-family: 'Cairo', sans-serif !important; font-weight: 700 !important; padding: 8px 14px !important; transition: all 0.2s !important; }
.woocommerce nav.woocommerce-pagination ul li a:hover { background: #FF6B00 !important; border-color: #FF6B00 !important; color: #fff !important; }
.woocommerce nav.woocommerce-pagination ul li span.current { background: #FF6B00 !important; border-color: #FF6B00 !important; color: #fff !important; }
@media (max-width: 600px) {
  .woocommerce ul.products { grid-template-columns: repeat(2, 1fr) !important; gap: 12px !important; }
  .woocommerce ul.products li.product a img.wp-post-image,
  .woocommerce ul.products li.product a img.attachment-woocommerce_thumbnail,
  .woocommerce ul.products li.product a img.woocommerce-placeholder { height: 150px !important; }
  .woocommerce ul.products li.product .woocommerce-loop-product__title { font-size: 0.85rem !important; padding: 10px 12px 4px !important; }
  .woocommerce ul.products li.product .button.add_to_cart_button, .woocommerce ul.products li.product a.add_to_cart_button { font-size: 0.8rem !important; padding: 10px 12px !important; margin: 6px 12px 12px !important; width: calc(100% - 24px) !important; }
}

/* --- CATEGORY FILTER PILLS --- */
.hs-filter-pills {
    display: flex; gap: 10px; padding: 14px 40px 22px; max-width: 1200px;
    margin: 0 auto; overflow-x: auto; overflow-y: hidden;
    scrollbar-width: none; -ms-overflow-style: none;
    -webkit-overflow-scrolling: touch;
    direction: rtl;
}
.hs-filter-pills::-webkit-scrollbar { display: none; }
.hs-filter-pill {
    flex-shrink: 0; background: #fff; color: #1A1A2E;
    border: 2px solid #e8e8e8; padding: 10px 20px; border-radius: 50px;
    font-family: 'Cairo', sans-serif; font-weight: 700; font-size: 14px;
    cursor: pointer; transition: all 0.2s; white-space: nowrap; line-height: 1.2;
}
.hs-filter-pill:hover { border-color: #FF6B00; color: #FF6B00; }
.hs-filter-pill.active { background: #FF6B00; color: #fff; border-color: #FF6B00; box-shadow: 0 4px 12px rgba(255,107,0,0.25); }
.hs-filter-pill:focus { outline: 2px solid #FF6B00; outline-offset: 2px; }
.hs-no-products { text-align: center; padding: 50px 20px; color: #777; font-size: 16px; font-weight: 600; grid-column: 1 / -1; }
@media (max-width: 768px) {
    .hs-filter-pills { padding: 10px 15px 18px; gap: 8px; }
    .hs-filter-pill { padding: 8px 16px; font-size: 13px; }
}
    </style>
</head>
<body>
<div class="overlay" id="overlay" onclick="closeMenu()"></div>
<nav class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-header">
        <div class="mobile-nav-logo">
            <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
                <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img site-logo-img--mobile">
            </a>
        </div>
        <button class="close-nav" onclick="closeMenu()">✕</button>
    </div>
    <a href="<?php echo home_url('/'); ?>">🏠 الرئيسية</a>
    <a href="<?php echo home_url('/matjar/'); ?>">🛍️ المتجر</a>
    <a href="<?php echo home_url('/contact/'); ?>">📞 تواصل معنا</a>
    <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">👤 حسابي</a>
    <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="mobile-nav-cart">🛒 السلة</a>
</nav>
<div class="countdown-bar">
    <p>
        <span id="promo-text-today" style="display:none;">🚚 اطلب قبل 04:00 مساءاً ليصلك طلبك اليوم &nbsp;&nbsp; ⏱️ الوقت المتبقي: <span id="timer"></span></span>
        <span id="promo-text-tomorrow" style="display:none;">🚀 اطلب الآن لضمان توصيل طلبك خلال 24 ساعة</span>
    </p>
</div>
<header class="site-header">
    <div class="header-left">
        <button class="hamburger" onclick="openMenu()"><span></span><span></span><span></span></button>
        <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
            <img id="houara-logo" src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="Houara Shop" class="site-logo-img" style="display:block!important;visibility:visible!important;height:44px!important;width:auto!important;">
        </a>
    </div>
    <nav class="header-nav">
        <a href="<?php echo home_url('/'); ?>">الرئيسية</a>
        <a href="<?php echo home_url('/matjar/'); ?>">المتجر</a>
        <a href="<?php echo home_url('/contact/'); ?>">تواصل معنا</a>
        <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">حسابي</a>
    </nav>
    <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="header-cart">
        🛒 (<span class="cart-count-badge"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?></span>)
    </a>
</header>
<div class="section-title" style="margin-top: 40px;">
    <a href="<?php echo home_url('/'); ?>" style="display:inline-block;">
        <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="Houara Shop" style="height:60px;width:auto;display:block!important;">
    </a>
    <p>جميع منتجاتنا المتوفرة للتوصيل الفوري</p>
    <div class="title-line"></div>
</div>

<?php
// Category filter pills — fetched from WooCommerce product_cat taxonomy
$houara_categories = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
));
if ( ! is_wp_error( $houara_categories ) && ! empty( $houara_categories ) ) : ?>
<nav class="hs-filter-pills" role="tablist" aria-label="تصفية حسب الفئة">
    <button type="button" class="hs-filter-pill active" data-category="all" role="tab" aria-selected="true">الكل</button>
    <?php foreach ( $houara_categories as $hs_cat ) : ?>
        <button type="button" class="hs-filter-pill" data-category="<?php echo esc_attr( $hs_cat->slug ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $hs_cat->name ); ?></button>
    <?php endforeach; ?>
</nav>
<?php endif; ?>

<div class="products-section" style="min-height: 50vh;">
    <div class="woocommerce" style="max-width: 1200px; margin: 0 auto; direction: rtl;">
        <?php echo do_shortcode('[products limit="24" columns="4" paginate="true" orderby="date" order="DESC"]'); ?>
    </div>
</div>
<section class="whatsapp-section">
    <h2>💬 تحدث معنا مباشرة!</h2>
    <p>فريقنا متاح كل يوم من 8 صباحاً حتى 11 ليلاً</p>
    <a href="https://wa.me/212702048470?text=مرحبا، أريد الاستفسار عن منتج من هوارة شوب" class="btn-wa-big" target="_blank">💬 ابدأ المحادثة الآن</a>
</section>
<?php houarashop_render_footer(); ?>
<script>
function updateTimer() {
    var now = new Date(), cutoff = new Date(), isPastCutoff = false;
    cutoff.setHours(16, 0, 0, 0);
    if (now >= cutoff) { cutoff.setDate(cutoff.getDate() + 1); isPastCutoff = true; }
    var txtToday = document.getElementById('promo-text-today');
    var txtTomorrow = document.getElementById('promo-text-tomorrow');
    if (txtToday && txtTomorrow) {
        if (isPastCutoff) { txtToday.style.display = 'none'; txtTomorrow.style.display = 'inline'; }
        else { txtToday.style.display = 'inline'; txtTomorrow.style.display = 'none'; }
    }
    var diff = cutoff - now;
    var h = Math.floor(diff / 3600000), m = Math.floor((diff % 3600000) / 60000);
    var timerEl = document.getElementById('timer');
    if (timerEl) timerEl.innerHTML = h + ' h ' + m + ' m';
}
updateTimer(); setInterval(updateTimer, 60000);
function openMenu() { document.getElementById('mobileNav').classList.add('open'); document.getElementById('overlay').classList.add('open'); document.body.style.overflow='hidden'; }
function closeMenu() { document.getElementById('mobileNav').classList.remove('open'); document.getElementById('overlay').classList.remove('open'); document.body.style.overflow=''; }
</script>
<?php wp_footer(); ?>
<script>
/* Force-hide Astra site-title text and ensure H-bag logo is visible */
(function(){
    function fixLogo(){
        // Hide any site-title text Astra injects
        document.querySelectorAll('.site-title, .ast-site-title-wrap, .site-branding .site-title').forEach(function(el){
            el.style.display='none';
            el.style.visibility='hidden';
        });
        // Ensure our logo image is visible
        var logo=document.getElementById('houara-logo');
        if(logo){logo.style.display='block';logo.style.visibility='visible';logo.style.opacity='1';}
    }
    fixLogo();
    document.addEventListener('DOMContentLoaded',fixLogo);
    window.addEventListener('load',fixLogo);
})();
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof jQuery !== 'undefined') {
        var lastScrollY = 0;
        jQuery(document).on('click', '.add_to_cart_button, .single_add_to_cart_button', function() { lastScrollY = window.scrollY; });
        jQuery(document.body).on('added_to_cart', function() {
            jQuery('html, body').stop(true, true);
            window.scrollTo(0, lastScrollY);
            setTimeout(function() { window.scrollTo(0, lastScrollY); }, 50);
            setTimeout(function() { window.scrollTo(0, lastScrollY); }, 300);
        });
    }
});
</script>
<script>
/* ── HOUARA Category Filter — vanilla JS ──
   Filters products in-place by toggling display on li.product cards.
   Uses WooCommerce's existing .product_cat-{slug} classes (post_class).
   Syncs with URL via history.pushState so filters are shareable/bookmarkable. */
(function(){
    function init(){
        var pills = document.querySelectorAll('.hs-filter-pill');
        if (!pills.length) return;
        var container = document.querySelector('.products-section .woocommerce') || document.querySelector('.products-section');
        if (!container) return;

        function getProducts(){ return container.querySelectorAll('ul.products li.product'); }

        function ensureEmptyMsg(){
            var msg = document.getElementById('hs-no-products');
            if (msg) return msg;
            msg = document.createElement('div');
            msg.id = 'hs-no-products';
            msg.className = 'hs-no-products';
            msg.textContent = '🔍 لا توجد منتجات في هذه الفئة حالياً';
            msg.style.display = 'none';
            var list = container.querySelector('ul.products');
            if (list) list.appendChild(msg); else container.appendChild(msg);
            return msg;
        }

        function applyFilter(category){
            category = category || 'all';
            var products = getProducts();
            var visible = 0;
            products.forEach(function(p){
                var match = (category === 'all') || p.classList.contains('product_cat-' + category);
                p.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            pills.forEach(function(pill){
                var isActive = pill.getAttribute('data-category') === category;
                pill.classList.toggle('active', isActive);
                pill.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
            var msg = ensureEmptyMsg();
            msg.style.display = (visible === 0) ? 'block' : 'none';
        }

        function getUrlCategory(){
            try { return new URLSearchParams(window.location.search).get('category') || 'all'; }
            catch(e){ return 'all'; }
        }

        function setUrlCategory(category){
            try {
                var url = new URL(window.location.href);
                if (category === 'all') url.searchParams.delete('category');
                else url.searchParams.set('category', category);
                history.pushState({ houaraCategory: category }, '', url.toString());
            } catch(e){}
        }

        pills.forEach(function(pill){
            pill.addEventListener('click', function(){
                var cat = this.getAttribute('data-category') || 'all';
                applyFilter(cat);
                setUrlCategory(cat);
                // Scroll active pill into view on mobile
                this.scrollIntoView({ behavior:'smooth', block:'nearest', inline:'center' });
            });
        });

        window.addEventListener('popstate', function(){ applyFilter(getUrlCategory()); });

        // Initial filter from URL (deep linking)
        applyFilter(getUrlCategory());
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
</body>
</html>
