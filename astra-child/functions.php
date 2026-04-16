<?php
/**
 * HOUARA-SHOP Child Theme — functions.php
 * ────────────────────────────────────────
 * Enqueues the parent Astra stylesheet so the child theme inherits
 * all parent styling while allowing us to override with our own CSS.
 *
 * Do NOT put custom site logic in here unless it needs to run on
 * every page — that job belongs to the houarashop-fixes plugin.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load parent + child theme stylesheets in the correct order.
 * Parent first, child second, so the child can override parent rules.
 */
add_action( 'wp_enqueue_scripts', 'houarashop_child_enqueue_styles', 20 );
function houarashop_child_enqueue_styles() {

    // 1. Parent (Astra) stylesheet
    wp_enqueue_style(
        'astra-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'astra' )->get( 'Version' )
    );

    // 2. Child stylesheet (loads AFTER parent so it can override)
    wp_enqueue_style(
        'houarashop-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'astra-parent-style' ),
        wp_get_theme()->get( 'Version' )
    );
}
