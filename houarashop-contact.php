<?php
/**
 * Template Name: HOUARA Contact
 * Description: صفحة تواصل معنا
 */
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تواصل معنا — هوارة شوب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', sans-serif; direction: rtl; background: #fff; color: #333; }
        a { text-decoration: none; color: inherit; }

        /* COUNTDOWN BAR */
        .countdown-bar { background: #FF6B00; padding: 12px 20px; text-align: center; position: sticky; top: 0; z-index: 1000; }
        .countdown-bar p { color: #fff; font-size: 15px; font-weight: 700; }
        #timer { color: #FFE000; font-weight: 900; direction: ltr; display: inline-block; }

        /* HEADER */
        .site-header { background: #1A1A2E; padding: 15px 40px; display: flex; align-items: center; justify-content: space-between; }
        .logo { color: #fff; font-size: 26px; font-weight: 900; }
        .logo span { color: #FF6B00; }
        .header-nav { display: flex; gap: 20px; align-items: center; }
        .header-nav a { color: #ccc; font-size: 15px; font-weight: 600; transition: color 0.2s; }
        .header-nav a:hover { color: #FF6B00; }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-cart { background: #FF6B00; color: #fff; padding: 8px 20px; border-radius: 25px; font-weight: 700; font-size: 15px; }
        .header-right-mobile { display: flex; align-items: center; gap: 15px; }

        /* HAMBURGER */
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; padding: 5px; }
        .hamburger span { display: block; width: 25px; height: 3px; background: #fff; border-radius: 3px; }

        /* MOBILE NAV */
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; }
        .overlay.open { display: block; }
        .mobile-nav { display: none; position: fixed; top: 0; right: 0; width: 280px; height: 100%; background: #1A1A2E; z-index: 9999; padding: 20px; box-shadow: -5px 0 20px rgba(0,0,0,0.3); transform: translateX(100%); transition: transform 0.3s; overflow-y: auto; }
        .mobile-nav.open { transform: translateX(0); }
        .mobile-nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .mobile-nav-logo { color: #fff; font-size: 20px; font-weight: 900; }
        .mobile-nav-logo span { color: #FF6B00; }
        .close-nav { color: #fff; font-size: 24px; cursor: pointer; background: none; border: none; }
        .mobile-nav a { display: block; color: #ccc; font-size: 16px; font-weight: 600; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .mobile-nav a:hover { color: #FF6B00; }
        .mobile-nav-cart { margin-top: 20px; background: #FF6B00 !important; color: #fff !important; padding: 14px 20px !important; border-radius: 8px; text-align: center; font-weight: 700 !important; border: none !important; }

        /* HERO */
        .hero { background: linear-gradient(135deg, #1A1A2E 0%, #16213e 60%, #0f3460 100%); min-height: 550px; display: flex; align-items: center; justify-content: center; text-align: center; padding: 60px 20px; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,107,0,0.08) 0%, transparent 60%); }
        .hero-content { position: relative; z-index: 1; max-width: 700px; }
        .hero-badge { background: rgba(255,107,0,0.15); border: 1px solid rgba(255,107,0,0.3); color: #FF6B00; padding: 6px 20px; border-radius: 25px; font-size: 14px; font-weight: 700; display: inline-block; margin-bottom: 20px; }
        .hero h1 { color: #fff; font-size: 48px; font-weight: 900; line-height: 1.3; margin-bottom: 20px; }
        .hero h1 span { color: #FF6B00; }
        .hero p { color: #aab4c8; font-size: 18px; font-weight: 600; margin-bottom: 35px; line-height: 1.7; }
        .hero-buttons { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
        .btn-primary { background: #FF6B00; color: #fff; padding: 16px 40px; border-radius: 8px; font-size: 17px; font-weight: 700; font-family: 'Cairo', sans-serif; border: none; cursor: pointer; transition: all 0.3s; display: inline-block; }
        .btn-primary:hover { background: #e55f00; transform: translateY(-2px); }
        .btn-whatsapp { background: #25D366; color: #fff; padding: 16px 40px; border-radius: 8px; font-size: 17px; font-weight: 700; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; }
        .btn-whatsapp:hover { background: #20b858; transform: translateY(-2px); }

        /* TRUST */
        .trust-section { background: #f8f9fa; padding: 30px 40px; border-bottom: 1px solid #eee; }
        .trust-grid { display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; max-width: 900px; margin: 0 auto; }
        .trust-item { display: flex; align-items: center; gap: 10px; color: #444; font-size: 15px; font-weight: 700; }
        .trust-icon { font-size: 24px; }

        /* SECTION TITLE */
        .section-title { text-align: center; padding: 50px 20px 30px; }
        .section-title h2 { font-size: 30px; font-weight: 900; color: #1A1A2E; margin-bottom: 10px; }
        .section-title h2 span { color: #FF6B00; }
        .section-title p { color: #777; font-size: 16px; }
        .title-line { width: 60px; height: 4px; background: #FF6B00; margin: 12px auto 0; border-radius: 2px; }

        /* PRODUCTS */
        .products-section { padding: 0 40px 60px; max-width: 1200px; margin: 0 auto; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px; }
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.08); transition: all 0.3s; position: relative; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 35px rgba(0,0,0,0.12); }
        .product-badge { position: absolute; top: 12px; right: 12px; background: #FF6B00; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 1; }
        .product-badge.stock { background: #e74c3c; left: 12px; right: auto; }
        .product-img { width: 100%; height: 220px; object-fit: cover; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 60px; }
        .product-info { padding: 18px; }
        .product-name { font-size: 17px; font-weight: 700; color: #1A1A2E; margin-bottom: 8px; }
        .product-price-row { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .price-new { font-size: 22px; font-weight: 900; color: #FF6B00; }
        .price-old { font-size: 15px; color: #aaa; text-decoration: line-through; }
        .delivery-badge { background: #e8f5e9; color: #27AE60; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-block; margin-bottom: 12px; }
        .product-actions { display: flex; gap: 8px; align-items: center; width: 100%; }
        .btn-buy-now { flex: 1; background: #FF6B00; color: #fff; padding: 12px; text-align: center; border-radius: 8px; font-size: 16px; font-weight: 700; transition: transform 0.3s, background 0.3s; border: none; font-family: 'Cairo', sans-serif; display: block; }
        .btn-buy-now:hover { background: #e55f00; color: #fff; transform: translateY(-2px); }
        .btn-icon-cart { width: 46px; height: 46px; background: rgba(255,107,0,0.1) !important; color: #FF6B00 !important; display: flex !important; align-items: center !important; justify-content: center !important; border-radius: 8px !important; font-size: 20px !important; transition: all 0.3s !important; padding: 0 !important; border: 1px solid rgba(255,107,0,0.2) !important; line-height: 1 !important; }
        .btn-icon-cart:hover, .btn-icon-cart.added { background: #FF6B00 !important; color: #fff !important; transform: translateY(-2px) !important; }
        .btn-icon-cart::before, .btn-icon-cart::after, .btn-icon-cart.added::after { display: none !important; } /* Override Astra */
        .product-actions .added_to_cart { display: none !important; } /* Hide WC default view cart link that breaks layout */
        .btn-add-cart { width: 100%; background: #FF6B00 !important; color: #fff !important; padding: 13px !important; border: none; border-radius: 8px !important; font-size: 16px !important; font-weight: 700 !important; text-align: center !important; display: block !important; margin: 0 !important; font-family: 'Cairo', sans-serif !important; cursor: pointer; transition: all 0.3s !important; }
        .btn-add-cart:hover { background: #e55f00 !important; transform: translateY(-2px) !important; color: #fff !important;}
        .btn-add-cart::after, .btn-add-cart::before { display: none !important; }

        /* WHY US */
        .why-section { background: #1A1A2E; padding: 60px 40px; text-align: center; }
        .why-section h2 { color: #fff; font-size: 30px; font-weight: 900; margin-bottom: 10px; }
        .why-section h2 span { color: #FF6B00; }
        .why-subtitle { color: #aab4c8; font-size: 16px; margin-bottom: 40px; }
        .why-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 25px; max-width: 1000px; margin: 0 auto; }
        .why-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 30px 20px; transition: all 0.3s; }
        .why-card:hover { background: rgba(255,107,0,0.1); border-color: rgba(255,107,0,0.3); }
        .why-icon { font-size: 40px; margin-bottom: 15px; }
        .why-card h3 { color: #fff; font-size: 17px; font-weight: 700; margin-bottom: 8px; }
        .why-card p { color: #aab4c8; font-size: 14px; line-height: 1.6; }

        /* WHATSAPP CTA */
        .whatsapp-section { background: #25D366; padding: 60px 40px; text-align: center; }
        .whatsapp-section h2 { color: #fff; font-size: 28px; font-weight: 900; margin-bottom: 12px; }
        .whatsapp-section p { color: rgba(255,255,255,0.85); font-size: 16px; margin-bottom: 30px; }
        .btn-wa-big { background: #fff; color: #25D366; padding: 18px 50px; border-radius: 8px; font-size: 18px; font-weight: 900; display: inline-flex; align-items: center; gap: 12px; font-family: 'Cairo', sans-serif; transition: all 0.3s; }
        .btn-wa-big:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }

        /* FOOTER */
        .site-footer { background: #111122; padding: 40px; text-align: center; }
        .footer-logo { color: #fff; font-size: 22px; font-weight: 900; margin-bottom: 10px; }
        .footer-logo span { color: #FF6B00; }
        .footer-tagline { color: #aab4c8; font-size: 14px; margin-bottom: 20px; }
        .footer-links { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; }
        .footer-links a { color: #aab4c8; font-size: 14px; }
        .footer-links a:hover { color: #FF6B00; }
        .footer-copy { color: #555; font-size: 13px; }

        /* MOBILE */
        @media (max-width: 768px) {
            .site-header { padding: 12px 20px; }
            .header-nav { display: none; }
            .hamburger { display: flex; }
            .mobile-nav { display: block; }
            .hero h1 { font-size: 30px; }
            .hero p { font-size: 15px; }
            .hero-buttons { flex-direction: column; align-items: center; }
            .btn-primary, .btn-whatsapp { width: 100%; max-width: 300px; justify-content: center; }
            .trust-grid { gap: 15px; }
            .products-section { padding: 0 15px 40px; }
            .products-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .product-img { height: 160px; }
            .why-section, .whatsapp-section { padding: 40px 20px; }
            .why-grid { grid-template-columns: repeat(2, 1fr); }
            .site-footer { padding: 30px 20px; }
        }

        @media (max-width: 400px) {
            .products-grid { grid-template-columns: 1fr; }
            .why-grid { grid-template-columns: 1fr; }
        }
    
    </style>
</head>
<body <?php body_class(); ?>>
<div class="overlay" id="overlay" onclick="closeMenu()"></div>

<!-- MOBILE NAV -->
<nav class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-header">
        <div class="mobile-nav-logo">هوارة <span>شوب</span></div>
        <button class="close-nav" onclick="closeMenu()">✕</button>
    </div>
    <a href="<?php echo home_url('/'); ?>">🏠 الرئيسية</a>
    <a href="<?php echo home_url('/matjar/'); ?>">🛍️ المتجر</a>
    <a href="<?php echo home_url('/contact/'); ?>">📞 تواصل معنا</a>
    <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">👤 حسابي</a>
    <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="mobile-nav-cart">🛒 السلة</a>
</nav>

<!-- COUNTDOWN BAR -->
<div class="countdown-bar">
    <p>
        <span id="promo-text-today" style="display:none;">🚚 اطلب قبل 04:00 مساءاً ليصلك طلبك اليوم - التوصيل داخل مدينة أولاد تايمة &nbsp;&nbsp; ⏱️ الوقت المتبقي: <span id="timer"></span></span>
        <span id="promo-text-tomorrow" style="display:none;">🚀 اطلب الآن لضمان توصيل طلبك خلال 24 ساعة - التوصيل داخل مدينة أولاد تايمة</span>
    </p>
</div>

<!-- HEADER -->
<header class="site-header">
    <div class="header-left">
        <button class="hamburger" onclick="openMenu()">
            <span></span><span></span><span></span>
        </button>
        <div class="logo">هوارة <span>شوب</span></div>
    </div>
    <nav class="header-nav">
        <a href="<?php echo home_url('/'); ?>">الرئيسية</a>
        <a href="<?php echo home_url('/matjar/'); ?>">المتجر</a>
        <a href="<?php echo home_url('/contact/'); ?>">تواصل معنا</a>
        <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">حسابي</a>
    </nav>
    <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="header-cart">
        🛒 (<span class="cart-count-badge"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?></span>)
    </a>
</header>


<!-- CONTACT PAGE CONTENT -->
<div class="section-title" style="margin-top: 40px;">
    <h2>تواصل <span>معنا</span></h2>
    <p>نحن هنا لمساعدتك في أي وقت!</p>
    <div class="title-line"></div>
</div>

<div class="contact-section" style="max-width: 800px; margin: 0 auto; padding: 20px 20px 80px;">
    <div style="background: #fff; border-radius: 16px; padding: 50px 30px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid #f0f0f0;">
        <div style="width: 80px; height: 80px; background: rgba(37, 211, 102, 0.1); color: #25D366; font-size: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto 25px;">
            <i class="fab fa-whatsapp"></i> 💬
        </div>
        <h3 style="color: #1A1A2E; font-size: 26px; font-weight: 900; margin-bottom: 15px;">دعم واتساب المباشر</h3>
        <p style="color: #666; font-size: 17px; margin-bottom: 35px; line-height: 1.8; max-width: 600px; margin-left: auto; margin-right: auto;">
            أسهل وأسرع طريقة لخدمتك هي عبر رسائل الواتساب.<br>
            فريقنا متاح للرد على جميع استفساراتكم والاهتمام بطلباتكم بكل سرور<br><strong>من الساعة 8:00 صباحاً حتى 11:00 ليلاً.</strong>
        </p>
        <a href="https://wa.me/212702048470?text=مرحبا، لدي استفسار بخصوص منتجات هوارة شوب" class="btn-primary" target="_blank" style="font-size: 19px; padding: 18px 45px; background: #25D366; display: inline-block; box-shadow: 0 10px 20px rgba(37,211,102,0.2);">
            تواصل معنا الان على واتساب
        </a>
    </div>

    <div style="margin-top: 50px; text-align: center;">
        <p style="color: #888; font-size: 15px;">أو اتصل بنا مباشرة على الرقم: <strong style="color: #1A1A2E; font-size: 18px; direction: ltr; display: inline-block;">+212 702 04 84 70</strong></p>
    </div>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="footer-logo">هوارة <span>شوب</span></div>
    <p class="footer-tagline">متجرك المحلي في أولاد تايمة — توصيل في نفس اليوم</p>
    <div class="footer-links">
        <a href="<?php echo home_url('/'); ?>">الرئيسية</a>
        <a href="<?php echo home_url('/matjar/'); ?>">المتجر</a>
        <a href="<?php echo home_url('/contact/'); ?>">تواصل معنا</a>
        <a href="https://wa.me/212702048470" target="_blank">واتساب</a>
    </div>
    <p class="footer-copy">© <?php echo date('Y'); ?> هوارة شوب — جميع الحقوق محفوظة</p>
</footer>

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

function openMenu() {
    document.getElementById('mobileNav').classList.add('open');
    document.getElementById('overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMenu() {
    document.getElementById('mobileNav').classList.remove('open');
    document.getElementById('overlay').classList.remove('open');
    document.body.style.overflow = '';
}

// Instant cart counter update logic
if (typeof jQuery !== 'undefined') {
    jQuery(document).on('added_to_cart', function() {
        var countBadge = jQuery('.cart-count-badge');
        if (countBadge.length) {
            countBadge.text(parseInt(countBadge.text() || 0) + 1);
            countBadge.parent().css({ transform: 'scale(1.1)', transition: 'transform 0.2s', display: 'inline-block' });
            setTimeout(function() { countBadge.parent().css('transform', 'scale(1)'); }, 300);
        }
    });
}
</script>

<?php wp_footer(); ?>
</body>
</html>
