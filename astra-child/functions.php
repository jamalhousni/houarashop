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
<!-- ── Open Graph (Facebook, WhatsApp, Telegram previews) ── -->
<meta property="og:type"               content="<?php echo esc_attr( $og_type ); ?>">
<meta property="og:site_name"          content="<?php echo esc_attr( $site_name ); ?>">
<meta property="og:title"              content="<?php echo esc_attr( $title ); ?>">
<meta property="og:description"        content="<?php echo esc_attr( $desc ); ?>">
<meta property="og:url"                content="<?php echo esc_url( $url ); ?>">
<meta property="og:image"              content="<?php echo esc_url( $thumb_url ); ?>">
<meta property="og:image:width"        content="1200">
<meta property="og:image:height"       content="630">
<meta property="og:image:alt"          content="<?php echo esc_attr( $site_name ); ?>">
<meta property="og:locale"             content="ar_MA">

<!-- ── Twitter / X Card ── -->
<meta name="twitter:card"              content="summary_large_image">
<meta name="twitter:title"             content="<?php echo esc_attr( $title ); ?>">
<meta name="twitter:description"       content="<?php echo esc_attr( $desc ); ?>">
<meta name="twitter:image"             content="<?php echo esc_url( $thumb_url ); ?>">

<!-- ── Meta description (for Google snippet) ── -->
<meta name="description"               content="<?php echo esc_attr( $desc ); ?>">

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
// ONE ITEM PER PRODUCT IN CART
// ═══════════════════════════════════════════════════════════════
add_action( 'woocommerce_add_to_cart', 'houarashop_force_single_quantity', 99, 6 );
function houarashop_force_single_quantity( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
    $cart = WC()->cart;
    if ( $cart && isset( $cart->cart_contents[ $cart_item_key ] ) && (int) $cart->cart_contents[ $cart_item_key ]['quantity'] > 1 ) {
        $cart->cart_contents[ $cart_item_key ]['quantity'] = 1;
        $cart->calculate_totals();
    }
}


// ═══════════════════════════════════════════════════════════════
// CART BADGE SYNC (AJAX)
// ═══════════════════════════════════════════════════════════════
add_action( 'wp_footer', 'houarashop_cart_badge_sync_script', 99 );
function houarashop_cart_badge_sync_script() {
    if ( ! function_exists( 'WC' ) ) return;
    ?>
    <script>
    (function($) {
        if (typeof $ === 'undefined') return;
        $(document.body).on('added_to_cart', function() {
            $.post('<?php echo esc_url( admin_url("admin-ajax.php") ); ?>', { action: 'houara_cart_count' }, function(data) {
                if (data && data.success && data.data) {
                    $('.houara-cart-count').text(data.data.text);
                    $('.cart-count-badge').text(data.data.count);
                }
            });
        });
    })(jQuery);
    </script>
    <?php
}

add_action( 'wp_ajax_houara_cart_count', 'houarashop_ajax_cart_count' );
add_action( 'wp_ajax_nopriv_houara_cart_count', 'houarashop_ajax_cart_count' );
function houarashop_ajax_cart_count() {
    $cart = WC()->cart;
    $item_count = $cart ? $cart->get_cart_contents_count() : 0;
    wp_send_json_success( array( 'count' => $item_count, 'text' => $item_count . ' منتج' ) );
}


// ═══════════════════════════════════════════════════════════════
// HIDE WC NOTICES EXCEPT ON CART & CHECKOUT
// ═══════════════════════════════════════════════════════════════
add_action( 'template_redirect', 'houarashop_clear_notices_except_cart', 99 );
function houarashop_clear_notices_except_cart() {
    if ( function_exists( 'is_cart' ) && ! is_cart() && ! is_checkout() ) {
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
    .woocommerce ul.products li.product.houara-out-of-stock .button.add_to_cart_button { background:#e0e0e0 !important; color:#9e9e9e !important; cursor:not-allowed !important; pointer-events:none !important; }
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
