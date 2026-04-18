<?php
/**
 * Template Name: HOUARA Shop
 * Description: صفحة المتجر المخصصة
 */
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المتجر — هوارة شوب</title>
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

        /* SECTION TITLE */
        .section-title { text-align: center; padding: 50px 20px 30px; }
        .section-title h2 { font-size: 30px; font-weight: 900; color: #1A1A2E; margin-bottom: 10px; }
        .section-title h2 span { color: #FF6B00; }
        .section-title p { color: #777; font-size: 16px; }
        .title-line { width: 60px; height: 4px; background: #FF6B00; margin: 12px auto 0; border-radius: 2px; }

        /* PRODUCTS */
        .products-section { padding: 0 40px 60px; max-width: 1200px; margin: 0 auto; }

        /* WHATSAPP CTA — compact */
        .whatsapp-section { background: #25D366; padding: 28px 40px; text-align: center; }
        .whatsapp-section h2 { color: #fff; font-size: 20px; font-weight: 900; margin-bottom: 6px; }
        .whatsapp-section p { color: rgba(255,255,255,0.85); font-size: 14px; margin-bottom: 16px; }
        .btn-wa-big { background: #fff; color: #25D366; padding: 12px 32px; border-radius: 8px; font-size: 15px; font-weight: 900; display: inline-flex; align-items: center; gap: 10px; font-family: 'Cairo', sans-serif; transition: all 0.3s; }
        .btn-wa-big:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }

        /* FOOTER */
        .site-footer { background: #111122; padding: 40px; text-align: center; }
        .footer-logo { color: #fff; font-size: 22px; font-weight: 900; margin-bottom: 10px; }
        .footer-logo span { color: #FF6B00; }
        .footer-tagline { color: #aab4c8; font-size: 14px; margin-bottom: 20px; }
        .footer-links { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; }
        .footer-links a { color: #aab4c8; font-size: 14px; }
        .footer-links a:hover { color: #FF6B00; }
        .footer-copy { color: #555; font-size: 13px; }

        /* HIDE green "added to cart" banner on shop page */
        .woocommerce-message { display: none !important; }

        /* MOBILE */
        @media (max-width: 768px) {
            .site-header { padding: 12px 20px; }
            .header-nav { display: none; }
            .hamburger { display: flex; }
            .mobile-nav { display: block; }
            .products-section { padding: 0 15px 40px; }
            .whatsapp-section { padding: 24px 20px; }
            .site-footer { padding: 30px 20px; }
        }

/* --- WOOCOMMERCE SHOP STYLES --- */
.woocommerce,
.woocommerce-page,
.woocommerce *,
.woocommerce-page * {
  font-family: 'Cairo', 'Segoe UI', sans-serif !important;
  direction: rtl;
}
.woocommerce .woocommerce-result-count {
  float: right !important;
  color: #666;
  font-size: 0.95rem;
  font-weight: 700;
  margin: 0 0 20px 0 !important;
  padding: 10px 0 !important;
}
.woocommerce .woocommerce-ordering {
  float: left !important;
  margin: 0 0 20px 0 !important;
}
.woocommerce .woocommerce-ordering select {
  border: 2px solid #e8e8e8;
  border-radius: 8px;
  padding: 8px 14px;
  font-family: 'Cairo', sans-serif;
  font-size: 0.9rem;
  color: #1A1A2E;
  cursor: pointer;
  background: #fff;
}
.woocommerce .woocommerce-ordering select:focus {
  border-color: #FF6B00;
  outline: none;
}
.woocommerce ul.products {
  display: grid !important;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)) !important;
  width: 100% !important;
  clear: both !important;
  gap: 20px !important;
  list-style: none !important;
  padding: 0 !important;
  margin: 0 !important;
}
.woocommerce ul.products li.product {
  background: #fff !important;
  border-radius: 14px !important;
  overflow: hidden !important;
  box-shadow: 0 4px 16px rgba(0,0,0,0.07) !important;
  transition: transform 0.25s, box-shadow 0.25s !important;
  position: relative !important;
  border: none !important;
}
.woocommerce ul.products li.product:hover {
  transform: translateY(-5px) !important;
  box-shadow: 0 10px 30px rgba(0,0,0,0.12) !important;
}
.woocommerce ul.products li.product a img {
  width: 100% !important;
  height: 200px !important;
  object-fit: cover !important;
  display: block !important;
  transition: transform 0.3s !important;
}
.woocommerce ul.products li.product:hover a img {
  transform: scale(1.04) !important;
}
.woocommerce ul.products li.product .woocommerce-loop-product__title {
  font-size: 1rem !important;
  font-weight: 700 !important;
  color: #1A1A2E !important;
  padding: 14px 16px 6px !important;
  line-height: 1.4 !important;
}
.woocommerce ul.products li.product .price {
  color: #FF6B00 !important;
  font-size: 1.05rem !important;
  font-weight: 900 !important;
  padding: 0 16px 6px !important;
  display: block !important;
}
.woocommerce ul.products li.product .price del {
  color: #aaa !important;
  font-size: 0.85rem !important;
  font-weight: 400 !important;
  margin-left: 6px !important;
  text-decoration: line-through !important;
}
.woocommerce ul.products li.product .price ins {
  text-decoration: none !important;
  color: #FF6B00 !important;
}
.woocommerce ul.products li.product .star-rating {
  padding: 0 16px 4px !important;
}
.woocommerce .star-rating span::before { color: #FF6B00 !important; }
.woocommerce .star-rating::before { color: #e0e0e0 !important; }
.woocommerce ul.products li.product .onsale {
  background: #FF6B00 !important;
  color: #fff !important;
  border-radius: 6px !important;
  padding: 4px 10px !important;
  font-size: 0.8rem !important;
  font-weight: 700 !important;
  top: 12px !important;
  right: 12px !important;
  left: auto !important;
  min-height: auto !important;
  min-width: auto !important;
  line-height: 1.4 !important;
}
.woocommerce ul.products li.product .button.add_to_cart_button,
.woocommerce ul.products li.product a.add_to_cart_button {
  background: #1A1A2E !important;
  color: #fff !important;
  font-family: 'Cairo', sans-serif !important;
  font-size: 0.9rem !important;
  font-weight: 700 !important;
  padding: 12px 16px !important;
  margin: 8px 16px 16px !important;
  border-radius: 10px !important;
  border: none !important;
  cursor: pointer !important;
  transition: background 0.2s !important;
  display: block !important;
  text-align: center !important;
  text-decoration: none !important;
  width: calc(100% - 32px) !important;
}
.woocommerce ul.products li.product .button.add_to_cart_button:hover,
.woocommerce ul.products li.product a.add_to_cart_button:hover {
  background: #FF6B00 !important;
}
.woocommerce ul.products li.product .added_to_cart {
  background: #00a86b !important;
  color: #fff !important;
  font-family: 'Cairo', sans-serif !important;
  font-size: 0.85rem !important;
  font-weight: 700 !important;
  padding: 8px 16px !important;
  margin: 0 16px 8px !important;
  border-radius: 8px !important;
  display: block !important;
  text-align: center !important;
  text-decoration: none !important;
}
.woocommerce nav.woocommerce-pagination ul {
  border: none !important;
  display: flex !important;
  gap: 6px !important;
  justify-content: center !important;
  padding: 24px 0 !important;
}
.woocommerce nav.woocommerce-pagination ul li { border: none !important; }
.woocommerce nav.woocommerce-pagination ul li a,
.woocommerce nav.woocommerce-pagination ul li span {
  background: #fff !important;
  border: 2px solid #e8e8e8 !important;
  border-radius: 8px !important;
  color: #1A1A2E !important;
  font-family: 'Cairo', sans-serif !important;
  font-weight: 700 !important;
  padding: 8px 14px !important;
  transition: all 0.2s !important;
}
.woocommerce nav.woocommerce-pagination ul li a:hover {
  background: #FF6B00 !important;
  border-color: #FF6B00 !important;
  color: #fff !important;
}
.woocommerce nav.woocommerce-pagination ul li span.current {
  background: #FF6B00 !important;
  border-color: #FF6B00 !important;
  color: #fff !important;
}
.woocommerce-error {
  background: #fef2f2 !important;
  color: #991b1b !important;
  border-top-color: #ef4444 !important;
  border-radius: 10px !important;
  font-family: 'Cairo', sans-serif !important;
  font-weight: 600 !important;
}
.woocommerce-info {
  background: #eff6ff !important;
  color: #1e40af !important;
  border-top-color: #3b82f6 !important;
  border-radius: 10px !important;
  font-family: 'Cairo', sans-serif !important;
  font-weight: 600 !important;
}
@media (max-width: 600px) {
  .woocommerce ul.products {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 12px !important;
  }
  .woocommerce ul.products li.product a img { height: 150px !important; }
  .woocommerce ul.products li.product .woocommerce-loop-product__title {
    font-size: 0.85rem !important;
    padding: 10px 12px 4px !important;
  }
  .woocommerce ul.products li.product .button.add_to_cart_button,
  .woocommerce ul.products li.product a.add_to_cart_button {
    font-size: 0.8rem !important;
    padding: 10px 12px !important;
    margin: 6px 12px 12px !important;
    width: calc(100% - 24px) !important;
  }
}
    </style>
</head>
<body>

<!-- OVERLAY -->
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

<!-- SHOP PAGE CONTENT -->
<div class="section-title" style="margin-top: 40px;">
    <h2>متجر <span>هوارة شوب</span></h2>
    <p>جميع منتجاتنا المتوفرة للتوصيل الفوري</p>
    <div class="title-line"></div>
</div>

<div class="products-section" style="min-height: 50vh;">
    <div class="woocommerce" style="max-width: 1200px; margin: 0 auto; direction: rtl;">
        <?php echo do_shortcode('[products limit="24" columns="4" paginate="true" orderby="date" order="DESC"]'); ?>
    </div>
</div>

<!-- WHATSAPP CTA -->
<section class="whatsapp-section">
    <h2>💬 تحدث معنا مباشرة!</h2>
    <p>فريقنا متاح كل يوم من 8 صباحاً حتى 11 ليلاً</p>
    <a href="https://wa.me/212702048470?text=مرحبا، أريد الاستفسار عن منتج من هوارة شوب" class="btn-wa-big" target="_blank">💬 ابدأ المحادثة الآن</a>
</section>

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

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof jQuery !== 'undefined') {
        var lastScrollY = 0;
        jQuery(document).on('click', '.add_to_cart_button, .single_add_to_cart_button', function() {
            lastScrollY = window.scrollY;
        });
        jQuery(document.body).on('added_to_cart', function() {
            jQuery('html, body').stop(true, true);
            window.scrollTo(0, lastScrollY);
            setTimeout(function() { window.scrollTo(0, lastScrollY); }, 50);
            setTimeout(function() { window.scrollTo(0, lastScrollY); }, 300);
        });
    }
});
</script>

</body>
</html>
