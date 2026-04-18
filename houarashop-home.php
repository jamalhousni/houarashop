<?php
/**
 * Template Name: HOUARA-SHOP Homepage
 * Description: Custom homepage for houarashop.com
 */
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هوارة شوب — توصيل في نفس اليوم بأولاد تايمة</title>
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
        .product-img { width: 100%; height: 220px; overflow: hidden; background: #f0f0f0; position: relative; display: block; }
        .product-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .product-img a { display: block; width: 100%; height: 100%; }
        .product-img .emoji-placeholder { display: flex; align-items: center; justify-content: center; height: 100%; font-size: 60px; }
        .product-info { padding: 18px; }
        .product-name { font-size: 17px; font-weight: 700; color: #1A1A2E; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; word-break: break-word; }
        .product-price-row { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .price-new { font-size: 22px; font-weight: 900; color: #FF6B00; }
        .price-old { font-size: 15px; color: #aaa; text-decoration: line-through; }
        .delivery-badge { background: #e8f5e9; color: #27AE60; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-block; margin-bottom: 12px; }
        .product-actions { display: flex; gap: 8px; align-items: center; width: 100%; }
        .btn-buy-now { flex: 1; background: #FF6B00; color: #fff; padding: 12px; text-align: center; border-radius: 8px; font-size: 16px; font-weight: 700; transition: transform 0.3s, background 0.3s; border: none; font-family: 'Cairo', sans-serif; display: block; }
        .btn-buy-now:hover { background: #e55f00; color: #fff; transform: translateY(-2px); }
        .btn-icon-cart { width: 46px; height: 46px; background: rgba(255,107,0,0.1) !important; color: #FF6B00 !important; display: flex !important; align-items: center !important; justify-content: center !important; border-radius: 8px !important; font-size: 20px !important; transition: all 0.3s !important; padding: 0 !important; border: 1px solid rgba(255,107,0,0.2) !important; line-height: 1 !important; }
        .btn-icon-cart:hover, .btn-icon-cart.added { background: #FF6B00 !important; color: #fff !important; transform: translateY(-2px) !important; }
        .btn-icon-cart::before, .btn-icon-cart::after, .btn-icon-cart.added::after { display: none !important; }
        .product-actions .added_to_cart { display: none !important; }
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
            .product-img { height: 150px; }
            .product-info { padding: 10px; }
            .product-name { font-size: 13px; }
            .price-new { font-size: 15px; }
            .delivery-badge { font-size: 10px; padding: 3px 6px; }
            .btn-add-cart { font-size: 13px; padding: 10px; }
            .why-section { padding: 40px 20px; }
            .whatsapp-section { padding: 24px 20px; }
            .why-grid { grid-template-columns: repeat(2, 1fr); }
            .site-footer { padding: 30px 20px; }
        }

        @media (max-width: 400px) {
            .products-grid { grid-template-columns: 1fr; }
            .why-grid { grid-template-columns: 1fr; }
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
        🛒 <span class="houara-cart-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?> منتج</span>
    </a>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">📍 متجرك المحلي في أولاد تايمة</div>
        <h1>هوارة شوب<br><span>توصيل في نفس اليوم</span></h1>
        <p>التوصيل داخل مدينة أولاد تايمة والنواحي</p>
        <div class="hero-buttons">
            <a href="<?php echo home_url('/matjar/'); ?>" class="btn-primary">🛍️ تسوق الآن</a>
            <a href="https://wa.me/212702048470?text=مرحبا، أريد الاستفسار عن منتج من هوارة شوب" class="btn-whatsapp" target="_blank">💬 اطلب عبر واتساب</a>
        </div>
    </div>
</section>

<!-- TRUST BADGES -->
<div class="trust-section">
    <div class="trust-grid">
        <div class="trust-item"><span class="trust-icon">🚚</span><span>توصيل نفس اليوم</span></div>
        <div class="trust-item"><span class="trust-icon">💰</span><span>الدفع عند الاستلام</span></div>
        <div class="trust-item"><span class="trust-icon">⭐</span><span>جودة مضمونة</span></div>
        <div class="trust-item"><span class="trust-icon">📞</span><span>خدمة محلية موثوقة</span></div>
    </div>
</div>

<!-- PRODUCTS -->
<div class="section-title">
    <h2>الأكثر مبيعاً في <span>أولاد تايمة</span></h2>
    <p>منتجات مختارة بعناية لتناسب احتياجاتك اليومية</p>
    <div class="title-line"></div>
</div>
<div class="products-section">
    <?php
    $args = array('post_type' => 'product', 'posts_per_page' => 6, 'orderby' => 'popularity');
    $products = new WP_Query($args);
    if ($products->have_posts()) : ?>
    <div class="products-grid">
        <?php while ($products->have_posts()) : $products->the_post();
            global $product;
            $regular_price = $product->get_regular_price();
            $sale_price    = $product->get_sale_price();
            $current_price = $product->get_price();
            $stock         = $product->get_stock_quantity();
        ?>
        <div class="product-card">
            <?php if ($product->is_on_sale()) : ?><div class="product-badge">خصم!</div><?php endif; ?>
            <?php if ($stock && $stock <= 10) : ?><div class="product-badge stock">باقي <?php echo $stock; ?> فقط!</div><?php endif; ?>
            <div class="product-img">
                <?php if (has_post_thumbnail()) : the_post_thumbnail('medium'); else : ?>
                <div class="emoji-placeholder">📦</div>
                <?php endif; ?>
            </div>
            <div class="product-info">
                <div class="product-name"><?php the_title(); ?></div>
                <div class="product-price-row">
                    <span class="price-new"><?php echo $current_price; ?> درهم</span>
                    <?php if ($sale_price && $regular_price) : ?><span class="price-old"><?php echo $regular_price; ?> درهم</span><?php endif; ?>
                </div>
                <div class="delivery-badge">✅ توصيل اليوم لأولاد تايمة</div>
                <?php if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) : ?>
                    <div class="product-actions">
                        <a href="?add-to-cart=<?php echo esc_attr( $product->get_id() ); ?>" data-quantity="1" class="btn-icon-cart button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" aria-label="أضف للسلة" rel="nofollow" title="أضف للسلة">🛒</a>
                        <a href="<?php echo wc_get_checkout_url(); ?>?add-to-cart=<?php echo esc_attr( $product->get_id() ); ?>" class="btn-buy-now">اشتري الآن ⚡</a>
                    </div>
                <?php else : ?>
                    <div class="product-actions">
                        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="btn-add-cart">🛒 اختر الخيارات</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else : ?>
    <div style="text-align:center;padding:60px;color:#777;">
        <div style="font-size:60px;margin-bottom:20px;">📦</div>
        <h3 style="font-size:20px;color:#1A1A2E;margin-bottom:10px;">المنتجات قريباً!</h3>
        <p>نعمل على إضافة أفضل المنتجات لكم. تابعونا!</p>
    </div>
    <?php endif; ?>
</div>

<!-- WHY US -->
<section class="why-section">
    <h2>لماذا <span>هوارة شوب</span>؟</h2>
    <p class="why-subtitle">نحن لسنا مجرد متجر — نحن جيرانك في أولاد تايمة</p>
    <div class="why-grid">
        <div class="why-card"><div class="why-icon">🚀</div><h3>توصيل نفس اليوم</h3><p>اطلب قبل 4 مساءً واستلم طلبك اليوم حتى الساعة 11 ليلاً</p></div>
        <div class="why-card"><div class="why-icon">💰</div><h3>دفع عند الاستلام</h3><p>لا تحتاج لبطاقة بنكية. ادفع نقداً عند وصول طلبك</p></div>
        <div class="why-card"><div class="why-icon">📍</div><h3>متجر محلي موثوق</h3><p>نحن من أولاد تايمة — نعرف احتياجاتكم ونهتم بثقتكم</p></div>
        <div class="why-card"><div class="why-icon">⭐</div><h3>جودة مضمونة</h3><p>كل منتج مجرب ومضمون قبل الإرسال</p></div>
    </div>
</section>

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

jQuery(document).ready(function($) {
    $.post("<?php echo admin_url("admin-ajax.php"); ?>", {action: "houara_cart_count"}, function(data) {
        if (data && data.success && data.data) {
            $(".houara-cart-count").text(data.data.text);
        }
    });
    $(document.body).trigger("wc_fragment_refresh");
});

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
