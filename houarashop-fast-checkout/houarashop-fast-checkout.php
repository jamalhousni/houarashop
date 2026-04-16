<?php
/**
 * Plugin Name: HouaraShop Fast Checkout Enforcer
 * Description: Instantly kills the complicated WooCommerce Blocks and forces the Ultra-Fast Classic Checkout built by your AI developer.
 * Version: 1.0
 * Author: Houara Shop Assistant
 */

add_filter( 'woocommerce_cart_is_block_cart', '__return_false', 99999 );
add_filter( 'woocommerce_checkout_is_block_checkout', '__return_false', 99999 );

// Remove massive CSS files from the blocks to speed up the site!
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'wc-blocks-style' );
    wp_dequeue_style( 'wc-blocks-vendors-style' );
    wp_dequeue_style( 'wc-blocks-packages-style' );
}, 9999 );
