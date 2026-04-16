<?php
/**
 * Template Name: HOUARA-SHOP My Account
 * Description: Styled My Account page for houarashop.com
 */

if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حسابي — هوارة شوب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background: #f5f5f5;
            color: #333;
        }

        a { text-decoration: none; color: inherit; }

        /* ========== COUNTDOWN BAR ========== */
        .countdown-bar {
            background: #FF6B00;
            padding: 10px 20px;
            text-align: center;
        }
        .countdown-bar p {
            color: #fff;
            font-size: 15px;
            font-weight: 700;
        }
        .countdown-bar span#timer {
            color: #FFE000;
            font-weight: 900;
            direction: ltr;
            display: inline-block;
        }

        /* ========== HEADER ========== */
        .site-header {
            background: #1A1A2E;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .logo { color: #fff; font-size: 24px; font-weight: 900; }
        .logo span { color: #FF6B00; }
        .header-nav { display: flex; gap: 20px; align-items: center; }
        .header-nav a { color: #ccc; font-size: 15px; font-weight: 600; transition: color 0.2s; }
        .header-nav a:hover, .header-nav a.active { color: #FF6B00; }
        .header-cart {
            background: #FF6B00;
            color: #fff;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 15px;
        }

        /* ========== PAGE WRAPPER ========== */
        .page-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 25px;
        }

        /* ========== SIDEBAR ========== */
        .account-sidebar {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0,0,0,0.07);
            height: fit-content;
        }

        .sidebar-header {
            background: #1A1A2E;
            padding: 25px 20px;
            text-align: center;
        }

        .sidebar-avatar {
            width: 70px;
            height: 70px;
            background: #FF6B00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 12px;
        }

        .sidebar-name {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
        }

        .sidebar-email {
            color: #aab4c8;
            font-size: 13px;
        }

        .sidebar-nav {
            padding: 10px 0;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            color: #555;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s;
            border-right: 3px solid transparent;
        }

        .sidebar-nav a:hover {
            background: #fff8f5;
            color: #FF6B00;
            border-right-color: #FF6B00;
        }

        .sidebar-nav a.active {
            background: #fff8f5;
            color: #FF6B00;
            border-right-color: #FF6B00;
        }

        .sidebar-nav .icon { font-size: 18px; }

        .sidebar-nav .logout-link {
            color: #e74c3c;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
        }

        .sidebar-nav .logout-link:hover {
            background: #fff5f5;
            color: #c0392b;
            border-right-color: #e74c3c;
        }

        /* ========== MAIN CONTENT ========== */
        .account-main {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.07);
        }

        .account-main h2 {
            font-size: 22px;
            font-weight: 900;
            color: #1A1A2E;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* WooCommerce overrides */
        .woocommerce-MyAccount-content {
            font-family: 'Cairo', sans-serif !important;
        }

        .woocommerce-MyAccount-content p {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            margin-bottom: 15px;
        }

        .woocommerce table.shop_table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Cairo', sans-serif;
        }

        .woocommerce table.shop_table th {
            background: #1A1A2E;
            color: #fff;
            padding: 12px 15px;
            font-size: 14px;
            font-weight: 700;
            text-align: right;
        }

        .woocommerce table.shop_table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #444;
        }

        .woocommerce table.shop_table tr:hover td {
            background: #fafafa;
        }

        .woocommerce-orders-table__cell-order-status mark {
            background: none;
            font-weight: 700;
        }

        .woocommerce-orders-table__cell-order-status mark.processing {
            color: #FF6B00;
        }

        .woocommerce-orders-table__cell-order-status mark.completed {
            color: #27AE60;
        }

        /* Forms */
        .woocommerce form .form-row {
            margin-bottom: 20px;
        }

        .woocommerce form .form-row label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #444;
            margin-bottom: 6px;
        }

        .woocommerce form input[type="text"],
        .woocommerce form input[type="email"],
        .woocommerce form input[type="password"],
        .woocommerce form input[type="tel"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Cairo', sans-serif;
            font-size: 15px;
            transition: border-color 0.2s;
        }

        .woocommerce form input:focus {
            outline: none;
            border-color: #FF6B00;
        }

        .woocommerce form .button,
        .woocommerce button[type="submit"] {
            background: #FF6B00 !important;
            color: #fff !important;
            padding: 13px 35px !important;
            border: none !important;
            border-radius: 8px !important;
            font-family: 'Cairo', sans-serif !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            transition: background 0.2s !important;
        }

        .woocommerce form .button:hover,
        .woocommerce button[type="submit"]:hover {
            background: #e55f00 !important;
        }

        /* Login/Register forms */
        .woocommerce-form-login,
        .woocommerce-form-register {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .woocommerce-form-login h2,
        .woocommerce-form-register h2 {
            font-size: 20px;
            font-weight: 900;
            color: #1A1A2E;
            margin-bottom: 20px;
            border: none;
            padding: 0;
        }

        /* Empty orders */
        .woocommerce-message {
            background: #fff8f5;
            border-right: 4px solid #FF6B00;
            padding: 15px 20px;
            border-radius: 8px;
            color: #555;
            font-size: 15px;
        }

        .woocommerce-message a.button {
            background: #FF6B00 !important;
            color: #fff !important;
            padding: 10px 25px !important;
            border-radius: 6px !important;
            font-family: 'Cairo', sans-serif !important;
            font-weight: 700 !important;
        }

        /* ========== FOOTER ========== */
        .site-footer {
            background: #111122;
            padding: 30px 40px;
            text-align: center;
            margin-top: 60px;
        }
        .footer-logo { color: #fff; font-size: 20px; font-weight: 900; margin-bottom: 8px; }
        .footer-logo span { color: #FF6B00; }
        .footer-copy { color: #555; font-size: 13px; }

        /* Mobile */
        @media (max-width: 768px) {
            .page-wrapper {
                grid-template-columns: 1fr;
            }
            .site-header { padding: 12px 20px; }
            .header-nav { display: none; }
            .account-main { padding: 20px; }
        }
    </style>
</head>
<body>

<!-- COUNTDOWN BAR -->
<div class="countdown-bar">
    <p>
        <span id="promo-text-today" style="display:none;">🚚 اطلب قبل 04:00 مساءاً ليصلك طلبك اليوم - التوصيل داخل مدينة أولاد تايمة &nbsp;&nbsp; ⏱️ الوقت المتبقي: <span id="timer"></span></span>
        <span id="promo-text-tomorrow" style="display:none;">🚀 اطلب الآن لضمان توصيل طلبك خلال 24 ساعة - التوصيل داخل مدينة أولاد تايمة</span>
    </p>
</div>

<!-- HEADER -->
<header class="site-header">
    <div class="logo">هوارة <span>شوب</span></div>
    <nav class="header-nav">
        <a href="<?php echo home_url('/'); ?>">الرئيسية</a>
        <a href="<?php echo home_url('/matjar/'); ?>">المتجر</a>
        <a href="<?php echo home_url('/contact/'); ?>">تواصل معنا</a>
        <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>" class="active">حسابي</a>
    </nav>
    <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="header-cart">
        🛒 السلة (<?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?>)
    </a>
</header>

<!-- MAIN PAGE -->
<div class="page-wrapper">

    <!-- SIDEBAR -->
    <aside class="account-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-avatar">👤</div>
            <?php if (is_user_logged_in()) :
                $current_user = wp_get_current_user();
            ?>
                <div class="sidebar-name"><?php echo esc_html($current_user->display_name); ?></div>
                <div class="sidebar-email"><?php echo esc_html($current_user->user_email); ?></div>
            <?php else : ?>
                <div class="sidebar-name">مرحباً بك!</div>
                <div class="sidebar-email">سجل دخولك لمتابعة طلباتك</div>
            <?php endif; ?>
        </div>

        <nav class="sidebar-nav">
            <a href="<?php echo wc_get_account_endpoint_url('dashboard'); ?>">
                <span class="icon">🏠</span> لوحة التحكم
            </a>
            <a href="<?php echo wc_get_account_endpoint_url('orders'); ?>">
                <span class="icon">📦</span> طلباتي
            </a>
            <a href="<?php echo wc_get_account_endpoint_url('edit-address'); ?>">
                <span class="icon">📍</span> عناويني
            </a>
            <a href="<?php echo wc_get_account_endpoint_url('edit-account'); ?>">
                <span class="icon">⚙️</span> تفاصيل الحساب
            </a>
            <?php if (is_user_logged_in()) : ?>
            <a href="<?php echo wc_logout_url(home_url()); ?>" class="logout-link">
                <span class="icon">🚪</span> تسجيل الخروج
            </a>
            <?php endif; ?>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="account-main">
        <h2>
            <?php
            $endpoint = WC()->query->get_current_endpoint();
            $titles = [
                'orders'       => '📦 طلباتي',
                'edit-address' => '📍 عناويني',
                'edit-account' => '⚙️ تفاصيل الحساب',
                'downloads'    => '⬇️ تنزيلاتي',
            ];
            echo isset($titles[$endpoint]) ? $titles[$endpoint] : '🏠 لوحة التحكم';
            ?>
        </h2>

        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </main>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="footer-logo">هوارة <span>شوب</span></div>
    <p class="footer-copy">© <?php echo date('Y'); ?> هوارة شوب — جميع الحقوق محفوظة</p>
</footer>

<!-- COUNTDOWN SCRIPT -->
<script>
function updateTimer() {
    var now = new Date(), cutoff = new Date(), isPastCutoff = false;
    cutoff.setHours(16, 0, 0, 0);
    if (now >= cutoff) {
        cutoff.setDate(cutoff.getDate() + 1);
        isPastCutoff = true;
    }
    
    var txtToday = document.getElementById('promo-text-today');
    var txtTomorrow = document.getElementById('promo-text-tomorrow');
    if (txtToday && txtTomorrow) {
        if (isPastCutoff) {
            txtToday.style.display = 'none';
            txtTomorrow.style.display = 'inline';
        } else {
            txtToday.style.display = 'inline';
            txtTomorrow.style.display = 'none';
        }
    }

    var diff = cutoff - now;
    var h = Math.floor(diff / 3600000);
    var m = Math.floor((diff % 3600000) / 60000);
    var timerEl = document.getElementById('timer');
    if(timerEl) { timerEl.innerHTML = h + ' h ' + m + ' m'; }
}
updateTimer();
setInterval(updateTimer, 60000);
</script>

<?php wp_footer(); ?>
</body>
</html>
