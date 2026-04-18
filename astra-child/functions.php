<?php
/**
 * HOUARA-SHOP Child Theme — functions.php
 * ────────────────────────────────────────
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load parent + child theme stylesheets in the correct order.
 */
add_action( 'wp_enqueue_scripts', 'houarashop_child_enqueue_styles', 20 );
function houarashop_child_enqueue_styles() {
    wp_enqueue_style(
        'astra-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'astra' )->get( 'Version' )
    );
    wp_enqueue_style(
        'houarashop-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'astra-parent-style' ),
        wp_get_theme()->get( 'Version' )
    );
}


// ═══════════════════════════════════════════════════════════════
// HOUARA-SHOP: ONE ITEM PER PRODUCT IN CART
//
// Strategy: Allow WooCommerce to add normally, but after adding,
// immediately SET the quantity to 1 (not increment, SET).
// This avoids the redirect bug caused by returning false from
// validation, and avoids the double-count bug from AJAX timing.
// ═══════════════════════════════════════════════════════════════

/**
 * After any add-to-cart, immediately reset that product's quantity to 1.
 *
 * This fires AFTER the item is added to the cart session.
 * Whether it was already there (qty became 2) or new (qty is 1),
 * we always force it back to 1.
 *
 * Cart page quantity changes use a DIFFERENT mechanism (update_cart action)
 * so those are NOT affected by this hook.
 */
add_action( 'woocommerce_add_to_cart', 'houarashop_force_single_quantity', 99, 6 );
function houarashop_force_single_quantity( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
    // If quantity ended up > 1 (because product was already in cart), reset to 1
    $cart = WC()->cart;
    if ( $cart && isset( $cart->cart_contents[ $cart_item_key ] ) ) {
        if ( (int) $cart->cart_contents[ $cart_item_key ]['quantity'] > 1 ) {
            $cart->cart_contents[ $cart_item_key ]['quantity'] = 1;
            // Recalculate totals
            $cart->calculate_totals();
        }
    }
}

/**
 * Also fix the AJAX cart fragment count.
 *
 * When WooCommerce sends back the cart fragment after AJAX add-to-cart,
 * it reads from the session which by now has been corrected to qty=1.
 * So the fragment count will be correct.
 *
 * The only remaining issue is the LOCAL JS counter on the shop page
 * incrementing BEFORE the server responds. We fix that below.
 */
add_action( 'wp_footer', 'houarashop_cart_badge_sync_script' );
function houarashop_cart_badge_sync_script() {
    if ( ! function_exists( 'WC' ) ) return;
    ?>
    <script>
    (function($) {
        if (typeof $ === 'undefined') return;

        // After WooCommerce processes add-to-cart via AJAX,
        // sync ALL our custom badge elements with the real server count.
        // WooCommerce fragments contain the true cart total.
        $(document.body).on('added_to_cart', function(event, fragments, cart_hash) {
            // Ask server for real count (already corrected to max 1 per product)
            $.post('<?php echo esc_url( admin_url("admin-ajax.php") ); ?>', 
                { action: 'houara_cart_count' }, 
                function(data) {
                    if (data && data.success && data.data) {
                        var realCount = data.data.count;
                        var realText  = data.data.text;
                        // Sync home page badge (shows "X منتج")
                        $('.houara-cart-count').text(realText);
                        // Sync shop page badge (shows just the number)
                        $('.cart-count-badge').text(realCount);
                    }
                }
            );
        });

    })(jQuery);
    </script>
    <?php
}

/**
 * AJAX handler: return real cart count and item count.
 */
add_action( 'wp_ajax_houara_cart_count', 'houarashop_ajax_cart_count' );
add_action( 'wp_ajax_nopriv_houara_cart_count', 'houarashop_ajax_cart_count' );
function houarashop_ajax_cart_count() {
    // Number of unique products in cart (not sum of quantities)
    $cart       = WC()->cart;
    $item_count = $cart ? $cart->get_cart_contents_count() : 0;
    wp_send_json_success( array(
        'count' => $item_count,
        'text'  => $item_count . ' منتج',
    ) );
}
