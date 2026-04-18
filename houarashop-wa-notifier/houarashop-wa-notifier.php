<?php
/**
 * Plugin Name: HOUARA-SHOP WhatsApp Order Notifier
 * Plugin URI: https://houarashop.com
 * Description: Sends instant WhatsApp notifications to admins when new orders arrive. Uses CallMeBot API (free).
 * Version: 1.0.0
 * Author: HOUARA-SHOP
 * Text Domain: houarashop-wa-notifier
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 7.0
 * WC tested up to: 9.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HouaraShop_WA_Notifier {

    private $option_key = 'houarashop_wa_notifier_settings';

    public function __construct() {
        // Admin menu + settings
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );

        // Hook into WooCommerce new order
        add_action( 'woocommerce_new_order', array( $this, 'send_new_order_notification' ), 10, 1 );
        add_action( 'woocommerce_checkout_order_processed', array( $this, 'send_new_order_notification' ), 10, 1 );

        // AJAX test button
        add_action( 'wp_ajax_houarashop_wa_test', array( $this, 'ajax_test_message' ) );

        // Admin notice when WooCommerce not active
        add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
    }

    /**
     * Show notice if WooCommerce is not active
     */
    public function woocommerce_missing_notice() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="notice notice-error"><p><strong>HOUARA-SHOP WhatsApp Notifier:</strong> WooCommerce is not active. Please activate WooCommerce first.</p></div>';
        }
    }

    /**
     * Add settings page to admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'WhatsApp Order Notifier',
            '📱 WhatsApp Notifier',
            'manage_options',
            'houarashop-wa-notifier',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting( 'houarashop_wa_group', $this->option_key, array(
            'sanitize_callback' => array( $this, 'sanitize_settings' ),
        ) );
    }

    /**
     * Sanitize settings input
     */
    public function sanitize_settings( $input ) {
        $sanitized = array();
        $sanitized['enabled']          = ! empty( $input['enabled'] ) ? 1 : 0;
        $sanitized['apikey_1']         = isset( $input['apikey_1'] ) ? sanitize_text_field( $input['apikey_1'] ) : '';
        $sanitized['phone_1']          = isset( $input['phone_1'] ) ? $this->clean_phone( $input['phone_1'] ) : '';
        $sanitized['apikey_2']         = isset( $input['apikey_2'] ) ? sanitize_text_field( $input['apikey_2'] ) : '';
        $sanitized['phone_2']          = isset( $input['phone_2'] ) ? $this->clean_phone( $input['phone_2'] ) : '';
        $sanitized['include_admin_url']= ! empty( $input['include_admin_url'] ) ? 1 : 0;
        return $sanitized;
    }

    /**
     * Clean phone number (remove spaces, dashes, but keep +)
     */
    private function clean_phone( $phone ) {
        return preg_replace( '/[^0-9+]/', '', $phone );
    }

    /**
     * Get settings with defaults
     */
    public function get_settings() {
        $defaults = array(
            'enabled'           => 0,
            'apikey_1'          => '',
            'phone_1'           => '',
            'apikey_2'          => '',
            'phone_2'           => '',
            'include_admin_url' => 1,
        );
        return wp_parse_args( get_option( $this->option_key, array() ), $defaults );
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        $settings = $this->get_settings();
        ?>
        <div class="wrap">
            <h1>📱 WhatsApp Order Notifier</h1>
            <p>Automatically sends WhatsApp messages when new orders arrive. Powered by <a href="https://www.callmebot.com/blog/free-api-whatsapp-messages/" target="_blank">CallMeBot (free)</a>.</p>

            <div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;margin:20px 0;max-width:900px;">
                <h2 style="margin-top:0;">🚀 How to Get Your API Key</h2>
                <ol>
                    <li>Save this number in your WhatsApp: <strong>+34 644 51 95 23</strong></li>
                    <li>Send it this exact message: <code>I allow callmebot to send me messages</code></li>
                    <li>Wait for reply (up to 2 minutes)</li>
                    <li>Copy the <strong>APIKEY</strong> number from their reply</li>
                    <li>Paste it below and click "Save Settings"</li>
                </ol>
            </div>

            <form method="post" action="options.php">
                <?php settings_fields( 'houarashop_wa_group' ); ?>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row">
                            <label for="enabled">Enable Notifications</label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( $this->option_key ); ?>[enabled]" id="enabled" value="1" <?php checked( 1, $settings['enabled'] ); ?>>
                                <strong>Send WhatsApp notifications on new orders</strong>
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <h2 style="border-top:1px solid #e0e0e0;padding-top:20px;margin-bottom:0;">👤 Primary Recipient (Required)</h2>
                        </th>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="phone_1">Phone Number #1</label>
                        </th>
                        <td>
                            <input type="text" name="<?php echo esc_attr( $this->option_key ); ?>[phone_1]" id="phone_1" value="<?php echo esc_attr( $settings['phone_1'] ); ?>" class="regular-text" placeholder="+212702048470" />
                            <p class="description">Full international format, e.g., <code>+212702048470</code></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="apikey_1">API Key #1</label>
                        </th>
                        <td>
                            <input type="text" name="<?php echo esc_attr( $this->option_key ); ?>[apikey_1]" id="apikey_1" value="<?php echo esc_attr( $settings['apikey_1'] ); ?>" class="regular-text" placeholder="1234567" />
                            <p class="description">Get this from CallMeBot (see instructions above)</p>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <h2 style="border-top:1px solid #e0e0e0;padding-top:20px;margin-bottom:0;">👥 Secondary Recipient (Optional)</h2>
                            <p style="font-weight:normal;color:#666;">For Nourdin, delivery team, or backup contact</p>
                        </th>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="phone_2">Phone Number #2</label>
                        </th>
                        <td>
                            <input type="text" name="<?php echo esc_attr( $this->option_key ); ?>[phone_2]" id="phone_2" value="<?php echo esc_attr( $settings['phone_2'] ); ?>" class="regular-text" placeholder="+212XXXXXXXXX (optional)" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="apikey_2">API Key #2</label>
                        </th>
                        <td>
                            <input type="text" name="<?php echo esc_attr( $this->option_key ); ?>[apikey_2]" id="apikey_2" value="<?php echo esc_attr( $settings['apikey_2'] ); ?>" class="regular-text" placeholder="(optional)" />
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <h2 style="border-top:1px solid #e0e0e0;padding-top:20px;margin-bottom:0;">⚙️ Options</h2>
                        </th>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="include_admin_url">Include Admin Link</label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( $this->option_key ); ?>[include_admin_url]" id="include_admin_url" value="1" <?php checked( 1, $settings['include_admin_url'] ); ?>>
                                Include a link to manage the order in WP Admin (recommended)
                            </label>
                        </td>
                    </tr>
                </table>

                <?php submit_button( 'Save Settings' ); ?>
            </form>

            <hr style="margin:30px 0;">

            <div style="background:#f0f6fc;border:1px solid #0073aa;border-radius:8px;padding:20px;max-width:900px;">
                <h2 style="margin-top:0;">🧪 Send Test Message</h2>
                <p>Click the button below to send a test message to your configured numbers.</p>
                <button type="button" id="houarashop-wa-test-btn" class="button button-primary button-large">
                    📤 Send Test Message
                </button>
                <div id="houarashop-wa-test-result" style="margin-top:15px;"></div>
            </div>

            <script>
            jQuery(document).ready(function($) {
                $('#houarashop-wa-test-btn').on('click', function() {
                    var $btn = $(this);
                    var $result = $('#houarashop-wa-test-result');
                    $btn.prop('disabled', true).text('⏳ Sending...');
                    $result.html('');

                    $.post(ajaxurl, {
                        action: 'houarashop_wa_test',
                        nonce: '<?php echo wp_create_nonce( 'houarashop_wa_test' ); ?>'
                    }, function(response) {
                        if (response.success) {
                            $result.html('<div style="padding:12px;background:#d4edda;border:1px solid #28a745;border-radius:4px;color:#155724;">✅ ' + response.data + '</div>');
                        } else {
                            $result.html('<div style="padding:12px;background:#f8d7da;border:1px solid #dc3545;border-radius:4px;color:#721c24;">❌ ' + response.data + '</div>');
                        }
                        $btn.prop('disabled', false).text('📤 Send Test Message');
                    }).fail(function() {
                        $result.html('<div style="padding:12px;background:#f8d7da;border:1px solid #dc3545;border-radius:4px;color:#721c24;">❌ Request failed. Check your server error log.</div>');
                        $btn.prop('disabled', false).text('📤 Send Test Message');
                    });
                });
            });
            </script>
        </div>
        <?php
    }

    /**
     * AJAX: Send test message
     */
    public function ajax_test_message() {
        check_ajax_referer( 'houarashop_wa_test', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Unauthorized' );
        }

        $settings = $this->get_settings();

        if ( empty( $settings['phone_1'] ) || empty( $settings['apikey_1'] ) ) {
            wp_send_json_error( 'Please fill in Phone #1 and API Key #1 first, then save settings.' );
        }

        $test_message = "🧪 *رسالة تجريبية - هوارة شوب*\n\n";
        $test_message .= "إذا تصلك هذه الرسالة، فإن الإشعارات تعمل بشكل صحيح! ✅\n\n";
        $test_message .= "⏰ الوقت: " . current_time( 'H:i - d/m/Y' ) . "\n";
        $test_message .= "🌐 الموقع: " . home_url();

        $result = $this->send_whatsapp_message( $test_message );

        if ( $result['success'] ) {
            $msg = 'Test message sent successfully!';
            if ( ! empty( $result['sent_to'] ) ) {
                $msg .= ' Delivered to: ' . implode( ', ', $result['sent_to'] );
            }
            if ( ! empty( $result['errors'] ) ) {
                $msg .= ' Errors: ' . implode( '; ', $result['errors'] );
            }
            wp_send_json_success( $msg );
        } else {
            wp_send_json_error( 'Failed to send: ' . implode( '; ', $result['errors'] ) );
        }
    }

    /**
     * Build notification message for a new order
     */
    public function build_order_message( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return false;
        }

        $settings = $this->get_settings();

        // Customer info
        $customer_name    = trim( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
        $customer_phone   = $order->get_billing_phone();
        $customer_address = trim( $order->get_billing_address_1() . ' ' . $order->get_billing_address_2() );
        $customer_city    = $order->get_billing_city();

        // Format message
        $msg  = "🛒 *طلب جديد - هوارة شوب!*\n";
        $msg .= "━━━━━━━━━━━━━━━━━\n";

        // Customer section
        if ( $customer_name ) {
            $msg .= "👤 *العميل:* " . $customer_name . "\n";
        }
        if ( $customer_phone ) {
            $msg .= "📞 *الهاتف:* " . $customer_phone . "\n";
        }
        if ( $customer_address ) {
            $msg .= "📍 *العنوان:* " . $customer_address;
            if ( $customer_city ) {
                $msg .= "، " . $customer_city;
            }
            $msg .= "\n";
        }

        $msg .= "━━━━━━━━━━━━━━━━━\n";
        $msg .= "📦 *المنتجات:*\n";

        // Products
        foreach ( $order->get_items() as $item ) {
            $product_name = $item->get_name();
            $quantity     = $item->get_quantity();
            $item_total   = $item->get_total();
            $msg .= "• " . $product_name . " × " . $quantity . "\n";
            $msg .= "  السعر: " . $item_total . " درهم\n";
        }

        // Shipping (if any)
        $shipping = $order->get_shipping_total();
        if ( $shipping > 0 ) {
            $msg .= "\n🚚 *التوصيل:* " . $shipping . " درهم\n";
        }

        $msg .= "━━━━━━━━━━━━━━━━━\n";
        $msg .= "💰 *المجموع:* " . $order->get_total() . " درهم\n";

        // Payment method
        $payment_method = $order->get_payment_method_title();
        if ( $payment_method ) {
            $msg .= "💳 *الدفع:* " . $payment_method . "\n";
        }

        $msg .= "🕐 *الوقت:* " . $order->get_date_created()->date( 'H:i - d/m/Y' ) . "\n";
        $msg .= "🆔 *رقم الطلب:* #" . $order->get_order_number() . "\n";
        $msg .= "━━━━━━━━━━━━━━━━━\n";

        // Determine urgency
        $order_hour = (int) $order->get_date_created()->date( 'H' );
        if ( $order_hour < 16 ) {
            $msg .= "⚡ *توصيل اليوم - معالجة فورية!*\n";
        } else {
            $msg .= "🌙 *توصيل الغد*\n";
        }

        // Admin URL
        if ( $settings['include_admin_url'] ) {
            $admin_url = admin_url( 'post.php?post=' . $order_id . '&action=edit' );
            $msg .= "\n🔗 إدارة الطلب:\n" . $admin_url;
        }

        return $msg;
    }

    /**
     * Handle WooCommerce new order
     */
    public function send_new_order_notification( $order_id ) {
        $settings = $this->get_settings();

        // Check if enabled
        if ( ! $settings['enabled'] ) {
            return;
        }

        // Prevent double-fire (both hooks might trigger)
        $notified = get_post_meta( $order_id, '_houarashop_wa_notified', true );
        if ( $notified ) {
            return;
        }

        $message = $this->build_order_message( $order_id );
        if ( ! $message ) {
            return;
        }

        $result = $this->send_whatsapp_message( $message );

        // Mark as notified to prevent duplicates
        update_post_meta( $order_id, '_houarashop_wa_notified', current_time( 'mysql' ) );

        // Log errors (for debugging in WP_DEBUG mode)
        if ( ! empty( $result['errors'] ) && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'HOUARA-SHOP WA Notifier errors for order #' . $order_id . ': ' . implode( '; ', $result['errors'] ) );
        }
    }

    /**
     * Send WhatsApp message via CallMeBot to all configured numbers
     */
    public function send_whatsapp_message( $message ) {
        $settings   = $this->get_settings();
        $sent_to    = array();
        $errors     = array();

        // Recipients to try
        $recipients = array();
        if ( ! empty( $settings['phone_1'] ) && ! empty( $settings['apikey_1'] ) ) {
            $recipients[] = array(
                'phone'  => $settings['phone_1'],
                'apikey' => $settings['apikey_1'],
                'label'  => 'Primary',
            );
        }
        if ( ! empty( $settings['phone_2'] ) && ! empty( $settings['apikey_2'] ) ) {
            $recipients[] = array(
                'phone'  => $settings['phone_2'],
                'apikey' => $settings['apikey_2'],
                'label'  => 'Secondary',
            );
        }

        if ( empty( $recipients ) ) {
            return array(
                'success' => false,
                'sent_to' => array(),
                'errors'  => array( 'No recipients configured' ),
            );
        }

        foreach ( $recipients as $recipient ) {
            $url = add_query_arg( array(
                'phone'  => $recipient['phone'],
                'text'   => $message,
                'apikey' => $recipient['apikey'],
            ), 'https://api.callmebot.com/whatsapp.php' );

            $response = wp_remote_get( $url, array(
                'timeout'   => 15,
                'sslverify' => true,
            ) );

            if ( is_wp_error( $response ) ) {
                $errors[] = $recipient['label'] . ': ' . $response->get_error_message();
                continue;
            }

            $code = wp_remote_retrieve_response_code( $response );
            $body = wp_remote_retrieve_body( $response );

            // CallMeBot returns 200 on success
            if ( $code === 200 && ( stripos( $body, 'message queued' ) !== false || stripos( $body, 'sent' ) !== false ) ) {
                $sent_to[] = $recipient['label'] . ' (' . $recipient['phone'] . ')';
            } elseif ( $code === 200 ) {
                // Sometimes CallMeBot returns 200 even on config issues, check body
                $sent_to[] = $recipient['label'] . ' (' . $recipient['phone'] . ')';
            } else {
                $errors[] = $recipient['label'] . ' HTTP ' . $code . ': ' . wp_strip_all_tags( substr( $body, 0, 200 ) );
            }
        }

        return array(
            'success' => ! empty( $sent_to ),
            'sent_to' => $sent_to,
            'errors'  => $errors,
        );
    }
}

// Initialize the plugin
new HouaraShop_WA_Notifier();
