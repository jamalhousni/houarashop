<?php
/**
 * HOUARA-SHOP — WooCommerce Archive Template
 * ──────────────────────────────────────────
 * Handles: /product-category/{slug}/, /matjar/ (WooCommerce archive),
 *          /product-tag/{slug}/, search results (WooCommerce), etc.
 *
 * Location: wp-content/themes/astra/archive-product.php
 *
 * IMPORTANT: This file must be in the ACTIVE theme folder (astra).
 * If you switch themes, copy this file over.
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هوارة-شوب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', sans-serif; direction: rtl; background: #fff; color: #333; }
        a { text-decoration: none; color: inherit; }

        /* COUNTDOWN BAR */
        .countdown-bar { background: #FF6B00; padding: 10px 20px; text-align: center; position: relative; z-index: 1001; }
        .countdown-bar p { color: #fff; font-size: 18px; margin: 0; line-height: 1.2; font-weight: 700; }
        #timer { color: #FFE000; font-weight: 900; direction: ltr; display: inline-block; }

        /* HEADER */
        .site-header { background: #1A1A2E; padding: 15px 40px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .logo { color: #fff; font-size: 26px; font-weight: 900; }
        .logo span { color: #FF6B00; }
        .header-nav { display: flex; gap: 20px; align-items: center; }
        .header-nav a { color: #ccc; font-size: 15px; font-weight: 600; transition: color 0.2s; }
        .header-nav a:hover { color: #FF6B00; }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-cart { background: #FF6B00; color: #fff; padding: 8px 20px; border-radius: 25px; font-weight: 700; font-size: 15px; }

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

        /* ARCHIVE HEADER */
        .archive-header { text-align: center; padding: 50px 20px 30px; background: linear-gradient(135deg, #1A1A2E 0%, #16213e 100%); color: #fff; }
        .archive-header h1 { font-size: 36px; font-weight: 900; margin-bottom: 10px; color: #fff; }
        .archive-header h1 span { color: #FF6B00; }
        .archive-header p { color: #aab4c8; font-size: 16px; max-width: 600px; margin: 0 auto; line-height: 1.6; }
        .archive-breadcrumb { max-width: 1200px; margin: 0 auto; padding: 15px 40px; font-size: 14px; color: #888; }
        .archive-breadcrumb a { color: #FF6B00; }

        /* PRODUCTS SECTION */
        .products-section { padding: 30px 40px 60px; max-width: 1200px; margin: 0 auto; }

        /* WHATSAPP CTA */
        .whatsapp-section { background: #25D366; padding: 20px 40px; text-align: center; }
        .whatsapp-section h2 { color: #fff; font-size: 22px; font-weight: 900; margin-bottom: 8px; }
        .whatsapp-section p { color: rgba(255,255,255,0.85); font-size: 14px; margin-bottom: 20px; }
        .btn-wa-big { background: #fff; color: #25D366; padding: 12px 30px; border-radius: 8px; font-size: 16px; font-weight: 900; display: inline-flex; align-items: center; gap: 10px; font-family: 'Cairo', sans-serif; transition: all 0.3s; }
        .btn-wa-big:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

        /* FOOTER */
        .site-footer { background: #111122; padding: 40px; text-align: center; }
        .footer-logo { color: #fff; font-size: 22px; font-weight: 900; margin-bottom: 10px; }
        .footer-logo span { color: #FF6B00; }
        .footer-tagline { color: #aab4c8; font-size: 14px; margin-bottom: 20px; }
        .footer-links { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; }
        .footer-links a { color: #aab4c8; font-size: 14px; }
        .footer-links a:hover { color: #FF6B00; }
        .footer-copy { color: #555; font-size: 13px; }
        .footer-phone { color: #aab4c8; font-size: 14px; margin-bottom: 10px; direction: ltr; }
        .footer-phone a { color: #FF6B00; font-weight: 700; }

        /* EMPTY STATE */
        .no-products { text-align: center; padding: 60px 20px; }
        .no-products-icon { font-size: 60px; margin-bottom: 15px; }
        .no-products h2 { color: #1A1A2E; margin-bottom: 10px; }
        .no-products p { color: #888; margin-bottom: 25px; }
        .btn-primary { background: #FF6B00; color: #fff; padding: 14px 35px; border-radius: 8px; font-weight: 700; display: inline-block; }
        .btn-primary:hover { background: #e55f00; color: #fff; }

        /* ──────────────────────────────────────────
           WOOCOMMERCE GRID (same as shop page)
           ────────────────────────────────────────── */
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

        .woocommerce ul.products li.product .star-rating { padding: 0 16px 4px !important; }
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

        .woocommerce ul.products li.product .button,
        .woocommerce ul.products li.product a.button {
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
        .woocommerce ul.products li.product .button:hover,
        .woocommerce ul.products li.product a.button:hover {
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

        /* PAGINATION */
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

        /* NOTICES */
        .woocommerce-message {
          background: #e8f8f0 !important;
          color: #006b2e !important;
          border-top-color: #00a86b !important;
          border-radius: 10px !important;
          font-family: 'Cairo', sans-serif !important;
          font-weight: 600 !important;
        }
        .woocommerce-error {
          background: #fef2f2 !important;
          color: #991b1b !important;
          border-top-color: #ef4444 !important;
          border-radius: 10px !important;
        }
        .woocommerce-info {
          background: #eff6ff !important;
          color: #1e40af !important;
          border-top-color: #3b82f6 !important;
          border-radius: 10px !important;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .site-header { padding: 12px 20px; }
            .header-nav { display: none; }
            .hamburger { display: flex; }
            .mobile-nav { display: block; }
            .archive-header { padding: 35px 20px 25px; }
            .archive-header h1 { font-size: 26px; }
            .archive-header p { font-size: 14px; }
            .archive-breadcrumb { padding: 10px 20px; }
            .products-section { padding: 20px 15px 40px; }
            .whatsapp-section { padding: 15px 20px; }
            .site-footer { padding: 30px 20px; }
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
            .woocommerce ul.products li.product .button,
            .woocommerce ul.products li.product a.button {
                font-size: 0.8rem !important;
                padding: 10px 12px !important;
                margin: 6px 12px 12px !important;
                width: calc(100% - 24px) !important;
            }
        }

        /* --- CATEGORY FILTER PILLS --- */
        .hs-filter-pills {
            display: flex; gap: 10px; padding: 14px 40px 22px; max-width: 1200px;
            margin: 0 auto; overflow-x: auto; overflow-y: hidden;
            scrollbar-width: none; -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch; direction: rtl;
        }
        .hs-filter-pills::-webkit-scrollbar { display: none; }
        .hs-filter-pill {
            flex-shrink: 0; background: #fff; color: #1A1A2E;
            border: 2px solid #e8e8e8; padding: 10px 20px; border-radius: 50px;
            font-family: 'Cairo', sans-serif; font-weight: 700; font-size: 14px;
            cursor: pointer; transition: all 0.2s; white-space: nowrap; line-height: 1.2;
        }
        .hs-filter-pill:hover { border-color: #FF6B00; color: #FF6B00; }
        .hs-filter-pill.active { background: #FF6B00; color: #fff; border-color: #FF6B00; box-shadow: 0 4px 12px rgba(255,107,0,0.25); }
        .hs-filter-pill:focus { outline: 2px solid #FF6B00; outline-offset: 2px; }
        .hs-no-products { text-align: center; padding: 50px 20px; color: #777; font-size: 16px; font-weight: 600; grid-column: 1 / -1; }
        @media (max-width: 768px) {
            .hs-filter-pills { padding: 10px 15px 18px; gap: 8px; }
            .hs-filter-pill { padding: 8px 16px; font-size: 13px; }
        }
    </style>
</head>
<body <?php body_class(); ?>>

<!-- OVERLAY -->
<div class="overlay" id="overlay" onclick="closeMenu()"></div>

<!-- MOBILE NAV -->
<nav class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-header">
        <div class="mobile-nav-logo">
            <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
                <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img site-logo-img--mobile" style="height: 44px; width: auto; object-fit: contain;">
            </a>
        </div>
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
        <span id="promo-text-today" style="display:none;">🚚 اطلب قبل 04:00 مساءاً ليصلك طلبك اليوم &nbsp;&nbsp; ⏱️ الوقت المتبقي: <span id="timer"></span></span>
        <span id="promo-text-tomorrow" style="display:none;">🚀 اطلب الآن لضمان توصيل طلبك خلال 24 ساعة</span>
    </p>
</div>

<!-- HEADER -->
<header class="site-header">
    <div class="header-left">
        <button class="hamburger" onclick="openMenu()">
            <span></span><span></span><span></span>
        </button>
        <div class="logo">
            <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
                <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img" style="height: 44px; width: auto; object-fit: contain;">
            </a>
        </div>
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

<!-- ARCHIVE HEADER (dynamic: shows category name, tag, or shop title) -->
<section class="archive-header">
    <h1>
        <?php
        if ( is_product_category() ) {
            single_cat_title();
        } elseif ( is_product_tag() ) {
            echo 'الوسم: ';
            single_tag_title();
        } elseif ( is_shop() ) {
            echo 'متجر <span>هوارة شوب</span>';
        } else {
            woocommerce_page_title();
        }
        ?>
    </h1>
    <p>
        <?php
        if ( is_product_category() ) {
            $description = term_description();
            if ( $description ) {
                echo wp_kses_post( $description );
            } else {
                echo 'تسوق أفضل منتجاتنا في هذه الفئة — توصيل اليوم لأولاد تايمة';
            }
        } else {
            echo 'جميع منتجاتنا المتوفرة للتوصيل الفوري';
        }
        ?>
    </p>
</section>

<!-- BREADCRUMB -->
<div class="archive-breadcrumb">
    <?php
    if ( function_exists( 'woocommerce_breadcrumb' ) ) {
        woocommerce_breadcrumb( array(
            'delimiter'   => ' › ',
            'wrap_before' => '',
            'wrap_after'  => '',
            'before'      => '',
            'after'       => '',
            'home'        => 'الرئيسية',
        ) );
    }
    ?>
</div>

<?php
// Category filter pills — fetched from WooCommerce product_cat taxonomy
$houara_categories = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
if ( ! is_wp_error( $houara_categories ) && ! empty( $houara_categories ) ) : ?>
<nav class="hs-filter-pills" role="tablist" aria-label="تصفية حسب الفئة">
    <button type="button" class="hs-filter-pill active" data-category="all" role="tab" aria-selected="true">الكل</button>
    <?php foreach ( $houara_categories as $hs_cat ) : ?>
        <button type="button" class="hs-filter-pill" data-category="<?php echo esc_attr( $hs_cat->slug ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $hs_cat->name ); ?></button>
    <?php endforeach; ?>
</nav>
<?php endif; ?>

<!-- PRODUCTS LOOP -->
<div class="products-section">
    <div class="woocommerce">

        <?php if ( woocommerce_product_loop() ) : ?>

            <?php
            /**
             * woocommerce_before_shop_loop hook.
             * @hooked woocommerce_output_all_notices   - 10
             * @hooked woocommerce_result_count         - 20
             * @hooked woocommerce_catalog_ordering     - 30
             */
            do_action( 'woocommerce_before_shop_loop' );
            ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <?php
                    /**
                     * woocommerce_shop_loop hook.
                     */
                    do_action( 'woocommerce_shop_loop' );
                    ?>
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php endwhile; ?>
            <?php endif; ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
            /**
             * woocommerce_after_shop_loop hook.
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>

        <?php else : ?>

            <div class="no-products">
                <div class="no-products-icon">📦</div>
                <h2>لا توجد منتجات في هذه الفئة بعد</h2>
                <p>تفقد باقي منتجاتنا في المتجر</p>
                <a href="<?php echo home_url('/matjar/'); ?>" class="btn-primary">🛍️ تصفح جميع المنتجات</a>
            </div>

        <?php endif; ?>

    </div>
</div>

<!-- WHATSAPP CTA -->
<section class="whatsapp-section">
    <h2>💬 تحدث معنا مباشرة!</h2>
    <p>فريقنا متاح كل يوم من 8 صباحاً حتى 11 ليلاً</p>
    <a href="https://wa.me/212702048470?text=مرحبا، أريد الاستفسار عن منتج من هوارة شوب" class="btn-wa-big" target="_blank">💬 ابدأ المحادثة الآن</a>
</section>

<!-- FOOTER -->
<?php houarashop_render_footer(); ?>

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

// Cart counter animation ONLY (badge text is updated by WooCommerce fragments —
// do NOT manually increment here or it will double-count)
if (typeof jQuery !== 'undefined') {
    jQuery(document.body).on('added_to_cart', function() {
        var countBadge = jQuery('.cart-count-badge');
        if (countBadge.length) {
            countBadge.parent().css({ transform: 'scale(1.1)', transition: 'transform 0.2s', display: 'inline-block' });
            setTimeout(function() { countBadge.parent().css('transform', 'scale(1)'); }, 300);
        }
    });

    // Prevent scroll jump on AJAX add to cart
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
</script>

<script>
/* ── HOUARA Category Filter — vanilla JS ──
   Filters products in-place by toggling display on li.product cards.
   Uses WooCommerce's existing .product_cat-{slug} classes (post_class).
   Syncs with URL via history.pushState so filters are shareable/bookmarkable. */
(function(){
    function init(){
        var pills = document.querySelectorAll('.hs-filter-pill');
        if (!pills.length) return;
        var container = document.querySelector('.products-section .woocommerce') || document.querySelector('.products-section');
        if (!container) return;

        function getProducts(){ return container.querySelectorAll('ul.products li.product'); }

        function ensureEmptyMsg(){
            var msg = document.getElementById('hs-no-products');
            if (msg) return msg;
            msg = document.createElement('div');
            msg.id = 'hs-no-products';
            msg.className = 'hs-no-products';
            msg.textContent = '🔍 لا توجد منتجات في هذه الفئة حالياً';
            msg.style.display = 'none';
            var list = container.querySelector('ul.products');
            if (list) list.appendChild(msg); else container.appendChild(msg);
            return msg;
        }

        function applyFilter(category){
            category = category || 'all';
            var products = getProducts();
            var visible = 0;
            products.forEach(function(p){
                var match = (category === 'all') || p.classList.contains('product_cat-' + category);
                p.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            pills.forEach(function(pill){
                var isActive = pill.getAttribute('data-category') === category;
                pill.classList.toggle('active', isActive);
                pill.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
            var msg = ensureEmptyMsg();
            msg.style.display = (visible === 0) ? 'block' : 'none';
        }

        function getUrlCategory(){
            try { return new URLSearchParams(window.location.search).get('category') || 'all'; }
            catch(e){ return 'all'; }
        }

        function setUrlCategory(category){
            try {
                var url = new URL(window.location.href);
                if (category === 'all') url.searchParams.delete('category');
                else url.searchParams.set('category', category);
                history.pushState({ houaraCategory: category }, '', url.toString());
            } catch(e){}
        }

        pills.forEach(function(pill){
            pill.addEventListener('click', function(){
                var cat = this.getAttribute('data-category') || 'all';
                applyFilter(cat);
                setUrlCategory(cat);
                this.scrollIntoView({ behavior:'smooth', block:'nearest', inline:'center' });
            });
        });

        window.addEventListener('popstate', function(){ applyFilter(getUrlCategory()); });

        applyFilter(getUrlCategory());
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
