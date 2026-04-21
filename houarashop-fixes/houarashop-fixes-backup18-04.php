<?php
/**
 * Plugin Name: HOUARA-SHOP Fixes
 * Description: Cart fragment refresh + site fixes for houarashop.com
 * Version: 1.2
 */

defined('ABSPATH') || exit;

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
