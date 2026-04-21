<?php
/**
 * HOUARA-SHOP Child Theme — functions.php
 * ────────────────────────────────────────
 */

defined( 'ABSPATH' ) || exit;

// ═══════════════════════════════════════════════════════════════
// TRACKING IDs + SITE CONSTANTS
// ═══════════════════════════════════════════════════════════════
define( 'HOUARA_GA4_ID',   'G-BDBDXF3PJX' );
define( 'HOUARA_PIXEL_ID', '1709168983788060' );
define( 'HOUARA_LOGO_URL', 'https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png' );
define( 'HOUARA_OG_IMAGE', 'https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png' );

// ═══════════════════════════════════════════════════════════════
// FORCE GLOBAL BROWSER TAB TITLE
// ═══════════════════════════════════════════════════════════════
add_filter( 'pre_get_document_title', function() { return 'هوارة-شوب'; }, 9999 );
add_filter( 'document_title_parts', function( $parts ) { return array( 'title' => 'هوارة-شوب' ); }, 9999 );
add_filter( 'wp_title', function() { return 'هوارة-شوب'; }, 9999 );


// ═══════════════════════════════════════════════════════════════
// DISABLE WORDPRESS EMOJI SCRIPTS
// Prevents ✅ emoji from being converted to <img> tags that
// break product card layouts on mobile (giant green checkmarks)
// ═══════════════════════════════════════════════════════════════
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );


// ═══════════════════════════════════════════════════════════════
// STYLESHEETS
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_enqueue_scripts', 'houarashop_child_enqueue_styles', 20 );
function houarashop_child_enqueue_styles() {
    wp_enqueue_style( 'astra-parent-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme( 'astra' )->get( 'Version' ) );
    wp_enqueue_style( 'houarashop-child-style', get_stylesheet_directory_uri() . '/style.css', array( 'astra-parent-style' ), wp_get_theme()->get( 'Version' ) );
}


// ═══════════════════════════════════════════════════════════════
// OPEN GRAPH + SCHEMA — SEO & Social Preview
// Tells Google, Facebook, WhatsApp what image + info to show
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_head', 'houarashop_og_and_schema', 1 );
function houarashop_og_and_schema() {
    global $post;

    // ── Determine page-specific values ──
    $site_name   = 'هوارة شوب';
    $site_url    = home_url('/');
    $logo_url    = HOUARA_OG_IMAGE;
    $description = 'متجرك المحلي في أولاد تايمة — توصيل في نفس اليوم، دفع عند الاستلام. أفضل المنتجات بأسعار مناسبة.';

    if ( is_singular( 'product' ) && $post ) {
        $product    = wc_get_product( $post->ID );
        $title      = get_the_title() . ' — هوارة شوب';
        $desc       = $product ? wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ) : $description;
        $desc       = $desc ?: $description;
        $url        = get_permalink();
        $thumb_id   = get_post_thumbnail_id( $post->ID );
        $thumb_url  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : $logo_url;
        $og_type    = 'product';
    } elseif ( is_home() || is_front_page() ) {
        $title      = 'هوارة شوب — توصيل في نفس اليوم بأولاد تايمة';
        $desc       = $description;
        $url        = $site_url;
        $thumb_url  = $logo_url;
        $og_type    = 'website';
    } else {
        $title      = ( is_page() && $post ? get_the_title() . ' — ' : '' ) . $site_name;
        $desc       = $description;
        $url        = get_permalink() ?: $site_url;
        $thumb_url  = $logo_url;
        $og_type    = 'website';
    }

    // Trim description to 160 chars for SEO
    $desc = mb_substr( strip_tags( $desc ), 0, 160 );
    ?>


<!-- ── Local Business Schema (JSON-LD) ── -->
<!-- Tells Google this is a real local shop in Ouled Teima -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "هوارة شوب",
  "alternateName": "Houara Shop",
  "url": "https://houarashop.com",
  "logo": "<?php echo esc_url( $logo_url ); ?>",
  "image": "<?php echo esc_url( $logo_url ); ?>",
  "description": "متجر إلكتروني محلي في أولاد تايمة — توصيل في نفس اليوم، دفع عند الاستلام",
  "telephone": "+212702048470",
  "email": "houarashop.store@gmail.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "أولاد تايمة",
    "addressLocality": "أولاد تايمة",
    "addressRegion": "سوس-ماسة",
    "postalCode": "83350",
    "addressCountry": "MA"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 30.3104,
    "longitude": -9.1675
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
      "opens": "08:00",
      "closes": "23:00"
    }
  ],
  "sameAs": [
    "https://wa.me/212702048470"
  ],
  "priceRange": "درهم",
  "currenciesAccepted": "MAD",
  "paymentAccepted": "الدفع عند الاستلام",
  "areaServed": {
    "@type": "City",
    "name": "أولاد تايمة"
  },
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "منتجات هوارة شوب",
    "url": "https://houarashop.com/matjar/"
  }
}
</script>
    <?php
}


// ═══════════════════════════════════════════════════════════════
// GOOGLE ANALYTICS 4
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_head', 'houarashop_ga4_script', 2 );
function houarashop_ga4_script() {
    if ( ! HOUARA_GA4_ID ) return;
    $ga4 = esc_js( HOUARA_GA4_ID );
    ?>
<!-- Google Analytics 4 — HOUARA-SHOP -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga4; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?php echo $ga4; ?>', { 'currency': 'MAD', 'country': 'MA' });
</script>
    <?php
}


// ═══════════════════════════════════════════════════════════════
// FACEBOOK PIXEL
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_head', 'houarashop_pixel_script', 3 );
function houarashop_pixel_script() {
    if ( ! HOUARA_PIXEL_ID ) return;
    $pixel_id = esc_js( HOUARA_PIXEL_ID );
    ?>
<!-- Facebook Pixel — HOUARA-SHOP -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '<?php echo $pixel_id; ?>');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=<?php echo $pixel_id; ?>&ev=PageView&noscript=1"/></noscript>
    <?php
}


// ═══════════════════════════════════════════════════════════════
// WOOCOMMERCE EVENT TRACKING (GA4 + Pixel)
// ═══════════════════════════════════════════════════════════════
add_action( 'woocommerce_add_to_cart', 'houarashop_track_add_to_cart', 10, 6 );
function houarashop_track_add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
    $product = wc_get_product( $product_id );
    if ( ! $product ) return;
    $events   = WC()->session->get( 'houarashop_pending_events', array() );
    $events[] = array( 'type' => 'add_to_cart', 'name' => $product->get_name(), 'price' => (float) $product->get_price(), 'id' => $product_id );
    WC()->session->set( 'houarashop_pending_events', $events );
}

add_action( 'wp_footer', 'houarashop_flush_pending_events', 5 );
function houarashop_flush_pending_events() {
    if ( ! function_exists( 'WC' ) || ! WC()->session ) return;
    $events = WC()->session->get( 'houarashop_pending_events', array() );
    if ( empty( $events ) ) return;
    WC()->session->set( 'houarashop_pending_events', array() );
    ?>
    <script>
    <?php foreach ( $events as $ev ) :
        $name = esc_js( $ev['name'] ); $price = (float) $ev['price']; $id = (int) $ev['id'];
    ?>
    <?php if ( HOUARA_GA4_ID ) : ?>if (typeof gtag !== 'undefined') { gtag('event', 'add_to_cart', { currency: 'MAD', value: <?php echo $price; ?>, items: [{ item_id: '<?php echo $id; ?>', item_name: '<?php echo $name; ?>', price: <?php echo $price; ?>, quantity: 1 }] }); }<?php endif; ?>
    <?php if ( HOUARA_PIXEL_ID ) : ?>if (typeof fbq !== 'undefined') { fbq('track', 'AddToCart', { content_ids: ['<?php echo $id; ?>'], content_name: '<?php echo $name; ?>', value: <?php echo $price; ?>, currency: 'MAD' }); }<?php endif; ?>
    <?php endforeach; ?>
    </script>
    <?php
}

add_action( 'woocommerce_thankyou', 'houarashop_track_purchase', 10, 1 );
function houarashop_track_purchase( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order || $order->get_meta( '_houarashop_tracked' ) ) return;
    $order->update_meta_data( '_houarashop_tracked', '1' );
    $order->save();
    $total = (float) $order->get_total();
    $items = array();
    foreach ( $order->get_items() as $item ) {
        $items[] = array( 'item_id' => $item->get_product_id(), 'item_name' => $item->get_name(), 'price' => (float) $item->get_total(), 'quantity' => $item->get_quantity() );
    }
    $items_json = wp_json_encode( $items );
    ?>
    <script>
    <?php if ( HOUARA_GA4_ID ) : ?>if (typeof gtag !== 'undefined') { gtag('event', 'purchase', { transaction_id: '<?php echo esc_js( $order->get_order_number() ); ?>', value: <?php echo $total; ?>, currency: 'MAD', items: <?php echo $items_json; ?> }); }<?php endif; ?>
    <?php if ( HOUARA_PIXEL_ID ) : ?>if (typeof fbq !== 'undefined') { fbq('track', 'Purchase', { value: <?php echo $total; ?>, currency: 'MAD', content_type: 'product', contents: <?php echo $items_json; ?> }); }<?php endif; ?>
    </script>
    <?php
}


// ═══════════════════════════════════════════════════════════════
// CART BADGE FRAGMENTS SYNC
// ═══════════════════════════════════════════════════════════════
add_filter('woocommerce_add_to_cart_fragments', 'houarashop_native_cart_fragments');
function houarashop_native_cart_fragments($fragments) {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    // We return the exact HTML that replaces the cart span
    $fragments['span.cart-count-badge'] = '<span class="cart-count-badge">' . $count . '</span>';
    return $fragments;
}

// ═══════════════════════════════════════════════════════════════
// FORCE MAX 1 QUANTITY WITHOUT REDIRECT
// ═══════════════════════════════════════════════════════════════
// By removing the existing item before adding, it stays at qty 1 
// and avoids the WooCommerce error that causes single-product redirects.
add_filter( 'woocommerce_add_cart_item_data', 'houarashop_force_qty_one_no_redirect', 10, 3 );
function houarashop_force_qty_one_no_redirect( $cart_item_data, $product_id, $variation_id ) {
    if ( ! WC()->cart ) return $cart_item_data;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if ( $cart_item['product_id'] == $product_id ) {
            WC()->cart->remove_cart_item( $cart_item_key );
        }
    }
    return $cart_item_data;
}

// ═══════════════════════════════════════════════════════════════
// BULLETPROOF CART COUNT SYNC ON PAGE LOAD
// ═══════════════════════════════════════════════════════════════
add_action('wp_ajax_houara_get_cart_count', 'houara_ajax_get_cart_count');
add_action('wp_ajax_nopriv_houara_get_cart_count', 'houara_ajax_get_cart_count');
function houara_ajax_get_cart_count() {
    wp_send_json_success(array('count' => WC()->cart ? WC()->cart->get_cart_contents_count() : 0));
}

add_action('wp_footer', 'houarashop_bulletproof_cart_sync', 999);
function houarashop_bulletproof_cart_sync() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Force fetch true cart count from server bypassing all caches
        $.post("<?php echo admin_url('admin-ajax.php'); ?>", {action: "houara_get_cart_count"}, function(res) {
            if (res && res.success) {
                $('.cart-count-badge').text(res.data.count);
            }
        });
    });
    </script>
    <?php
}


// ═══════════════════════════════════════════════════════════════
// HIDE WC NOTICES EXCEPT ON CART & CHECKOUT
// ═══════════════════════════════════════════════════════════════
add_action( 'template_redirect', 'houarashop_clear_notices_except_cart', 99 );
function houarashop_clear_notices_except_cart() {
    if ( function_exists( 'is_cart' ) && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
        wc_clear_notices();
    }
}

add_action( 'wp_head', 'houarashop_hide_wc_notices_css', 99 );
function houarashop_hide_wc_notices_css() {
    ?>
    <style>
    .single-product .woocommerce-message,
    .single-product .woocommerce-notices-wrapper .woocommerce-message,
    .single-product .woocommerce-notices-wrapper,
    .woocommerce-shop .woocommerce-message,
    .tax-product_cat .woocommerce-message,
    .home .woocommerce-message,
    .page-template-houarashop-home .woocommerce-message { display: none !important; }
    .woocommerce ul.products li.product a.added_to_cart,
    .woocommerce ul.products li.product .added_to_cart,
    .woocommerce-loop-product__link + .added_to_cart,
    a.added_to_cart.wc-forward { display: none !important; }

    /* Header Logo Text Injection */
    .site-header .logo-img-link,
    .houara-header .logo-img-link,
    .header-left .logo-img-link,
    .mobile-nav-logo .logo-img-link,
    #masthead .site-logo-img-wrap {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        text-decoration: none !important;
    }
    
    .site-header .logo-img-link::after,
    .houara-header .logo-img-link::after,
    .header-left .logo-img-link::after,
    .mobile-nav-logo .logo-img-link::after,
    #masthead .site-logo-img-wrap::after {
        content: "هوارة شوب";
        color: #ffffff;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: 0.5px;
        font-family: 'Cairo', sans-serif;
        white-space: nowrap;
    }

    #masthead .site-logo-img-wrap::after {
        color: #1A1A2E; 
    }
    </style>
    <?php
}


// ═══════════════════════════════════════════════════════════════
// CHECKOUT TRUST BADGES — below "تأكيد الطلب" button
// Shows: 🔒 طلبك آمن 100% | 💵 الدفع عند الاستلام | 🚚 توصيل نفس اليوم
// ═══════════════════════════════════════════════════════════════
add_action( 'woocommerce_review_order_after_submit', 'houarashop_checkout_trust_badges', 10 );
function houarashop_checkout_trust_badges() {
    echo '
    <div class="checkout-trust-badges">
        <div class="checkout-trust-badge">
            <span class="badge-icon">🔒</span>
            <span class="badge-title">طلبك آمن 100%</span>
            <span class="badge-sub">بياناتك محمية</span>
        </div>
        <div class="checkout-trust-badge">
            <span class="badge-icon">💵</span>
            <span class="badge-title">الدفع عند الاستلام</span>
            <span class="badge-sub">لا بطاقة مطلوبة</span>
        </div>
        <div class="checkout-trust-badge">
            <span class="badge-icon">🚚</span>
            <span class="badge-title">توصيل نفس اليوم</span>
            <span class="badge-sub">لأولاد تيمة والحوارة</span>
        </div>
    </div>';
}

add_action( 'wp_head', 'houarashop_checkout_trust_badges_css', 10 );
function houarashop_checkout_trust_badges_css() {
    if ( ! is_checkout() ) return;
    ?>
    <style>
    .checkout-trust-badges {
        display: flex !important;
        flex-direction: row !important;
        justify-content: center !important;
        align-items: flex-start !important;
        gap: 0 !important;
        margin: 24px auto 0 auto !important;
        padding: 18px 16px 14px !important;
        border-top: 1px solid #e8e8e8 !important;
        border-radius: 0 0 12px 12px !important;
        background: #f8f9fa !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .checkout-trust-badge {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: flex-start !important;
        flex: 1 !important;
        gap: 6px !important;
        padding: 0 8px !important;
        border-left: 1px solid #e0e0e0 !important;
    }
    .checkout-trust-badge:last-child {
        border-left: none !important;
    }
    .checkout-trust-badge .badge-icon {
        font-size: 1.8rem !important;
        line-height: 1 !important;
        display: block !important;
    }
    .checkout-trust-badge .badge-title {
        font-size: 0.82rem !important;
        font-weight: 800 !important;
        color: #1A1A2E !important;
        line-height: 1.3 !important;
        text-align: center !important;
        display: block !important;
    }
    .checkout-trust-badge .badge-sub {
        font-size: 0.72rem !important;
        color: #777 !important;
        line-height: 1.4 !important;
        text-align: center !important;
        display: block !important;
    }
    </style>
    <?php
}


// ═══════════════════════════════════════════════════════════════
// STOCK INDICATORS ON SHOP PAGE
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_head', 'houarashop_stock_indicator_css', 10 );
function houarashop_stock_indicator_css() {
    ?>
    <style>
    .houara-stock-badge { display:inline-flex; align-items:center; gap:5px; font-family:'Cairo',sans-serif !important; font-size:0.78rem !important; font-weight:700 !important; padding:4px 10px !important; border-radius:20px !important; margin:0 16px 8px !important; width:fit-content; }
    .houara-stock-badge.in-stock  { background:#e8f5e9; color:#2e7d32; }
    .houara-stock-badge.low-stock { background:#fff3e0; color:#e65100; animation:houara-pulse 2s ease-in-out infinite; }
    .houara-stock-badge.out-stock { background:#f5f5f5; color:#9e9e9e; }
    @keyframes houara-pulse { 0%,100%{opacity:1} 50%{opacity:0.65} }
    .woocommerce ul.products li.product.houara-out-of-stock a img { filter:grayscale(40%); opacity:0.8; }
    .woocommerce ul.products li.product.houara-out-of-stock .button { background:#e0e0e0 !important; color:#9e9e9e !important; cursor:not-allowed !important; pointer-events:none !important; }
    .woocommerce ul.products li.product .outofstock-badge, .woocommerce ul.products li.product .ast-shop-product-out-of-stock { display: none !important; }
    </style>
    <?php
}

add_action( 'woocommerce_after_shop_loop_item_title', 'houarashop_shop_stock_badge', 5 );
function houarashop_shop_stock_badge() {
    global $product;
    if ( ! $product ) return;
    $stock = $product->get_stock_quantity();
    $manage_stock = $product->get_manage_stock();
    $in_stock = $product->is_in_stock();
    if ( ! $in_stock ) {
        echo '<span class="houara-stock-badge out-stock">❌ نفذ المخزون</span>';
    } elseif ( $manage_stock && $stock !== null && $stock <= 5 ) {
        echo '<span class="houara-stock-badge low-stock">🔴 باقي ' . (int) $stock . ' فقط — اطلب الآن!</span>';
    } elseif ( $manage_stock && $stock !== null && $stock <= 10 ) {
        echo '<span class="houara-stock-badge low-stock">⚠️ باقي ' . (int) $stock . ' قطع</span>';
    } else {
        echo '<span class="houara-stock-badge in-stock">✅ متوفر — توصيل اليوم</span>';
    }
}

add_filter( 'woocommerce_post_class', 'houarashop_out_of_stock_class', 10, 2 );
function houarashop_out_of_stock_class( $classes, $product ) {
    if ( $product && is_a( $product, 'WC_Product' ) && ! $product->is_in_stock() ) {
        $classes[] = 'houara-out-of-stock';
    }
    return $classes;
}


// ═══════════════════════════════════════════════════════════════
// SYNC BADGE ON PAGE LOAD
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_footer', 'houarashop_sync_badge_on_load', 10 );
function houarashop_sync_badge_on_load() {
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) return;
    $real_count = WC()->cart->get_cart_contents_count();
    $real_text  = $real_count . ' منتج';
    ?>
    <script>
    (function() {
        var realCount = <?php echo (int) $real_count; ?>;
        var realText  = '<?php echo esc_js( $real_text ); ?>';
        function syncBadge() {
            document.querySelectorAll('.houara-cart-count').forEach(function(el) { el.textContent = realText; });
            document.querySelectorAll('.cart-count-badge').forEach(function(el) { el.textContent = realCount; });
        }
        syncBadge();
        if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', syncBadge); }
    })();
    </script>
    <?php
}

// ═══════════════════════════════════════════════════════════════
// VIEWER COUNTER — "X شخص يشاهد هذا المنتج الآن"
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_footer', 'houarashop_viewer_counter', 20 );
function houarashop_viewer_counter() {
    ?>
    <style>
    .houara-viewers { display:flex; align-items:center; gap:5px; font-family:'Cairo',sans-serif; font-size:0.75rem; font-weight:700; color:#e65100; margin:0 16px 6px; direction:rtl; }
    .houara-viewers .viewer-dot { width:7px; height:7px; background:#e65100; border-radius:50%; animation:viewer-blink 1.4s ease-in-out infinite; flex-shrink:0; }
    @keyframes viewer-blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.3;transform:scale(0.7)} }
    .single-product .houara-viewers-single { display:inline-flex; align-items:center; gap:8px; background:#fff3e0; border:1px solid #ffcc80; border-radius:8px; padding:8px 14px; font-family:'Cairo',sans-serif; font-size:0.9rem; font-weight:700; color:#e65100; direction:rtl; margin-bottom:12px; }
    .houara-viewers-single .viewer-dot { width:9px; height:9px; background:#e65100; border-radius:50%; animation:viewer-blink 1.4s ease-in-out infinite; }
    </style>
    <script>
    (function() {
        function seededRandom(seed) { var x = Math.sin(seed + 1) * 10000; return x - Math.floor(x); }
        function getViewerCount(productId) {
            var now = new Date();
            var day = now.getFullYear() * 10000 + (now.getMonth() + 1) * 100 + now.getDate();
            var hour = Math.floor(now.getHours() / 2);
            var seed = productId * 1000 + day + hour * 7;
            var base = Math.floor(seededRandom(seed) * 15) + 3;
            var h = now.getHours();
            if (h >= 9 && h <= 16) { base += Math.floor(seededRandom(seed + 99) * 5) + 2; }
            return base;
        }
        function injectCardCounters() {
            var cartButtons = document.querySelectorAll('.add_to_cart_button[data-product_id]');
            cartButtons.forEach(function(btn) {
                var productId = parseInt(btn.getAttribute('data-product_id'));
                if (!productId) return;
                var card = btn.closest('.product-card, li.product');
                if (!card || card.querySelector('.houara-viewers')) return;
                var count = getViewerCount(productId);
                var badge = document.createElement('div');
                badge.className = 'houara-viewers';
                badge.innerHTML = '<span class="viewer-dot"></span>' + count + ' شخص يشاهد هذا الآن';
                var price = card.querySelector('.price, .product-price-row');
                var actions = card.querySelector('.product-actions');
                if (price && price.parentNode) { price.parentNode.insertBefore(badge, price.nextSibling); }
                else if (actions) { actions.parentNode.insertBefore(badge, actions); }
                else { card.appendChild(badge); }
            });
        }
        function injectSingleProductCounter() {
            var productForm = document.querySelector('form.cart');
            if (!productForm || document.querySelector('.houara-viewers-single')) return;
            var addBtn = productForm.querySelector('[name="add-to-cart"]');
            var productId = addBtn ? parseInt(addBtn.value) : 0;
            if (!productId) {
                var match = document.body.className.match(/postid-(\d+)/);
                if (match) productId = parseInt(match[1]);
            }
            if (!productId) return;
            var count = getViewerCount(productId);
            var badge = document.createElement('div');
            badge.className = 'houara-viewers-single';
            badge.innerHTML = '<span class="viewer-dot"></span> ' + count + ' شخص يشاهد هذا المنتج الآن';
            productForm.parentNode.insertBefore(badge, productForm);
        }
        function init() { injectCardCounters(); injectSingleProductCounter(); }
        if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); }
        else { init(); }
        if (typeof jQuery !== 'undefined') { jQuery(document).on('updated_wc_div', init); }
    })();
    </script>
    <?php
}

// Force My Account page to use houarashop-myaccount.php template
add_filter('template_include', function($template) {
    global $post;
    if (is_account_page() || (is_page() && isset($post) && strpos($post->post_name, 'my-account') !== false)) {
        $new_template = locate_template(array('houarashop-myaccount.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }
    return $template;
}, 999);

// ═══════════════════════════════════════════════════════════════
// CLEAN UP WOOCOMMERCE ADDRESS FIELDS (MY ACCOUNT)
// ═══════════════════════════════════════════════════════════════
add_filter( 'woocommerce_default_address_fields', 'houarashop_simplify_address_fields', 9999 );
function houarashop_simplify_address_fields( $fields ) {
    // Hide unnecessary fields safely without unsetting them
    $hidden_fields = array('company', 'country', 'address_2', 'state', 'postcode', 'last_name');
    foreach ($hidden_fields as $field) {
        if (isset($fields[$field])) {
            $fields[$field]['required'] = false;
            $fields[$field]['class'] = array('hidden', 'houara-hidden-field');
        }
    }

    // Rename first_name to Full Name and make it full width
    if ( isset( $fields['first_name'] ) ) {
        $fields['first_name']['label'] = 'الاسم الكامل'; // Full Name
        $fields['first_name']['class'] = array('form-row-wide');
    }
    
    // Ensure remaining fields are full width
    if ( isset( $fields['address_1'] ) ) {
        $fields['address_1']['class'] = array('form-row-wide');
    }
    if ( isset( $fields['city'] ) ) {
        $fields['city']['class'] = array('form-row-wide');
    }
    
    return $fields;
}

add_filter( 'woocommerce_billing_fields', 'houarashop_simplify_billing_fields', 9999 );
function houarashop_simplify_billing_fields( $fields ) {
    if ( isset( $fields['billing_phone'] ) ) {
        $fields['billing_phone']['class'] = array('form-row-wide');
        $fields['billing_phone']['required'] = true; // Makes it required and removes (اختياري)
    }
    if ( isset( $fields['billing_email'] ) ) {
        $fields['billing_email']['class'] = array('form-row-wide');
    }
    return $fields;
}

// Hide State/Region from My Account address display
add_filter( 'woocommerce_my_account_my_address_formatted_address', 'houarashop_hide_state_in_my_account', 10, 3 );
function houarashop_hide_state_in_my_account( $address, $customer_id, $name ) {
    $address['state'] = '';
    return $address;
}


// ═══════════════════════════════════════════════════════════════
// HIDE REVIEWS TAB ON SINGLE PRODUCT PAGES
// Removes the "Reviews (0)" tab — empty reviews hurt conversion
// until we have real customer reviews to display.
// ═══════════════════════════════════════════════════════════════
add_filter( 'woocommerce_product_tabs', 'houarashop_remove_reviews_tab', 98 );
function houarashop_remove_reviews_tab( $tabs ) {
    if ( isset( $tabs['reviews'] ) ) {
        unset( $tabs['reviews'] );
    }
    return $tabs;
}

// Also disable review support entirely so "(0)" count doesn't appear anywhere
add_action( 'init', 'houarashop_disable_product_reviews', 20 );
function houarashop_disable_product_reviews() {
    remove_post_type_support( 'product', 'comments' );
}


// ═══════════════════════════════════════════════════════════════
// HIDE SKU ("رمز المنتج") FROM SINGLE PRODUCT PAGE
// We don't need SKU shown to customers — it's internal-only.
// This removes the entire "رمز المنتج: XX" line from the product
// meta block while keeping "التصنيف" (categories) visible.
// ═══════════════════════════════════════════════════════════════
add_filter( 'wc_product_sku_enabled', '__return_false' );


// ═══════════════════════════════════════════════════════════════
// SHARED 4-COLUMN FOOTER — used on every custom template
// Call from a template with the function name (open a PHP tag, then
// call houarashop_render_footer() and close the tag).
// CSS is injected only once per request (static guard).
// ═══════════════════════════════════════════════════════════════
function houarashop_render_footer() {
    static $css_printed = false;
    if ( ! $css_printed ) :
        $css_printed = true;
        ?>
<style>
.houara-main-footer { background:#0f0f1e; color:rgba(255,255,255,0.75); padding:50px 20px 0; font-family:'Cairo','Segoe UI',sans-serif; font-size:0.9rem; direction:rtl; margin-top:0; }
.houara-main-footer * { box-sizing:border-box; }
.houara-mf-inner { max-width:1200px; margin:0 auto; display:grid; grid-template-columns:1.5fr 1fr 1fr 1.3fr; gap:40px; }
.houara-mf-col h4 { color:#fff; font-size:1rem; font-weight:800; margin:0 0 18px 0; position:relative; padding-bottom:10px; }
.houara-mf-col h4::after { content:""; position:absolute; bottom:0; right:0; width:36px; height:3px; background:#FF6B00; border-radius:2px; }
.houara-mf-col ul { list-style:none; padding:0; margin:0; }
.houara-mf-col li { margin-bottom:10px; font-size:0.88rem; line-height:1.55; color:rgba(255,255,255,0.72); }
.houara-mf-col a { color:rgba(255,255,255,0.72); text-decoration:none; transition:color 0.2s; }
.houara-mf-col a:hover { color:#FF6B00; }
.houara-mf-about p { line-height:1.7; margin:0 0 16px 0; color:rgba(255,255,255,0.68); font-size:0.9rem; }
.houara-mf-logo { height:42px !important; width:auto !important; max-width:200px !important; margin-bottom:14px; filter:brightness(0) invert(1); opacity:0.95; display:inline-block; }
.houara-main-footer img { max-width:200px !important; height:auto !important; }
.houara-main-footer .houara-mf-logo { height:42px !important; width:auto !important; }
.houara-mf-socials { display:flex; gap:10px; margin-top:4px; }
.houara-mf-socials a { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:50%; background:rgba(255,255,255,0.08); transition:all 0.2s; }
.houara-mf-socials a svg { width:18px; height:18px; fill:#fff; }
.houara-mf-socials a.wa:hover { background:#25D366; }
.houara-mf-socials a.fb:hover { background:#1877F2; }
.houara-mf-contact .btn-wa { display:flex; align-items:center; justify-content:center; gap:8px; background:#25D366; color:#fff !important; padding:11px 14px; border-radius:8px; font-weight:800; font-size:0.88rem; margin-bottom:12px; direction:ltr; }
.houara-mf-contact .btn-wa:hover { background:#1ebe5a; color:#fff !important; }
.houara-mf-contact .line { display:flex; align-items:center; gap:8px; margin-bottom:8px; font-size:0.85rem; color:rgba(255,255,255,0.72); }
.houara-mf-contact .line .ltr { direction:ltr; display:inline-block; }
.houara-mf-bottom { max-width:1200px; margin:36px auto 0; padding:18px 0; border-top:1px solid rgba(255,255,255,0.08); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; font-size:0.82rem; color:rgba(255,255,255,0.55); }
.houara-mf-badges { display:flex; gap:14px; flex-wrap:wrap; }
.houara-mf-badges span { display:inline-flex; align-items:center; gap:5px; }
@media (max-width:900px) { .houara-mf-inner { grid-template-columns:1fr 1fr; gap:30px; } }
@media (max-width:600px) {
  .houara-main-footer { padding:36px 16px 0; }
  .houara-mf-inner { grid-template-columns:1fr; gap:28px; }
  .houara-mf-bottom { flex-direction:column; text-align:center; padding:16px 0; }
  .houara-mf-badges { justify-content:center; }
}
</style>
        <?php
    endif;
    $logo_url = defined('HOUARA_LOGO_URL') ? HOUARA_LOGO_URL : '';
    ?>
<footer class="houara-main-footer">
  <div class="houara-mf-inner">
    <div class="houara-mf-col houara-mf-about">
      <a href="<?php echo esc_url( home_url('/') ); ?>">
        <img src="<?php echo esc_url( $logo_url ); ?>" alt="هوارة شوب" class="houara-mf-logo">
      </a>
      <p>متجرك المحلي في قلب أولاد تايمة. نوصلك منتجاتك في نفس يوم الطلب، ولا تدفع إلا عند الاستلام.</p>
      <div class="houara-mf-socials">
        <a href="https://wa.me/212702048470" target="_blank" rel="noopener" class="wa" aria-label="واتساب"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg></a>
        <a href="https://www.facebook.com/profile.php?id=61567547245913" target="_blank" rel="noopener" class="fb" aria-label="فيسبوك"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
      </div>
    </div>
    <div class="houara-mf-col">
      <h4>روابط سريعة</h4>
      <ul>
        <li><a href="<?php echo esc_url( home_url('/') ); ?>">الرئيسية</a></li>
        <li><a href="<?php echo esc_url( home_url('/matjar/') ); ?>">المتجر</a></li>
        <li><a href="<?php echo esc_url( home_url('/about-us/') ); ?>">من نحن</a></li>
        <li><a href="<?php echo esc_url( home_url('/contact/') ); ?>">تواصل معنا</a></li>
        <li><a href="<?php echo esc_url( home_url('/privacy-policy/') ); ?>">سياسة الخصوصية</a></li>
        <li><a href="<?php echo esc_url( home_url('/terms/') ); ?>">الشروط والأحكام</a></li>
        <li><a href="<?php echo esc_url( home_url('/return-policy/') ); ?>">سياسة الإرجاع</a></li>
      </ul>
    </div>
    <div class="houara-mf-col">
      <h4>خدمة العملاء</h4>
      <ul>
        <li>🚚 التوصيل: نفس اليوم</li>
        <li>💵 الدفع عند الاستلام</li>
        <li>📍 التغطية: أولاد تايمة والضواحي</li>
        <li>🕐 متاحون: 8 ص – 11 م</li>
      </ul>
    </div>
    <div class="houara-mf-col houara-mf-contact">
      <h4>تواصل مباشر</h4>
      <a href="https://wa.me/212702048470" target="_blank" rel="noopener" class="btn-wa">💬 واتساب <span>+212 702 04 84 70</span></a>
      <div class="line">📞 <a href="tel:+212702048470"><span class="ltr">+212 702 04 84 70</span></a></div>
      <div class="line">✉️ <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></div>
      <div class="line">📍 أولاد تايمة، المغرب</div>
    </div>
  </div>
  <div class="houara-mf-bottom">
    <span>© <?php echo date('Y'); ?> هوارة شوب — جميع الحقوق محفوظة</span>
    <span class="houara-mf-badges">
      <span>💵 الدفع عند الاستلام</span>
      <span>🚚 توصيل نفس اليوم</span>
      <span>🔒 آمن 100%</span>
    </span>
  </div>
</footer>
    <?php
}


// (Astra default header CSS removed — it conflicted with custom
//  templates that share the .site-header class. The About page
//  now ships its own styled header inside the shortcode.)


// ═══════════════════════════════════════════════════════════════
// [houarashop_about] SHORTCODE — About page content
// Paste into a Custom HTML block on a regular page:
//     [houarashop_about]
// ═══════════════════════════════════════════════════════════════
add_shortcode( 'houarashop_about', 'houarashop_about_shortcode' );
function houarashop_about_shortcode() {
    $logo_url     = defined('HOUARA_LOGO_URL') ? HOUARA_LOGO_URL : '';
    $home_url     = home_url('/');
    $shop_url     = home_url('/matjar/');
    $contact_url  = home_url('/contact/');
    $account_url  = function_exists('wc_get_page_id') ? get_permalink( wc_get_page_id('myaccount') ) : home_url('/my-account/');
    $cart_url     = function_exists('wc_get_page_id') ? get_permalink( wc_get_page_id('cart') ) : home_url('/cart/');
    $cart_count   = ( function_exists('WC') && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;

    ob_start();
    ?>
<style>
/* ── Hide Astra default header/title/sidebar/footer on this page ── */
#masthead, header#masthead, .ast-primary-header-bar, .site-primary-header-wrap,
.ast-below-header, .ast-above-header, .entry-header, .entry-title,
.ast-page-title, .page-title,
.ast-breadcrumbs, .site-main .ast-no-sidebar .entry-header,
#colophon, footer#colophon, .site-footer.ast-builder-grid-row-container,
.ast-footer-copyright, .ast-builder-footer-grid-container { display:none !important; }

/* ── Force full-width break-out of Astra containers ── */
#page, #content, .site-content, .ast-container, .ast-container-fluid,
.content-area, .site-main, article.page, article.post, .entry-content,
.wp-block-html, .wp-site-blocks {
    max-width:100% !important; width:100% !important;
    padding:0 !important; margin:0 !important;
    background:transparent !important;
}
#content > .ast-container { padding:0 !important; }
.ast-separate-container #primary, .ast-plain-container #primary { padding:0 !important; margin:0 !important; }
body.page { background:#fff !important; }
.hs-about-wrap { width:100%; max-width:100%; margin:0; padding:0; }

/* ── Custom header matching homepage ── */
.hs-countdown-bar { background:#FF6B00; padding:10px 20px; text-align:center; }
.hs-countdown-bar p { color:#fff; font-size:17px; margin:0; font-weight:700; line-height:1.3; font-family:'Cairo',sans-serif; }
.hs-countdown-bar #hs-timer { color:#FFE000; font-weight:900; direction:ltr; display:inline-block; }
.hs-site-header { background:#1A1A2E; padding:15px 40px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1000; box-shadow:0 4px 20px rgba(0,0,0,0.1); font-family:'Cairo',sans-serif; direction:rtl; }
.hs-site-header .hs-header-left { display:flex; align-items:center; gap:15px; }
.hs-site-header .hs-logo img { height:40px; width:auto; display:block; }
.hs-site-header .hs-header-nav { display:flex; gap:22px; align-items:center; }
.hs-site-header .hs-header-nav a { color:#ccc; font-size:15px; font-weight:600; text-decoration:none; transition:color 0.2s; }
.hs-site-header .hs-header-nav a:hover { color:#FF6B00; }
.hs-site-header .hs-header-cart { background:#FF6B00; color:#fff !important; padding:8px 20px; border-radius:25px; font-weight:700; font-size:15px; text-decoration:none; }
.hs-site-header .hs-hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; background:none; border:none; padding:5px; }
.hs-site-header .hs-hamburger span { display:block; width:25px; height:3px; background:#fff; border-radius:3px; }
.hs-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9998; }
.hs-overlay.open { display:block; }
.hs-mobile-nav { display:none; position:fixed; top:0; right:0; width:280px; height:100%; background:#1A1A2E; z-index:9999; padding:20px; box-shadow:-5px 0 20px rgba(0,0,0,0.3); transform:translateX(100%); transition:transform 0.3s; overflow-y:auto; direction:rtl; font-family:'Cairo',sans-serif; }
.hs-mobile-nav.open { transform:translateX(0); }
.hs-mobile-nav .hs-mn-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; padding-bottom:15px; border-bottom:1px solid rgba(255,255,255,0.1); }
.hs-mobile-nav .hs-mn-head img { height:38px; width:auto; }
.hs-mobile-nav .hs-mn-close { color:#fff; font-size:24px; cursor:pointer; background:none; border:none; }
.hs-mobile-nav a { display:block; color:#ccc; font-size:16px; font-weight:600; padding:15px 0; border-bottom:1px solid rgba(255,255,255,0.07); text-decoration:none; }
.hs-mobile-nav a:hover { color:#FF6B00; }
.hs-mobile-nav .hs-mn-cart { margin-top:20px; background:#FF6B00 !important; color:#fff !important; padding:14px 20px !important; border-radius:8px; text-align:center; font-weight:700 !important; border:none !important; }
@media (max-width:768px) {
    .hs-site-header { padding:12px 20px; }
    .hs-site-header .hs-header-nav { display:none; }
    .hs-site-header .hs-hamburger { display:flex; }
    .hs-mobile-nav { display:block; }
}

.hs-about { font-family:'Cairo','Segoe UI',sans-serif; direction:rtl; color:#1A1A2E; line-height:1.7; width:100%; }
.hs-about * { box-sizing:border-box; }
.hs-about-hero { background:linear-gradient(135deg, #1A1A2E 0%, #2a2a45 100%); color:#fff; padding:80px 20px; text-align:center; width:100%; margin:0; }
.hs-about-hero h1 { font-size:2.6rem; font-weight:900; margin:0 0 14px 0; color:#fff; }
.hs-about-hero p { font-size:1.2rem; max-width:760px; margin:0 auto; opacity:0.95; color: #aab4c8; }
.hs-about-inner { max-width:1100px; margin:0 auto; padding:50px 20px; }
.hs-about-section { background:#fff; border-radius:14px; padding:32px 28px; margin-bottom:24px; box-shadow:0 2px 14px rgba(0,0,0,0.04); border:1px solid #f0f0f4; }
.hs-about-section h2 { font-size:1.5rem; font-weight:800; color:#1A1A2E; margin:0 0 16px 0; padding-bottom:12px; border-bottom:3px solid #FF6B00; display:inline-block; }
.hs-about-section p { font-size:1.02rem; color:#333; margin:0 0 14px 0; }
.hs-about-section p:last-child { margin-bottom:0; }
.hs-about-pillars { display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; margin:30px 0; }
.hs-about-pillar { background:#fff; border-radius:14px; padding:28px 20px; text-align:center; border:2px solid #f0f0f4; transition:all 0.25s; }
.hs-about-pillar:hover { border-color:#FF6B00; transform:translateY(-4px); box-shadow:0 8px 24px rgba(255,107,0,0.12); }
.hs-about-pillar .icon { font-size:2.6rem; margin-bottom:10px; display:block; }
.hs-about-pillar h3 { font-size:1.15rem; font-weight:800; color:#1A1A2E; margin:0 0 8px 0; }
.hs-about-pillar p { font-size:0.92rem; color:#555; margin:0; line-height:1.55; }
.hs-about-cta { background:#25D366; color:#fff; border-radius:14px; padding:36px 24px; text-align:center; margin-top:30px; }
.hs-about-cta h2 { color:#fff; font-size:1.6rem; font-weight:900; margin:0 0 10px 0; border:none; padding:0; display:block; }
.hs-about-cta p { color:rgba(255,255,255,0.95); font-size:1.05rem; margin:0 0 20px 0; }
.hs-about-cta a { display:inline-flex; align-items:center; gap:10px; background:#fff; color:#25D366 !important; padding:14px 32px; border-radius:50px; font-weight:900; font-size:1.1rem; text-decoration:none; transition:all 0.2s; }
.hs-about-cta a:hover { transform:scale(1.05); box-shadow:0 6px 20px rgba(0,0,0,0.18); }
@media (max-width:768px) {
  .hs-about-hero { padding:44px 18px; }
  .hs-about-hero h1 { font-size:1.8rem; }
  .hs-about-hero p { font-size:1rem; }
  .hs-about-section { padding:24px 20px; }
  .hs-about-section h2 { font-size:1.25rem; }
  .hs-about-pillars { grid-template-columns:1fr; gap:14px; }
  .hs-about-cta h2 { font-size:1.3rem; }
}
</style>

<div class="hs-about-wrap">

<!-- Mobile nav overlay + drawer -->
<div class="hs-overlay" id="hs-overlay" onclick="hsCloseMenu()"></div>
<nav class="hs-mobile-nav" id="hs-mobile-nav">
    <div class="hs-mn-head">
        <a href="<?php echo esc_url( $home_url ); ?>"><img src="<?php echo esc_url( $logo_url ); ?>" alt="هوارة شوب"></a>
        <button class="hs-mn-close" onclick="hsCloseMenu()">✕</button>
    </div>
    <a href="<?php echo esc_url( $home_url ); ?>">🏠 الرئيسية</a>
    <a href="<?php echo esc_url( $shop_url ); ?>">🛍️ المتجر</a>
    <a href="<?php echo esc_url( home_url('/about-us/') ); ?>">ℹ️ من نحن</a>
    <a href="<?php echo esc_url( $contact_url ); ?>">📞 تواصل معنا</a>
    <a href="<?php echo esc_url( $account_url ); ?>">👤 حسابي</a>
    <a href="<?php echo esc_url( $cart_url ); ?>" class="hs-mn-cart">🛒 السلة</a>
</nav>

<!-- Countdown bar -->
<div class="hs-countdown-bar">
    <p>
        <span id="hs-promo-today" style="display:none;">🚚 اطلب قبل 04:00 مساءاً ليصلك طلبك اليوم &nbsp;&nbsp; ⏱️ الوقت المتبقي: <span id="hs-timer"></span></span>
        <span id="hs-promo-tomorrow" style="display:none;">🚀 اطلب الآن لضمان توصيل طلبك خلال 24 ساعة</span>
    </p>
</div>

<!-- Header -->
<header class="hs-site-header">
    <div class="hs-header-left">
        <button class="hs-hamburger" onclick="hsOpenMenu()"><span></span><span></span><span></span></button>
        <a href="<?php echo esc_url( $home_url ); ?>" class="hs-logo">
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="هوارة شوب">
        </a>
    </div>
    <nav class="hs-header-nav">
        <a href="<?php echo esc_url( $home_url ); ?>">الرئيسية</a>
        <a href="<?php echo esc_url( $shop_url ); ?>">المتجر</a>
        <a href="<?php echo esc_url( home_url('/about-us/') ); ?>">من نحن</a>
        <a href="<?php echo esc_url( $contact_url ); ?>">تواصل معنا</a>
        <a href="<?php echo esc_url( $account_url ); ?>">حسابي</a>
    </nav>
    <a href="<?php echo esc_url( $cart_url ); ?>" class="hs-header-cart">
        🛒 (<span class="cart-count-badge"><?php echo (int) $cart_count; ?></span>)
    </a>
</header>

<script>
function hsOpenMenu(){document.getElementById('hs-mobile-nav').classList.add('open');document.getElementById('hs-overlay').classList.add('open');}
function hsCloseMenu(){document.getElementById('hs-mobile-nav').classList.remove('open');document.getElementById('hs-overlay').classList.remove('open');}
(function(){
    function update(){
        var now=new Date();
        var h=now.getHours(), m=now.getMinutes(), s=now.getSeconds();
        var today=document.getElementById('hs-promo-today');
        var tomorrow=document.getElementById('hs-promo-tomorrow');
        var timer=document.getElementById('hs-timer');
        if(!today||!tomorrow||!timer) return;
        if(h<16){
            today.style.display='inline';
            tomorrow.style.display='none';
            var rh=15-h, rm=59-m, rs=59-s;
            timer.textContent=(rh<10?'0'+rh:rh)+' h '+(rm<10?'0'+rm:rm)+' m';
        } else {
            today.style.display='none';
            tomorrow.style.display='inline';
        }
    }
    update();
    setInterval(update,1000);
})();
</script>

<div class="hs-about">

  <div class="hs-about-hero">
    <h1>من نحن — هوارة شوب</h1>
    <p>متجرك المحلي في قلب أولاد تايمة وهوارة. نوصلك طلبك في نفس اليوم، وتدفع فقط عند الاستلام.</p>
  </div>

  <div class="hs-about-inner">

  <div class="hs-about-section">
    <h2>مهمتنا</h2>
    <p>هوارة شوب ولد من فكرة بسيطة: لماذا ننتظر أيامًا لاستلام منتج من متجر بعيد، في الوقت الذي يمكن فيه أن يصلنا في نفس اليوم من متجر قريب منا؟ مهمتنا أن نوفر لسكان أولاد تايمة وهوارة كل ما يحتاجونه في حياتهم اليومية، بسعر عادل، وتوصيل سريع، وثقة كاملة.</p>
    <p>نحن لسنا متجرًا إلكترونيًا عاديًا — نحن جيرانكم. نعيش معكم، نفهم احتياجاتكم، ونختار منتجاتنا بعناية لتناسب واقعكم اليومي.</p>
  </div>

  <div class="hs-about-section">
    <h2>ما يميزنا</h2>
    <p><strong>توصيل في نفس اليوم:</strong> اطلب قبل الساعة 4:00 مساءً، واستلم طلبك قبل الساعة 11:00 ليلًا. هذا وعدنا لك.</p>
    <p><strong>الدفع عند الاستلام فقط:</strong> لا تدفع درهمًا واحدًا قبل أن تستلم منتجك وتتأكد من جودته.</p>
    <p><strong>منتجات مختارة بعناية:</strong> نختبر كل منتج قبل عرضه. لا نبيع ما لا نثق فيه.</p>
    <p><strong>دعم واتساب مباشر:</strong> عندك سؤال؟ راسلنا على واتساب وستحصل على رد سريع من شخص حقيقي، لا من روبوت.</p>
  </div>

  <div class="hs-about-pillars">
    <div class="hs-about-pillar">
      <span class="icon">🚚</span>
      <h3>توصيل سريع</h3>
      <p>نفس اليوم لأولاد تايمة وهوارة</p>
    </div>
    <div class="hs-about-pillar">
      <span class="icon">💵</span>
      <h3>الدفع عند الاستلام</h3>
      <p>ادفع فقط عندما تستلم طلبك</p>
    </div>
    <div class="hs-about-pillar">
      <span class="icon">💬</span>
      <h3>دعم مباشر</h3>
      <p>راسلنا على واتساب في أي وقت</p>
    </div>
  </div>

  <div class="hs-about-section">
    <h2>التزامنا</h2>
    <p>نحن نعلم أن الثقة تُبنى خطوة بخطوة. لذلك نلتزم بثلاثة وعود بسيطة: منتجات حقيقية كما تراها في الصور، أسعار شفافة بدون رسوم مخفية، وخدمة عملاء تستجيب بسرعة وباحترام.</p>
    <p>إذا لم تكن راضيًا عن منتجك، فقط راسلنا وسنجد حلًا معك. رضاك هو أساس استمراريتنا.</p>
  </div>

  <div class="hs-about-section">
    <h2>رؤيتنا</h2>
    <p>نحلم أن يصبح هوارة شوب المتجر المحلي الأول الذي يثق به كل بيت في منطقة هوارة. نبدأ من أولاد تايمة، لنجعل التسوق الإلكتروني المحلي تجربة سهلة، آمنة، وقريبة منكم.</p>
  </div>

  <div class="hs-about-cta">
    <h2>عندك سؤال؟ راسلنا على واتساب</h2>
    <p>فريقنا جاهز للرد عليك من الساعة 8 صباحًا إلى 11 ليلًا</p>
    <a href="https://wa.me/212702048470" target="_blank" rel="noopener">💬 تواصل معنا الآن</a>
  </div>

  </div><!-- /.hs-about-inner -->

</div><!-- /.hs-about -->

<?php houarashop_render_footer(); ?>

</div><!-- /.hs-about-wrap -->
    <?php
    return ob_get_clean();
}

// ═══════════════════════════════════════════════════════════════
// FORCE LOAD LEGAL PAGE TEMPLATES (NO SHORTCODES NEEDED)
// ═══════════════════════════════════════════════════════════════
add_filter('template_include', function($template) {
    if (is_page('privacy-policy') || is_page('سياسة-الخصوصية')) {
        $custom = get_stylesheet_directory() . '/houarashop-privacy.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_page('terms') || is_page('الشروط-والأحكام') || is_page('terms-of-service')) {
        $custom = get_stylesheet_directory() . '/houarashop-terms.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_page('return-policy') || is_page('سياسة-الإرجاع')) {
        $custom = get_stylesheet_directory() . '/houarashop-returns.php';
        if (file_exists($custom)) return $custom;
    }
    return $template;
}, 999);
