<?php
/**
 * The Template for displaying all single products
 * Overrides the default Astra/WooCommerce single product template
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هوارة-شوب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Cairo',sans-serif; direction:rtl; background:#fff; color:#333; }
        a { text-decoration:none; color:inherit; }
        .countdown-bar { background:#FF6B00; padding:10px 20px; text-align:center; position:relative; z-index:1001; }
        .countdown-bar p { color:#fff; font-size:18px; margin: 0; line-height: 1.2; font-weight:700; }
        #timer { color:#FFE000; font-weight:900; direction:ltr; display:inline-block; }
        .site-header { background:#1A1A2E; padding:15px 40px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1000; box-shadow:0 4px 20px rgba(0,0,0,0.1); }
        .header-nav { display:flex; gap:20px; align-items:center; }
        .header-nav a { color:#ccc; font-size:15px; font-weight:600; transition:color 0.2s; }
        .header-nav a:hover { color:#FF6B00; }
        .header-left { display:flex; align-items:center; gap:15px; }
        .header-cart { background:#FF6B00; color:#fff; padding:8px 20px; border-radius:25px; font-weight:700; font-size:15px; }
        .hs-hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; background:none; border:none; padding:5px; }
        .hs-hamburger span { display:block; width:25px; height:3px; background:#fff; border-radius:3px; }
        .hs-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9998; }
        .hs-overlay.open { display:block; }
        .hs-mobile-nav { display:none; position:fixed; top:0; right:0; width:280px; height:100%; background:#1A1A2E; z-index:9999; padding:20px; box-shadow:-5px 0 20px rgba(0,0,0,0.3); transform:translateX(100%); transition:transform 0.3s; overflow-y:auto; }
        .hs-mobile-nav.open { transform:translateX(0); }
        .mobile-nav-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; padding-bottom:15px; border-bottom:1px solid rgba(255,255,255,0.1); }
        .close-nav { color:#fff; font-size:24px; cursor:pointer; background:none; border:none; }
        .hs-mobile-nav a { display:block; color:#ccc; font-size:16px; font-weight:600; padding:15px 0; border-bottom:1px solid rgba(255,255,255,0.07); }
        .hs-mobile-nav a:hover { color:#FF6B00; }
        .mobile-nav-cart { margin-top:20px; background:#FF6B00 !important; color:#fff !important; padding:14px 20px !important; border-radius:8px; text-align:center; font-weight:700 !important; border:none !important; }
        .whatsapp-section { background:#25D366; padding:20px 40px; text-align:center; }
        .whatsapp-section h2 { color:#fff; font-size:20px; font-weight:900; margin-bottom:6px; }
        .whatsapp-section p { color:rgba(255,255,255,0.85); font-size:14px; margin-bottom:16px; }
        .btn-wa-big { background:#fff; color:#25D366; padding:12px 32px; border-radius:8px; font-size:15px; font-weight:900; display:inline-flex; align-items:center; gap:10px; font-family:'Cairo',sans-serif; transition:all 0.3s; }
        .btn-wa-big:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,0.15); }
        .site-footer { background:#111122; padding:40px; text-align:center; }
        .footer-logo { margin-bottom:12px; }
        .footer-tagline { color:#aab4c8; font-size:14px; margin-bottom:20px; }
        /* Related products */
        .hs-related { max-width:1200px; margin:30px auto 60px; padding:0 20px; }
        .hs-related-title { font-size:1.5rem; font-weight:900; color:#1A1A2E; text-align:center; margin-bottom:8px; }
        .hs-related-sub { text-align:center; color:#777; font-size:0.95rem; margin-bottom:28px; }
        .hs-related-grid { display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:18px; }
        .hs-related-card { background:#fff; border:1px solid #eee; border-radius:14px; overflow:hidden; transition:all 0.2s; display:flex; flex-direction:column; }
        .hs-related-card:hover { transform:translateY(-4px); box-shadow:0 8px 24px rgba(0,0,0,0.08); border-color:#FF6B00; }
        .hs-related-card a { color:inherit; text-decoration:none; display:flex; flex-direction:column; height:100%; }
        .hs-related-img { width:100%; aspect-ratio:1/1; background:#f6f6f9; overflow:hidden; display:flex; align-items:center; justify-content:center; }
        .hs-related-img img { width:100%; height:100%; object-fit:cover; display:block; }
        .hs-related-info { padding:14px; flex:1; display:flex; flex-direction:column; }
        .hs-related-name { font-size:0.95rem; font-weight:700; color:#1A1A2E; line-height:1.4; margin-bottom:8px; min-height:2.6em; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .hs-related-price { color:#FF6B00; font-weight:900; font-size:1.1rem; margin-top:auto; }
        .hs-related-price del { color:#aaa; font-weight:400; font-size:0.85rem; margin-left:6px; }
        .hs-related-btn { display:block; background:#FF6B00; color:#fff; text-align:center; padding:10px; font-weight:700; font-size:0.85rem; border-top:1px solid rgba(0,0,0,0.05); }
        .hs-related-btn:hover { background:#FF8C00; color:#fff; }
        @media (max-width:900px) { .hs-related-grid { grid-template-columns:repeat(2, minmax(0, 1fr)); } }
        @media (max-width:420px) { .hs-related-grid { grid-template-columns:1fr 1fr; gap:12px; } .hs-related-info { padding:10px; } .hs-related-name { font-size:0.85rem; } }
        .footer-links { display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin-bottom:20px; }
        .footer-links a { color:#aab4c8; font-size:14px; }
        .footer-links a:hover { color:#FF6B00; }
        .footer-copy { color:#555; font-size:13px; }
        @media (max-width:768px) { .site-header { padding:12px 20px; } .header-nav { display:none; } .hs-hamburger { display:flex; } .hs-mobile-nav { display:block; } .whatsapp-section { padding:15px 20px; } .site-footer { padding:30px 20px; } }

/* WooCommerce + product styles */
.woocommerce, .woocommerce-page, .woocommerce *, .woocommerce-page * { font-family:'Cairo','Segoe UI',sans-serif !important; direction:rtl; }
.woocommerce div.product .product_title { font-size:1.8rem !important; font-weight:900 !important; color:#1A1A2E !important; line-height:1.3 !important; }
.woocommerce div.product p.price, .woocommerce div.product span.price { color:#FF6B00 !important; font-size:1.6rem !important; font-weight:900 !important; }
.woocommerce div.product p.price del { color:#aaa !important; font-size:1.1rem !important; font-weight:400 !important; }
.woocommerce div.product form.cart .single_add_to_cart_button, .woocommerce button.button.alt, .woocommerce input.button.alt { background:#FF6B00 !important; color:#fff !important; font-family:'Cairo',sans-serif !important; font-size:1rem !important; font-weight:700 !important; padding:14px 28px !important; border-radius:10px !important; border:none !important; cursor:pointer !important; transition:background 0.2s,transform 0.1s !important; }
.woocommerce div.product form.cart .single_add_to_cart_button:hover { background:#FF8C00 !important; transform:translateY(-1px) !important; }
.woocommerce div.product form.cart .quantity input.qty { border:2px solid #e8e8e8 !important; border-radius:8px !important; font-family:'Cairo',sans-serif !important; text-align:center !important; font-size:1rem !important; font-weight:700 !important; color:#1A1A2E !important; padding:10px !important; }
.woocommerce .star-rating span::before { color:#FF6B00 !important; }
.woocommerce-message { display:none !important; }
.product-single-wrapper { max-width:1200px; margin:40px auto 80px; padding:0 20px; overflow-x: hidden; width: 100%; }
.woocommerce div.product { background:#fff; border-radius:16px; padding:30px; box-shadow:0 4px 20px rgba(0,0,0,0.05); }
@media (max-width:768px) { .woocommerce div.product { padding:15px; } }

/* Quick action buttons */
.hs-quick-actions { display:flex; gap:10px; margin-top:15px; flex-wrap:wrap; }
.hs-buy-now-btn { flex:1; min-width:180px; background:linear-gradient(135deg,#FF6B00,#FF8C00) !important; color:#fff !important; font-family:'Cairo',sans-serif !important; font-size:1rem !important; font-weight:800 !important; padding:14px 24px !important; border-radius:10px !important; text-align:center !important; text-decoration:none !important; display:inline-block !important; box-shadow:0 4px 12px rgba(255,107,0,0.3) !important; }
.hs-buy-now-btn:hover { transform:translateY(-2px); color:#fff !important; }
.hs-whatsapp-btn { flex:1; min-width:180px; background:#25D366 !important; color:#fff !important; font-family:'Cairo',sans-serif !important; font-size:1rem !important; font-weight:800 !important; padding:14px 24px !important; border-radius:10px !important; text-align:center !important; text-decoration:none !important; display:inline-block !important; }
.hs-whatsapp-btn:hover { transform:translateY(-2px); background:#1ebe5a !important; color:#fff !important; }
@media (max-width:600px) { .hs-quick-actions { flex-direction:column; } .hs-buy-now-btn, .hs-whatsapp-btn { width:100%; min-width:100%; } }

/* Sticky mobile buy bar */
.sticky-mobile-buy { display:none; position:fixed; bottom:0; left:0; width:100%; background:#fff; padding:12px 15px; box-shadow:0 -4px 20px rgba(0,0,0,0.1); z-index:9999; gap:12px; border-top:1px solid #f0f0f0; }
.btn-sticky-cart { flex:2; background:#FF6B00; color:#fff; border:none; padding:14px; border-radius:8px; font-size:16px; font-weight:800; font-family:'Cairo',sans-serif; cursor:pointer; }
.btn-sticky-wa { flex:1; background:#25D366; color:#fff; border:none; padding:14px; border-radius:8px; font-size:16px; font-weight:800; font-family:'Cairo',sans-serif; text-align:center; text-decoration:none; }
@media (max-width:768px) { .sticky-mobile-buy { display:flex; } body { padding-bottom:80px !important; } }
    </style>
</head>
<body <?php body_class(); ?> style="overflow-x: hidden; width: 100%; max-width: 100vw;">
<div class="hs-overlay" id="hsOverlay" onclick="closeHSDrawer()"></div>

<!-- MOBILE NAV -->
<nav class="hs-mobile-nav" id="hsMobileNav">
    <div class="mobile-nav-header">
        <div>
            <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
                <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img site-logo-img--mobile">
            </a>
        </div>
        <button class="close-nav" onclick="closeHSDrawer()">✕</button>
    </div>
    <a href="<?php echo home_url('/'); ?>">🏠 الرئيسية</a>
    <a href="<?php echo home_url('/matjar/'); ?>">🛍️ المتجر</a>
    <a href="<?php echo home_url('/contact/'); ?>">📞 تواصل معنا</a>
    <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">👤 حسابي</a>
    <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="mobile-nav-cart">🛒 السلة</a>
</nav>

<!-- COUNTDOWN BAR -->
<div class="countdown-bar">
    <p>
        <span id="promo-text-today" style="display:none;">🚚 اطلب قبل 04:00 مساءاً ليصلك طلبك اليوم &nbsp;&nbsp; ⏱️ الوقت المتبقي: <span id="timer"></span></span>
        <span id="promo-text-tomorrow" style="display:none;">🚀 اطلب الآن لضمان توصيل طلبك خلال 24 ساعة</span>
    </p>
</div>

<!-- HEADER -->
<header class="site-header">
    <div class="header-left">
        <button class="hs-hamburger" onclick="openHSDrawer()"><span></span><span></span><span></span></button>
        <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
            <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img">
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

<?php
add_action('woocommerce_after_add_to_cart_button', function() {
    global $product;
    if (!$product || !$product->is_purchasable()) return;
    $product_id = $product->get_id();
    $product_name = $product->get_name();
    $product_price = $product->get_price();
    $product_url = $product->get_permalink();
    $wa_message = urlencode("مرحبا، أود طلب هذا المنتج:\n\n📦 " . $product_name . "\n💰 السعر: " . $product_price . " درهم\n🔗 " . $product_url);
    $wa_url = 'https://wa.me/212702048470?text=' . $wa_message;
    $buy_now_url = wc_get_checkout_url() . '?add-to-cart=' . $product_id;
    echo '<div class="hs-quick-actions">';
    echo '<a href="' . esc_url($buy_now_url) . '" class="hs-buy-now-btn">⚡ اشتري الآن</a>';
    echo '<a href="' . esc_url($wa_url) . '" class="hs-whatsapp-btn" target="_blank">💬 اطلب عبر واتساب</a>';
    echo '</div>';
});
?>

<div class="product-single-wrapper">
    <?php while (have_posts()) : the_post(); ?>
        <?php wc_get_template_part('content', 'single-product'); ?>
    <?php endwhile; ?>
</div>

<?php
// ── منتجات قد تعجبك — Related products (4 random, excluding current) ──
$current_product_id = get_queried_object_id();
$related_args = array(
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'post__not_in'   => array( $current_product_id ),
    'orderby'        => 'rand',
    'meta_query'     => array(
        array(
            'key'     => '_stock_status',
            'value'   => 'instock',
            'compare' => '=',
        ),
    ),
);
$related_query = new WP_Query( $related_args );
if ( $related_query->have_posts() ) : ?>
<section class="hs-related">
    <h2 class="hs-related-title">🛍️ منتجات قد تعجبك</h2>
    <p class="hs-related-sub">اختيارات أخرى من متجرنا قد تناسبك</p>
    <div class="hs-related-grid">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post();
            $rp = wc_get_product( get_the_ID() );
            if ( ! $rp ) continue;
        ?>
        <div class="hs-related-card">
            <a href="<?php the_permalink(); ?>">
                <div class="hs-related-img">
                    <?php if ( has_post_thumbnail() ) :
                        the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) );
                    else : ?>
                        <span style="font-size:3rem;">📦</span>
                    <?php endif; ?>
                </div>
                <div class="hs-related-info">
                    <div class="hs-related-name"><?php the_title(); ?></div>
                    <div class="hs-related-price"><?php echo $rp->get_price_html(); ?></div>
                </div>
                <span class="hs-related-btn">عرض المنتج ←</span>
            </a>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</section>
<?php endif; ?>

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
        if (isPastCutoff) { txtToday.style.display='none'; txtTomorrow.style.display='inline'; }
        else { txtToday.style.display='inline'; txtTomorrow.style.display='none'; }
    }
    var diff = cutoff - now;
    var h = Math.floor(diff / 3600000), m = Math.floor((diff % 3600000) / 60000);
    var timerEl = document.getElementById('timer');
    if (timerEl) timerEl.innerHTML = h + ' h ' + m + ' m';
}
updateTimer(); setInterval(updateTimer, 60000);
function openHSDrawer() { document.getElementById('hsMobileNav').classList.add('open'); document.getElementById('hsOverlay').classList.add('open'); document.body.style.overflow='hidden'; }
function closeHSDrawer() { document.getElementById('hsMobileNav').classList.remove('open'); document.getElementById('hsOverlay').classList.remove('open'); document.body.style.overflow=''; }
</script>
<?php wp_footer(); ?>

<div class="sticky-mobile-buy">
    <button class="btn-sticky-cart" onclick="document.querySelector('.single_add_to_cart_button').click(); return false;">إضافة إلى السلة</button>
    <a href="<?php
        global $product;
        $product_name = $product ? $product->get_name() : '';
        $product_price = $product ? $product->get_price() : '';
        $product_url = $product ? $product->get_permalink() : '';
        $wa_message = urlencode("مرحبا، أود طلب هذا المنتج:\n\n📦 " . $product_name . "\n💰 السعر: " . $product_price . " درهم\n🔗 " . $product_url);
        echo 'https://wa.me/212702048470?text=' . $wa_message;
    ?>" class="btn-sticky-wa" target="_blank">💬 واتساب</a>
</div>

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
</body>
</html>
