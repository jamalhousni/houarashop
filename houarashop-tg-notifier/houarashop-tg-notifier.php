<?php
/**
 * Plugin Name: HOUARA-SHOP Telegram Order Notifier
 * Plugin URI: https://houarashop.com
 * Description: Sends instant Telegram notifications when new orders arrive. Uses official Telegram Bot API (free, reliable).
 * Version: 1.0.1
 * Author: HOUARA-SHOP
 * Text Domain: houarashop-tg-notifier
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 7.0
 * WC tested up to: 9.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HouaraShop_TG_Notifier {

    private $option_key = 'houarashop_tg_notifier_settings';

    public function __construct() {
        // Admin menu + settings
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );

        // ── FIXED: Hook into multiple events to catch order when items are saved ──
        // woocommerce_checkout_order_created fires AFTER items are added (WC 7.0+)
        add_action( 'woocommerce_checkout_order_created', array( $this, 'send_new_order_notification' ), 10, 1 );
        // Fallback: woocommerce_thankyou fires on the thank you page (items DEFINITELY saved)
        add_action( 'woocommerce_thankyou', array( $this, 'send_new_order_notification' ), 10, 1 );
        // Second fallback: woocommerce_new_order with delayed execution
        add_action( 'woocommerce_new_order', array( $this, 'schedule_notification' ), 10, 1 );

        // AJAX test button
        add_action( 'wp_ajax_houarashop_tg_test', array( $this, 'ajax_test_message' ) );
        add_action( 'wp_ajax_houarashop_tg_get_chatid', array( $this, 'ajax_get_chat_id' ) );

        // Admin notice when WooCommerce not active
        add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
    }

    public function woocommerce_missing_notice() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="notice notice-error"><p><strong>HOUARA-SHOP Telegram Notifier:</strong> WooCommerce is not active. Please activate WooCommerce first.</p></div>';
        }
    }

    public function add_admin_menu() {
        add_options_page(
            'Telegram Order Notifier',
            '📬 Telegram Notifier',
            'manage_options',
            'houarashop-tg-notifier',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'houarashop_tg_group', $this->option_key, array(
            'sanitize_callback' => array( $this, 'sanitize_settings' ),
        ) );
    }

    public function sanitize_settings( $input ) {
        $sanitized = array();
        $sanitized['enabled']           = ! empty( $input['enabled'] ) ? 1 : 0;
        $sanitized['bot_token']         = isset( $input['bot_token'] ) ? sanitize_text_field( trim( $input['bot_token'] ) ) : '';
        $sanitized['chat_id_1']         = isset( $input['chat_id_1'] ) ? sanitize_text_field( trim( $input['chat_id_1'] ) ) : '';
        $sanitized['chat_id_2']         = isset( $input['chat_id_2'] ) ? sanitize_text_field( trim( $input['chat_id_2'] ) ) : '';
        $sanitized['include_admin_url'] = ! empty( $input['include_admin_url'] ) ? 1 : 0;
        $sanitized['notify_whatsapp_link'] = ! empty( $input['notify_whatsapp_link'] ) ? 1 : 0;
        return $sanitized;
    }

    public function get_settings() {
        $defaults = array(
            'enabled'              => 0,
            'bot_token'            => '',
            'chat_id_1'            => '',
            'chat_id_2'            => '',
            'include_admin_url'    => 1,
            'notify_whatsapp_link' => 1,
        );
        return wp_parse_args( get_option( $this->option_key, array() ), $defaults );
    }

    public function render_settings_page() {
        $settings = $this->get_settings();
        ?>
        <div class="wrap">
            <h1>📬 Telegram Order Notifier</h1>
            <p>Automatic Telegram notifications when new orders arrive. Powered by the <a href="https://core.telegram.org/bots/api" target="_blank">official Telegram Bot API</a> (free, instant, reliable).</p>

            <div style="background:#e3f2fd;border:1px solid #1976d2;border-radius:8px;padding:20px;margin:20px 0;max-width:900px;">
                <h2 style="margin-top:0;">🚀 Quick Setup (3 minutes)</h2>
                <ol style="line-height:1.9;">
                    <li>Open Telegram, search for <strong>@BotFather</strong> → Start → send <code>/newbot</code></li>
                    <li>Choose a name (e.g., "HOUARA-SHOP Orders") and username (must end with <code>bot</code>)</li>
                    <li>BotFather will give you a <strong>Bot Token</strong> — copy it below</li>
                    <li>Open your new bot, click <strong>Start</strong>, send any message like "hi"</li>
                    <li>Click the <strong>"Fetch My Chat ID"</strong> button below to auto-get your Chat ID</li>
                    <li>Save settings → click <strong>"Send Test Message"</strong></li>
                </ol>
            </div>

            <form method="post" action="options.php">
                <?php settings_fields( 'houarashop_tg_group' ); ?>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="enabled">Enable Notifications</label></th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( $this->option_key ); ?>[enabled]" id="enabled" value="1" <?php checked( 1, $settings['enabled'] ); ?>>
                                <strong>Send Telegram notifications on new orders</strong>
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <h2 style="border-top:1px solid #e0e0e0;padding-top:20px;margin-bottom:0;">🤖 Bot Configuration</h2>
                        </th>
                    </tr>

                    <tr>
                        <th scope="row"><label for="bot_token">Bot Token</label></th>
                        <td>
                            <input type="text" name="<?php echo esc_attr( $this->option_key ); ?>[bot_token]" id="bot_token" value="<?php echo esc_attr( $settings['bot_token'] ); ?>" class="large-text" placeholder="7123456789:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw" />
                            <p class="description">From @BotFather — looks like: <code>1234567890:ABCDEFghijklmnop...</code></p>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <h2 style="border-top:1px solid #e0e0e0;padding-top:20px;margin-bottom:0;">👤 Primary Recipient (Required)</h2>
                        </th>
                    </tr>

                    <tr>
                        <th scope="row"><label for="chat_id_1">Chat ID #1 (You)</label></th>
                        <td>
                            <input type="text" name="<?php echo esc_attr( $this->option_key ); ?>[chat_id_1]" id="chat_id_1" value="<?php echo esc_attr( $settings['chat_id_1'] ); ?>" class="regular-text" placeholder="123456789" />
                            <button type="button" id="houarashop-tg-fetch-btn" class="button" style="margin-right:10px;">🔍 Fetch My Chat ID</button>
                            <p class="description">Click the button above after you've sent a message to your bot. Can be a personal ID, group ID, or channel ID.</p>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <h2 style="border-top:1px solid #e0e0e0;padding-top:20px;margin-bottom:0;">👥 Secondary Recipient (Optional)</h2>
                            <p style="font-weight:normal;color:#666;">For Nourdin, a second team member, or a channel/group</p>
                        </th>
                    </tr>

                    <tr>
                        <th scope="row"><label for="chat_id_2">Chat ID #2</label></th>
                        <td>
                            <input type="text" name="<?php echo esc_attr( $this->option_key ); ?>[chat_id_2]" id="chat_id_2" value="<?php echo esc_attr( $settings['chat_id_2'] ); ?>" class="regular-text" placeholder="(optional - e.g., -100123456789 for group)" />
                            <p class="description">Leave empty if not needed. For <strong>groups</strong>, the ID starts with <code>-100</code> (negative).</p>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <h2 style="border-top:1px solid #e0e0e0;padding-top:20px;margin-bottom:0;">⚙️ Options</h2>
                        </th>
                    </tr>

                    <tr>
                        <th scope="row"><label for="include_admin_url">Admin Link</label></th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( $this->option_key ); ?>[include_admin_url]" id="include_admin_url" value="1" <?php checked( 1, $settings['include_admin_url'] ); ?>>
                                Include a "Manage Order" button in notifications
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="notify_whatsapp_link">WhatsApp Quick-Reply</label></th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr( $this->option_key ); ?>[notify_whatsapp_link]" id="notify_whatsapp_link" value="1" <?php checked( 1, $settings['notify_whatsapp_link'] ); ?>>
                                Include a "Contact Customer on WhatsApp" button in notifications
                            </label>
                        </td>
                    </tr>
                </table>

                <?php submit_button( 'Save Settings' ); ?>
            </form>

            <hr style="margin:30px 0;">

            <div style="background:#f0f6fc;border:1px solid #0073aa;border-radius:8px;padding:20px;max-width:900px;">
                <h2 style="margin-top:0;">🧪 Send Test Message</h2>
                <p>Make sure you've saved settings first, then click below to send a test.</p>
                <button type="button" id="houarashop-tg-test-btn" class="button button-primary button-large">
                    📤 Send Test Message
                </button>
                <div id="houarashop-tg-test-result" style="margin-top:15px;"></div>
            </div>

            <script>
            jQuery(document).ready(function($) {
                $('#houarashop-tg-test-btn').on('click', function() {
                    var $btn = $(this);
                    var $result = $('#houarashop-tg-test-result');
                    $btn.prop('disabled', true).text('⏳ Sending...');
                    $result.html('');

                    $.post(ajaxurl, {
                        action: 'houarashop_tg_test',
                        nonce: '<?php echo wp_create_nonce( 'houarashop_tg_test' ); ?>'
                    }, function(response) {
                        if (response.success) {
                            $result.html('<div style="padding:12px;background:#d4edda;border:1px solid #28a745;border-radius:4px;color:#155724;">✅ ' + response.data + '</div>');
                        } else {
                            $result.html('<div style="padding:12px;background:#f8d7da;border:1px solid #dc3545;border-radius:4px;color:#721c24;">❌ ' + response.data + '</div>');
                        }
                        $btn.prop('disabled', false).text('📤 Send Test Message');
                    }).fail(function() {
                        $result.html('<div style="padding:12px;background:#f8d7da;border:1px solid #dc3545;border-radius:4px;color:#721c24;">❌ Request failed.</div>');
                        $btn.prop('disabled', false).text('📤 Send Test Message');
                    });
                });

                $('#houarashop-tg-fetch-btn').on('click', function() {
                    var token = $('#bot_token').val().trim();
                    if (!token) {
                        alert('Please enter your Bot Token first!');
                        return;
                    }

                    var $btn = $(this);
                    $btn.prop('disabled', true).text('⏳ Fetching...');

                    $.post(ajaxurl, {
                        action: 'houarashop_tg_get_chatid',
                        token: token,
                        nonce: '<?php echo wp_create_nonce( 'houarashop_tg_get_chatid' ); ?>'
                    }, function(response) {
                        if (response.success) {
                            if (response.data.chat_ids && response.data.chat_ids.length > 0) {
                                var chatList = response.data.chat_ids;
                                if (chatList.length === 1) {
                                    $('#chat_id_1').val(chatList[0].id);
                                    alert('✅ Found! Chat ID: ' + chatList[0].id + '\nName: ' + chatList[0].name + '\n\nSettings will auto-fill. Click "Save Settings" below.');
                                } else {
                                    var msg = '📋 Found ' + chatList.length + ' chats:\n\n';
                                    chatList.forEach(function(c, i) {
                                        msg += (i+1) + '. ' + c.name + ' → ID: ' + c.id + '\n';
                                    });
                                    msg += '\nPaste the one you want into the field manually.';
                                    alert(msg);
                                }
                            } else {
                                alert('⚠️ No messages found!\n\nPlease:\n1. Open your bot in Telegram\n2. Send it any message (like "hi")\n3. Try this button again');
                            }
                        } else {
                            alert('❌ Error: ' + response.data);
                        }
                        $btn.prop('disabled', false).text('🔍 Fetch My Chat ID');
                    }).fail(function() {
                        alert('❌ Request failed. Check your bot token.');
                        $btn.prop('disabled', false).text('🔍 Fetch My Chat ID');
                    });
                });
            });
            </script>

            <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:15px;margin-top:30px;max-width:900px;">
                <h3 style="margin-top:0;">💡 Pro Tip: Team Group</h3>
                <p style="margin-bottom:0;">Create a Telegram <strong>group</strong> with you + Nourdin + family, add your bot to it, make the bot an <strong>admin</strong>, then use the group's Chat ID instead of a personal one. Everyone gets notified simultaneously! Group IDs start with <code>-100...</code></p>
            </div>
        </div>
        <?php
    }

    /**
     * AJAX: Fetch chat ID from getUpdates
     */
    public function ajax_get_chat_id() {
        check_ajax_referer( 'houarashop_tg_get_chatid', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Unauthorized' );
        }

        $token = isset( $_POST['token'] ) ? sanitize_text_field( $_POST['token'] ) : '';
        if ( empty( $token ) ) {
            wp_send_json_error( 'Bot token is required' );
        }

        $url = 'https://api.telegram.org/bot' . $token . '/getUpdates';
        $response = wp_remote_get( $url, array( 'timeout' => 15 ) );

        if ( is_wp_error( $response ) ) {
            wp_send_json_error( 'Network error: ' . $response->get_error_message() );
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( empty( $data['ok'] ) ) {
            wp_send_json_error( 'Invalid bot token or Telegram API error: ' . ( isset( $data['description'] ) ? $data['description'] : 'Unknown' ) );
        }

        $chats = array();
        if ( ! empty( $data['result'] ) ) {
            foreach ( $data['result'] as $update ) {
                if ( ! empty( $update['message']['chat'] ) ) {
                    $chat = $update['message']['chat'];
                    $chat_id = $chat['id'];
                    if ( ! isset( $chats[ $chat_id ] ) ) {
                        $name = '';
                        if ( isset( $chat['title'] ) ) {
                            $name = $chat['title'] . ' (group)';
                        } elseif ( isset( $chat['first_name'] ) ) {
                            $name = trim( $chat['first_name'] . ' ' . ( isset( $chat['last_name'] ) ? $chat['last_name'] : '' ) );
                        } elseif ( isset( $chat['username'] ) ) {
                            $name = '@' . $chat['username'];
                        } else {
                            $name = 'Chat #' . $chat_id;
                        }
                        $chats[ $chat_id ] = array(
                            'id'   => $chat_id,
                            'name' => $name,
                        );
                    }
                }
            }
        }

        wp_send_json_success( array( 'chat_ids' => array_values( $chats ) ) );
    }

    /**
     * AJAX: Send test message
     */
    public function ajax_test_message() {
        check_ajax_referer( 'houarashop_tg_test', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Unauthorized' );
        }

        $settings = $this->get_settings();

        if ( empty( $settings['bot_token'] ) || empty( $settings['chat_id_1'] ) ) {
            wp_send_json_error( 'Please fill in Bot Token and Chat ID #1 first, then save settings.' );
        }

        $test_message  = "🧪 <b>رسالة تجريبية - هوارة شوب</b>\n\n";
        $test_message .= "إذا تصلك هذه الرسالة، فإن الإشعارات تعمل بشكل صحيح! ✅\n\n";
        $test_message .= "⏰ <b>الوقت:</b> " . current_time( 'H:i - d/m/Y' ) . "\n";
        $test_message .= "🌐 <b>الموقع:</b> " . home_url();

        $result = $this->send_telegram_message( $test_message );

        if ( $result['success'] ) {
            $msg = 'Test message sent successfully!';
            if ( ! empty( $result['sent_to'] ) ) {
                $msg .= ' Delivered to: ' . implode( ', ', $result['sent_to'] );
            }
            if ( ! empty( $result['errors'] ) ) {
                $msg .= ' Some errors: ' . implode( '; ', $result['errors'] );
            }
            wp_send_json_success( $msg );
        } else {
            wp_send_json_error( 'Failed: ' . implode( '; ', $result['errors'] ) );
        }
    }

    /**
     * Build notification message for a new order
     * FIXED: Now reads items properly and handles empty item case defensively
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

        $msg  = "🛒 <b>طلب جديد - هوارة شوب!</b>\n";
        $msg .= "━━━━━━━━━━━━━━━━━\n";

        if ( $customer_name ) {
            $msg .= "👤 <b>العميل:</b> " . esc_html( $customer_name ) . "\n";
        }
        if ( $customer_phone ) {
            $msg .= "📞 <b>الهاتف:</b> <code>" . esc_html( $customer_phone ) . "</code>\n";
        }
        if ( $customer_address ) {
            $msg .= "📍 <b>العنوان:</b> " . esc_html( $customer_address );
            if ( $customer_city ) {
                $msg .= "، " . esc_html( $customer_city );
            }
            $msg .= "\n";
        }

        $msg .= "━━━━━━━━━━━━━━━━━\n";
        $msg .= "📦 <b>المنتجات:</b>\n";

        // ── FIXED: Get items using line_item filter, with fallback ──
        $items = $order->get_items( 'line_item' );
        
        if ( ! empty( $items ) ) {
            foreach ( $items as $item_id => $item ) {
                $product_name = $item->get_name();
                $quantity     = $item->get_quantity();
                $item_total   = $item->get_total();
                
                // Try to get product to access more info if needed
                $product = $item->get_product();
                if ( ! $product_name && $product ) {
                    $product_name = $product->get_name();
                }
                
                $msg .= "• " . esc_html( $product_name ?: 'منتج' ) . " × " . $quantity . "\n";
                $msg .= "  <i>السعر: " . number_format( (float) $item_total, 2 ) . " درهم</i>\n";
            }
        } else {
            // Fallback: try getting items via WC directly
            $order = wc_get_order( $order_id ); // Re-fetch
            $items_retry = $order->get_items();
            if ( ! empty( $items_retry ) ) {
                foreach ( $items_retry as $item ) {
                    $msg .= "• " . esc_html( $item->get_name() ) . " × " . $item->get_quantity() . "\n";
                    $msg .= "  <i>السعر: " . number_format( (float) $item->get_total(), 2 ) . " درهم</i>\n";
                }
            } else {
                $msg .= "<i>(جار تحميل تفاصيل المنتجات...)</i>\n";
            }
        }

        $shipping = $order->get_shipping_total();
        if ( $shipping > 0 ) {
            $msg .= "\n🚚 <b>التوصيل:</b> " . $shipping . " درهم\n";
        }

        $msg .= "━━━━━━━━━━━━━━━━━\n";
        $msg .= "💰 <b>المجموع:</b> " . $order->get_total() . " درهم\n";

        $payment_method = $order->get_payment_method_title();
        if ( $payment_method ) {
            $msg .= "💳 <b>الدفع:</b> " . esc_html( $payment_method ) . "\n";
        }

        $msg .= "🕐 <b>الوقت:</b> " . $order->get_date_created()->date( 'H:i - d/m/Y' ) . "\n";
        $msg .= "🆔 <b>رقم الطلب:</b> #" . $order->get_order_number() . "\n";
        $msg .= "━━━━━━━━━━━━━━━━━\n";

        $order_hour = (int) $order->get_date_created()->date( 'H' );
        if ( $order_hour < 16 ) {
            $msg .= "⚡ <b>توصيل اليوم - معالجة فورية!</b>\n";
        } else {
            $msg .= "🌙 <b>توصيل الغد</b>\n";
        }

        return $msg;
    }

    /**
     * Build inline keyboard for order
     */
    public function build_order_keyboard( $order_id ) {
        $settings = $this->get_settings();
        $order    = wc_get_order( $order_id );
        if ( ! $order ) {
            return null;
        }

        $buttons = array();

        if ( $settings['include_admin_url'] ) {
            $admin_url = admin_url( 'post.php?post=' . $order_id . '&action=edit' );
            $buttons[] = array( array(
                'text' => '📋 إدارة الطلب',
                'url'  => $admin_url,
            ) );
        }

        if ( $settings['notify_whatsapp_link'] ) {
            $customer_phone = $order->get_billing_phone();
            if ( $customer_phone ) {
                $customer_name = trim( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
                $clean_phone = preg_replace( '/[^0-9]/', '', $customer_phone );
                if ( strlen( $clean_phone ) === 10 && substr( $clean_phone, 0, 1 ) === '0' ) {
                    $clean_phone = '212' . substr( $clean_phone, 1 );
                } elseif ( strlen( $clean_phone ) === 9 ) {
                    $clean_phone = '212' . $clean_phone;
                }
                $greeting = urlencode( "مرحبا " . $customer_name . "،\n\nنحن من هوارة شوب بخصوص طلبك #" . $order->get_order_number() );
                $wa_url = 'https://wa.me/' . $clean_phone . '?text=' . $greeting;
                $buttons[] = array( array(
                    'text' => '💬 تواصل مع العميل',
                    'url'  => $wa_url,
                ) );
            }
        }

        if ( empty( $buttons ) ) {
            return null;
        }

        return array( 'inline_keyboard' => $buttons );
    }

    /**
     * Schedule notification via WP-Cron (fallback for woocommerce_new_order)
     * Waits 3 seconds for items to be saved, then sends
     */
    public function schedule_notification( $order_id ) {
        // Check if already notified via primary hooks — skip if so
        $notified = get_post_meta( $order_id, '_houarashop_tg_notified', true );
        if ( $notified ) {
            return;
        }

        // Schedule a delayed send as a fallback (3 seconds later)
        if ( ! wp_next_scheduled( 'houarashop_tg_delayed_send', array( $order_id ) ) ) {
            wp_schedule_single_event( time() + 3, 'houarashop_tg_delayed_send', array( $order_id ) );
        }
    }

    /**
     * Handle WooCommerce new order notification
     */
    public function send_new_order_notification( $order_id ) {
        $settings = $this->get_settings();

        if ( ! $settings['enabled'] ) {
            return;
        }

        // Prevent duplicate sends
        $notified = get_post_meta( $order_id, '_houarashop_tg_notified', true );
        if ( $notified ) {
            return;
        }

        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return;
        }

        // Skip notifying for orders that still have NO items (items aren't saved yet)
        // The fallback cron job will catch these later
        $items = $order->get_items();
        if ( empty( $items ) ) {
            return;
        }

        $message  = $this->build_order_message( $order_id );
        $keyboard = $this->build_order_keyboard( $order_id );
        if ( ! $message ) {
            return;
        }

        $result = $this->send_telegram_message( $message, $keyboard );

        update_post_meta( $order_id, '_houarashop_tg_notified', current_time( 'mysql' ) );

        if ( ! empty( $result['errors'] ) && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'HOUARA-SHOP TG Notifier errors for order #' . $order_id . ': ' . implode( '; ', $result['errors'] ) );
        }
    }

    /**
     * Send Telegram message via Bot API
     */
    public function send_telegram_message( $message, $keyboard = null ) {
        $settings = $this->get_settings();
        $sent_to  = array();
        $errors   = array();

        if ( empty( $settings['bot_token'] ) ) {
            return array(
                'success' => false,
                'sent_to' => array(),
                'errors'  => array( 'Bot token not configured' ),
            );
        }

        $recipients = array();
        if ( ! empty( $settings['chat_id_1'] ) ) {
            $recipients[] = array( 'chat_id' => $settings['chat_id_1'], 'label' => 'Primary' );
        }
        if ( ! empty( $settings['chat_id_2'] ) ) {
            $recipients[] = array( 'chat_id' => $settings['chat_id_2'], 'label' => 'Secondary' );
        }

        if ( empty( $recipients ) ) {
            return array(
                'success' => false,
                'sent_to' => array(),
                'errors'  => array( 'No recipients configured' ),
            );
        }

        $url = 'https://api.telegram.org/bot' . $settings['bot_token'] . '/sendMessage';

        foreach ( $recipients as $recipient ) {
            $payload = array(
                'chat_id'    => $recipient['chat_id'],
                'text'       => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            );

            if ( $keyboard ) {
                $payload['reply_markup'] = wp_json_encode( $keyboard );
            }

            $response = wp_remote_post( $url, array(
                'timeout'   => 15,
                'sslverify' => true,
                'body'      => $payload,
            ) );

            if ( is_wp_error( $response ) ) {
                $errors[] = $recipient['label'] . ': ' . $response->get_error_message();
                continue;
            }

            $code = wp_remote_retrieve_response_code( $response );
            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body, true );

            if ( $code === 200 && ! empty( $data['ok'] ) ) {
                $sent_to[] = $recipient['label'] . ' (' . $recipient['chat_id'] . ')';
            } else {
                $desc = isset( $data['description'] ) ? $data['description'] : 'HTTP ' . $code;
                $errors[] = $recipient['label'] . ': ' . $desc;
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
new HouaraShop_TG_Notifier();

// Register the delayed cron action (fallback)
add_action( 'houarashop_tg_delayed_send', function( $order_id ) {
    $notifier = new HouaraShop_TG_Notifier();
    $notifier->send_new_order_notification( $order_id );
}, 10, 1 );
