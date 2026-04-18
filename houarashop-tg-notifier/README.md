# HOUARA-SHOP Telegram Order Notifier

Instant Telegram notifications for new WooCommerce orders. Uses the **official Telegram Bot API** — fast, free, reliable.

## Why Telegram?

- ⚡ **Instant delivery** (1-2 seconds, official API)
- 🆓 **100% free forever** (not a third-party workaround)
- 👥 **Group notifications** — add whole team to one group
- 🔘 **Action buttons** — tap to open admin, tap to WhatsApp customer
- 📱 **Rich formatting** — bold, links, beautiful layout
- 🛡️ **No spam risk** — official API, won't get blocked

## Features

- 📬 Automatic notification on every new order
- 👥 Up to 2 recipients (personal chats, groups, or channels)
- 🎨 Beautifully formatted Arabic messages with order details
- ⚡ Smart urgency detection (before 4PM = "توصيل اليوم")
- 🔘 One-tap buttons: Manage order, WhatsApp customer
- 🔍 Auto-fetch Chat ID button (no manual JSON parsing!)
- 🧪 Test message button
- 🔒 Prevents duplicate notifications

## Installation

1. Upload `houarashop-tg-notifier` folder to `/wp-content/plugins/`
2. Activate the plugin in WordPress Admin → Plugins
3. Go to **Settings → 📬 Telegram Notifier**

## Setup (3 minutes)

### 1. Create a Bot
- Open Telegram → search **@BotFather** → Start
- Send `/newbot`
- Pick a name: `HOUARA-SHOP Orders`
- Pick a username ending in `bot`: `houarashop_orders_bot`
- Copy the **Bot Token** it gives you

### 2. Get Your Chat ID
- Open your new bot, click **Start**
- Send any message (like "hi")
- Go back to the plugin settings
- Paste Bot Token, then click **"🔍 Fetch My Chat ID"** button
- Chat ID auto-fills!

### 3. Save & Test
- Enable notifications
- Save settings
- Click **"📤 Send Test Message"**
- You should receive the message in Telegram within seconds

## Pro Tip: Team Group Notifications

1. Create a Telegram group: "HOUARA-SHOP Orders"
2. Add Nourdin, your cousin, and anyone else
3. Add your bot to the group
4. Make the bot an **admin**
5. Send a message in the group mentioning the bot
6. Click "Fetch My Chat ID" — you'll see the group ID (starts with `-100`)
7. Use that as Chat ID — the whole team gets notified!

## Message Preview

```
🛒 طلب جديد - هوارة شوب!
━━━━━━━━━━━━━━━━━
👤 العميل: أحمد بن علي
📞 الهاتف: 0612345678
📍 العنوان: حي السلام، أولاد تايمة
━━━━━━━━━━━━━━━━━
📦 المنتجات:
• قاطعة الخضروات × 1
  السعر: 79 درهم
━━━━━━━━━━━━━━━━━
💰 المجموع: 79 درهم
💳 الدفع: الدفع عند الاستلام
🕐 الوقت: 14:35 - 17/04/2026
🆔 رقم الطلب: #123
━━━━━━━━━━━━━━━━━
⚡ توصيل اليوم - معالجة فورية!

[📋 إدارة الطلب] [💬 تواصل مع العميل]
```

## Requirements

- WordPress 5.8+
- PHP 7.4+
- WooCommerce 7.0+
- Telegram account

## License

Built for HOUARA-SHOP. Free to modify for personal use.
