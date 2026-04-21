<?php
/**
 * Plugin Name: HOUARA-SHOP Fixes
 * Description: Cart fragment refresh + site fixes for houarashop.com
 * Version: 1.3
 */

defined('ABSPATH') || exit;

// ════════════════════════════════════════════════════════════
// ✅ BILLING STATE FIX — runs during AJAX checkout submission
// The template file hooks are NOT active during AJAX — only
// plugin/functions.php hooks run. All state fixes go here.
// ════════════════════════════════════════════════════════════

// 1) Make state field not required at the locale level for Morocco
add_filter('woocommerce_get_country_locale', function($locale) {
    $locale['MA']['state']['required'] = false;
    $locale['MA']['state']['hidden']   = true;
    return $locale;
}, 9999);

// 2) Force a valid state + country into posted data before WC validates
add_filter('woocommerce_checkout_posted_data', function($data) {
    $data['billing_country'] = 'MA';
    $data['billing_state']   = 'MA-09'; // Souss-Massa
    if (empty($data['billing_city']))     $data['billing_city']     = 'أولاد تايمة';
    if (empty($data['billing_postcode'])) $data['billing_postcode'] = '83350';
    if (empty($data['billing_last_name'])) $data['billing_last_name'] = '.';
    if (empty($data['billing_email']))    $data['billing_email']    = 'order' . time() . '@houarashop.com';
    $data['payment_method'] = 'cod';
    return $data;
}, 9999);

// 3) Mark state/city/postcode/country/email/last_name as NOT required
add_filter('woocommerce_checkout_fields', function($fields) {
    $optional = ['billing_state','billing_city','billing_postcode',
                 'billing_country','billing_email','billing_last_name',
                 'billing_company','billing_address_2'];
    foreach ($optional as $key) {
        if (isset($fields['billing'][$key])) {
            $fields['billing'][$key]['required'] = false;
        }
    }
    return $fields;
}, 9999);

// 4) Nuclear fallback: strip any remaining state error after validation
add_action('woocommerce_after_checkout_validation', function($data, $errors) {
    if (empty($errors->errors)) return;
    $snapshot  = $errors->errors;
    $snap_data = $errors->error_data;
    foreach ($snapshot as $code => $messages) {
        $keep = array_filter($messages, function($msg) {
            return strpos($msg, 'المنطقة') === false
                && strpos($msg, 'billing_state') === false
                && strpos($msg, 'State') === false;
        });
        if (count($keep) !== count($messages)) {
            $errors->remove($code);
            foreach ($keep as $msg) {
                $errors->add($code, $msg, isset($snap_data[$code]) ? $snap_data[$code] : '');
            }
        }
    }
}, PHP_INT_MAX, 2);

// ════════════════════════════════════════════════════════════

// ════════════════════════════════════════════════════════════
// ✅ Global CSS: hide floating WhatsApp button + product checkmarks
// ════════════════════════════════════════════════════════════
add_action('wp_head', function() { ?>
<style>
/* ─ Floating WhatsApp plugin button (blue) ─ */
.whatsapp-float,.floating-whatsapp,.whatsapp-chat-widget,
.wpa-bubble,.wpa-btn,.chatplugin-widget,.wcb-widget,
.clicktochat,.ctc-widget,div[class*="whatsapp-"][class*="float"],
div[id*="whatsapp-float"],div[id*="whatsapp-chat"],
.wabiz-btn,.wa-float,.floating_button_wrap,.wp-whatsapp,
.whatsapp-me,.wchat-me,.wame-widget,.ql-widget,.ql-float,
[class*="qlwapp"],.floating-wpp,.wpp-btn,
[class*="wa-float"],[class*="wa-btn"],[class*="wa-widget"],
a[href*="wa.me"][style*="position: fixed"]{display:none!important;visibility:hidden!important}
/* ─ Big green checkmarks on product cards ─ */
.woocommerce ul.products li.product .added_to_cart,
.woocommerce ul.products li.product .checkmark,
.woocommerce ul.products li.product .tick,
.woocommerce ul.products li.product .success-overlay,
.woocommerce ul.products li.product .added-to-cart-feedback,
.woocommerce ul.products li.product .woo-added-to-cart{display:none!important}
</style>
<?php }, 99);

// ✅ Register cart count as a WooCommerce fragment
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    $fragments['.houara-cart-count'] = '<span class="houara-cart-count">' . $count . ' منتج</span>';
    return $fragments;
});

// ✅ Custom AJAX endpoint — always returns LIVE cart count from session
// This bypasses WooCommerce's localStorage cache completely
add_action('wp_ajax_houara_cart_count', 'houara_get_live_cart_count');
add_action('wp_ajax_nopriv_houara_cart_count', 'houara_get_live_cart_count');
function houara_get_live_cart_count() {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    wp_send_json_success(['count' => $count, 'text' => $count . ' منتج']);
}
