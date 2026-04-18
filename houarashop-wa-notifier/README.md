# HOUARA-SHOP WhatsApp Order Notifier

Instant WhatsApp notifications for new WooCommerce orders using CallMeBot (free API).

## Features

- 📱 Instant WhatsApp notifications on new orders
- 👥 Supports 2 recipients (you + backup like Nourdin)
- 🎨 Beautiful Arabic message formatting with order details
- ⚡ Smart urgency detection (before 4PM = same-day delivery)
- 🔗 Direct admin link to manage orders
- 🧪 Built-in test button
- 🔒 Prevents duplicate notifications
- ⚙️ Easy settings page in WP Admin

## Installation

1. Upload the `houarashop-wa-notifier` folder to `/wp-content/plugins/`
2. Activate the plugin in WordPress Admin → Plugins
3. Go to **Settings → 📱 WhatsApp Notifier**

## Setup CallMeBot (Free API)

1. Save `+34 644 51 95 23` in your WhatsApp contacts
2. Send the message: `I allow callmebot to send me messages`
3. Wait for reply with your API key
4. Enter your phone + API key in the plugin settings
5. Enable notifications
6. Click "Send Test Message" to verify

## Message Format

```
🛒 *طلب جديد - هوارة شوب!*
━━━━━━━━━━━━━━━━━
👤 *العميل:* أحمد بن علي
📞 *الهاتف:* 0612345678
📍 *العنوان:* حي السلام، أولاد تايمة
━━━━━━━━━━━━━━━━━
📦 *المنتجات:*
• قاطعة الخضروات × 1
  السعر: 79 درهم
━━━━━━━━━━━━━━━━━
💰 *المجموع:* 79 درهم
💳 *الدفع:* عند الاستلام
🕐 *الوقت:* 14:35 - 17/04/2026
🆔 *رقم الطلب:* #123
━━━━━━━━━━━━━━━━━
⚡ *توصيل اليوم - معالجة فورية!*

🔗 إدارة الطلب:
houarashop.com/wp-admin/post.php?post=123&action=edit
```

## Requirements

- WordPress 5.8+
- PHP 7.4+
- WooCommerce 7.0+
- CallMeBot API key (free)

## License

Built for HOUARA-SHOP. Free to modify for personal use.
