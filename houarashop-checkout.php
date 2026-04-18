<?php
add_filter( 'woocommerce_checkout_is_block_checkout', '__return_false', 9999 );

/**
 * Template Name: HOUARA Checkout
 * Description: صفحة إتمام الطلب — هوارة شوب
 */

defined('ABSPATH') || exit;

// ── PHP FIX 1: Force COD as the only/default payment method ──
add_filter('woocommerce_available_payment_gateways', function($gateways) {
    if (isset($gateways['cod'])) {
        return array('cod' => $gateways['cod']);
    }
    return $gateways;
}, 9999);

// ── PHP FIX 2: Force-select COD on checkout submission ──
add_filter('woocommerce_checkout_posted_data', function($data) {
    $data['payment_method'] = 'cod';
    return $data;
}, 9999);

// ── PHP FIX 3: Hide coupon field completely ──
add_filter('woocommerce_coupons_enabled', '__return_false');

// ── PHP FIX 4: Suppress "تمت إضافة … إلى سلة مشترياتك" notice on checkout ──
// This notice appears when ?add-to-cart=XX redirects to checkout
add_action('template_redirect', function() {
    if ( function_exists('is_checkout') && is_checkout() ) {
        wc_clear_notices();
    }
}, 20);
// Also suppress it from being re-added on the checkout page itself
add_filter('woocommerce_add_success', function($message) {
    if ( function_exists('is_checkout') && is_checkout() ) {
        return '';
    }
    return $message;
}, 10, 1);

// ── PHP FIX 5: Make phone field STRICTLY required with Moroccan validation ──
add_filter('woocommerce_checkout_fields', function($fields) {
    if (isset($fields['billing']['billing_phone'])) {
        $fields['billing']['billing_phone']['required'] = true;
        $fields['billing']['billing_phone']['label']    = 'رقم الهاتف';
        $fields['billing']['billing_phone']['placeholder'] = '06XXXXXXXX';
    }
    // Also ensure first name and address are required
    if (isset($fields['billing']['billing_first_name'])) {
        $fields['billing']['billing_first_name']['required'] = true;
    }
    if (isset($fields['billing']['billing_address_1'])) {
        $fields['billing']['billing_address_1']['required'] = true;
    }
    return $fields;
}, 9999);

// ── PHP FIX 6: Server-side validation for phone number ──
add_action('woocommerce_checkout_process', function() {
    $phone = isset($_POST['billing_phone']) ? trim(sanitize_text_field($_POST['billing_phone'])) : '';
    if (empty($phone)) {
        wc_add_notice('رقم الهاتف مطلوب لتأكيد الطلب', 'error');
        return;
    }
    // Remove spaces, dashes, etc. for validation
    $clean = preg_replace('/[^0-9+]/', '', $phone);
    // Must be at least 9 digits
    if (strlen($clean) < 9) {
        wc_add_notice('رقم الهاتف قصير جداً — يجب أن يتكون من 10 أرقام على الأقل', 'error');
    }
});

// ── PHP FIX 7: Hide "Create an account?" checkbox (clean UX for COD) ──
add_filter('woocommerce_checkout_registration_enabled', '__return_false');
add_filter('woocommerce_checkout_registration_required', '__return_false');
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إتمام الطلب — هوارة شوب</title>
  <?php wp_head(); ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --orange: #FF6B00;
      --orange-light: #FF8C00;
      --navy: #1A1A2E;
      --navy-light: #2a2a45;
      --white: #ffffff;
      --gray-bg: #f8f8f8;
      --gray-light: #e8e8e8;
      --gray-text: #666;
      --shadow: 0 4px 20px rgba(0,0,0,0.08);
      --radius: 12px;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { direction: rtl; }
    body {
      font-family: 'Cairo', 'Segoe UI', sans-serif;
      background: var(--gray-bg);
      color: var(--navy);
      min-height: 100vh;
    }

    /* ── HEADER ─────────────────────────────────── */
    .houara-header {
      background: var(--navy);
      padding: 0 20px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 12px rgba(0,0,0,0.3);
    }
    .houara-header-inner {
      max-width: 1100px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 65px;
    }
    .houara-logo {
      font-size: 1.5rem;
      font-weight: 900;
      color: var(--white);
      text-decoration: none;
    }
    .houara-logo span { color: var(--orange); }
    .secure-badge {
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(255,255,255,0.8);
      font-size: 0.9rem;
      font-weight: 600;
    }
    .secure-badge .dot {
      width: 10px; height: 10px;
      background: #00e676;
      border-radius: 50%;
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%,100% { opacity: 1; } 50% { opacity: 0.4; }
    }

    /* ── PROGRESS BAR ────────────────────────────── */
    .checkout-progress {
      background: var(--white);
      border-bottom: 1px solid var(--gray-light);
      padding: 16px 20px;
    }
    .checkout-progress-inner {
      max-width: 500px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .progress-step {
      display: flex; flex-direction: column; align-items: center; gap: 4px;
    }
    .progress-step .num {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: var(--gray-light);
      color: var(--gray-text);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem; font-weight: 700;
    }
    .progress-step span { font-size: 0.75rem; color: var(--gray-text); font-weight: 600; }
    .progress-step.done .num { background: #00a86b; color: #fff; }
    .progress-step.active .num { background: var(--orange); color: #fff; }
    .progress-step.active span { color: var(--orange); font-weight: 700; }
    .progress-divider {
      flex: 1; height: 2px; background: var(--gray-light); border-radius: 2px; min-width: 30px;
    }
    .progress-divider.done { background: #00a86b; }

    /* ── PAGE HERO ───────────────────────────────── */
    .page-hero {
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
      padding: 30px 20px;
      text-align: center;
    }
    .page-hero h1 { color: #fff; font-size: 1.6rem; font-weight: 900; margin-bottom: 6px; }
    .page-hero p { color: rgba(255,255,255,0.7); font-size: 0.9rem; }

    /* ── CHECKOUT WRAPPER ────────────────────────── */
    .checkout-wrapper {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px 60px;
    }

    /* ── HIDE "Added to cart" GREEN MESSAGE ON CHECKOUT ── */
    /* CSS belt-and-suspenders in case PHP filter misses any */
    .woocommerce-checkout .woocommerce-message,
    body.woocommerce-checkout > .woocommerce-message,
    .woocommerce-checkout .wc-forward,
    .checkout-wrapper .woocommerce-message {
      display: none !important;
    }

    /* ── HIDE CREATE ACCOUNT + SHIP-TO-DIFFERENT CHECKBOXES ── */
    /* Simpler checkout — fewer distractions */
    .woocommerce-account-fields,
    .create-account,
    #createaccount_field,
    .woocommerce-form-login-toggle,
    .woocommerce-form__input-checkbox[name="createaccount"],
    input#createaccount,
    label[for="createaccount"],
    .woocommerce-form__label-for-checkbox,
    #ship-to-different-address,
    .shipping_address {
      display: none !important;
    }

    /* ── WOOCOMMERCE NOTICES — STYLED, VISIBLE ── */
    .woocommerce-notices-wrapper { display: block !important; }

    /* Error notices stay visible and styled nicely */
    .woocommerce-error {
      display: block !important;
      background: #fff3f3 !important;
      border: 2px solid #e74c3c !important;
      border-radius: 10px !important;
      padding: 16px 20px !important;
      margin-bottom: 20px !important;
      font-family: 'Cairo', sans-serif !important;
      font-weight: 700 !important;
      color: #c0392b !important;
      list-style: none !important;
      direction: rtl !important;
    }
    .woocommerce-error li {
      padding: 4px 0 !important;
      font-size: 0.95rem !important;
    }
    .woocommerce-error li::before { content: "⚠️ " !important; }

    /* Success messages (NOT "added to cart" — those are hidden above) */
    .woocommerce-info {
      display: block !important;
      background: #f0f6ff !important;
      border: 2px solid #3498db !important;
      border-radius: 10px !important;
      padding: 16px 20px !important;
      margin-bottom: 20px !important;
      font-family: 'Cairo', sans-serif !important;
      font-weight: 700 !important;
      color: #1a5276 !important;
      direction: rtl !important;
    }

    /* ── HIDE COUPON FIELD ─────────────────────── */
    .woocommerce-form-coupon-toggle,
    .checkout_coupon,
    .woocommerce-form-coupon,
    form.checkout_coupon,
    .wc-block-components-totals-coupon,
    .coupon-form,
    p.form-row.coupon-field { display: none !important; }

    /* ── WOOCOMMERCE CHECKOUT LAYOUT ─────────────── */
    .woocommerce-checkout #customer_details,
    .woocommerce-checkout .col2-set {
      width: 100% !important;
      float: none !important;
    }
    .woocommerce form .form-row { margin-bottom: 18px; }
    .woocommerce form .form-row label {
      display: block;
      font-size: 0.9rem;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 6px;
    }
    .woocommerce form .form-row input,
    .woocommerce form .form-row textarea,
    .woocommerce form .form-row select {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid var(--gray-light);
      border-radius: 10px;
      font-family: 'Cairo', sans-serif;
      font-size: 1rem;
      color: var(--navy);
      background: #fff;
      transition: border-color 0.2s;
    }
    .woocommerce form .form-row input:focus,
    .woocommerce form .form-row select:focus {
      border-color: var(--orange);
      outline: none;
    }
    .woocommerce form .form-row.woocommerce-invalid input { border-color: #ef4444; }

    /* Phone input: hint user with tel styling */
    #billing_phone { direction: ltr; text-align: right; }

    .woocommerce .woocommerce-billing-fields {
      background: #fff;
      border-radius: var(--radius);
      padding: 28px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
    }
    .woocommerce .woocommerce-billing-fields__field-wrapper { display: block !important; }
    .woocommerce .woocommerce-billing-fields h3 {
      font-size: 1.1rem;
      font-weight: 900;
      color: var(--navy);
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 2px solid var(--gray-light);
    }

    /* ── ORDER REVIEW ────────────────────────────── */
    .woocommerce-checkout-review-order {
      background: #fff;
      border-radius: var(--radius);
      padding: 28px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
    }
    .woocommerce-checkout #order_review_heading {
      font-size: 1.1rem;
      font-weight: 900;
      color: var(--navy);
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 2px solid var(--gray-light);
    }
    .woocommerce table.shop_table { width: 100%; border-collapse: collapse; }
    .woocommerce table.shop_table th {
      padding: 10px 0;
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--gray-text);
      text-align: right;
      border-bottom: 2px solid var(--gray-light);
    }
    .woocommerce table.shop_table td {
      padding: 12px 0;
      border-bottom: 1px solid var(--gray-light);
      font-size: 0.95rem;
    }
    .woocommerce table.shop_table .product-name { font-weight: 700; color: var(--navy); }
    .woocommerce table.shop_table .product-total,
    .woocommerce table.shop_table .order-total td { color: var(--orange); font-weight: 900; }
    .woocommerce table.shop_table tfoot tr:last-child th,
    .woocommerce table.shop_table tfoot tr:last-child td { border-bottom: none; }

    /* ── COD HIGHLIGHT BOX ───────────────────────── */
    .cod-highlight {
      background: rgba(255,107,0,0.06);
      border: 2px solid var(--orange);
      border-radius: 12px;
      padding: 18px 20px;
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 20px;
    }
    .cod-highlight .icon { font-size: 2rem; }
    .cod-highlight .text strong {
      display: block; font-size: 1rem; font-weight: 900; color: var(--navy); margin-bottom: 4px;
    }
    .cod-highlight .text span { font-size: 0.9rem; color: var(--gray-text); }

    /* ── HIDE ALL PAYMENT METHOD UI (we show our custom COD box) ── */
    #payment .wc_payment_methods,
    #payment ul.payment_methods,
    #payment ul.wc_payment_methods,
    .woocommerce-checkout-payment .wc_payment_methods,
    #payment .payment_box,
    #payment ul.payment_methods li .payment_box,
    .woocommerce-checkout-payment .payment_box,
    .woocommerce-privacy-policy-text,
    .woocommerce-privacy-policy-text p { display: none !important; }

    /* ── PAYMENT SECTION ─────────────────────────── */
    #payment {
      background: #fff;
      border-radius: var(--radius);
      padding: 28px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
    }
    #payment .place-order { margin-top: 20px; }
    #payment .place-order #place_order {
      width: 100%;
      background: linear-gradient(135deg, var(--orange), var(--orange-light)) !important;
      color: #fff !important;
      font-family: 'Cairo', sans-serif !important;
      font-size: 1.15rem !important;
      font-weight: 900 !important;
      padding: 18px !important;
      border-radius: 10px !important;
      border: none !important;
      cursor: pointer !important;
      box-shadow: 0 4px 15px rgba(255,107,0,0.4) !important;
      transition: transform 0.15s !important;
    }
    #payment .place-order #place_order:hover { transform: translateY(-2px) !important; }

    /* ── FOOTER ──────────────────────────────────── */
    .houara-footer {
      background: var(--navy); color: rgba(255,255,255,0.7);
      text-align: center; padding: 24px 20px; font-size: 0.85rem;
    }

    /* ── FAST CHECKOUT — HIDE UNNEEDED FIELDS ─────── */
    #billing_last_name_field,
    #billing_company_field,
    #billing_country_field,
    #billing_address_2_field,
    #billing_city_field,
    #billing_state_field,
    #billing_postcode_field,
    #billing_email_field,
    .woocommerce-additional-fields,
    .woocommerce-billing-fields h3 { display: none !important; }

    #billing_first_name_field,
    #billing_phone_field,
    #billing_address_1_field {
      width: 100% !important;
      float: none !important;
      clear: both !important;
    }

    /* ── RESPONSIVE ──────────────────────────────── */
    @media (max-width: 768px) {
      .checkout-wrapper { padding: 0 12px 40px; }
      .page-hero h1 { font-size: 1.3rem; }
      .secure-badge span:not(:first-child) { display: none; }
      .checkout-progress-inner { gap: 4px; }
      .progress-divider { min-width: 20px; }
      .woocommerce .woocommerce-billing-fields,
      .woocommerce-checkout-review-order,
      #payment { padding: 18px; }
    }
  </style>
</head>
<body class="woocommerce-checkout">

<!-- HEADER -->
<header class="houara-header">
  <div class="houara-header-inner">
    <a href="<?php echo home_url('/'); ?>" class="houara-logo">هوارة <span>شوب</span></a>
    <div class="secure-badge">
      <div class="dot"></div>
      <span>🔒 دفع آمن 100%</span>
    </div>
  </div>
</header>

<!-- PROGRESS BAR -->
<div class="checkout-progress">
  <div class="checkout-progress-inner">
    <div class="progress-step done">
      <div class="num">✓</div>
      <span>السلة</span>
    </div>
    <div class="progress-divider done"></div>
    <div class="progress-step active">
      <div class="num">2</div>
      <span>تأكيد الطلب</span>
    </div>
    <div class="progress-divider"></div>
    <div class="progress-step">
      <div class="num">3</div>
      <span>التوصيل</span>
    </div>
  </div>
</div>

<!-- PAGE HERO -->
<div class="page-hero">
  <h1>✅ إتمام الطلب</h1>
  <p>أدخل بياناتك وسالتوصيلك اليوم إن طلبت قبل الساعة 4 مساءً 🚚</p>
</div>

<!-- CHECKOUT CONTENT -->
<div class="checkout-wrapper">
  <?php
  add_action('woocommerce_review_order_before_payment', function() {
    echo '<div class="cod-highlight">
      <div class="icon">💵</div>
      <div class="text">
        <strong>الدفع عند الاستلام</strong>
        <span>ادفع نقداً حين يصلك طلبك — لا بطاقة مطلوبة</span>
      </div>
    </div>';
  });

  the_content();

  if (!have_posts()) {
    echo do_shortcode('[woocommerce_checkout]');
  }
  ?>
</div>

<!-- FOOTER -->
<footer class="houara-footer">
  <p>© <?php echo date('Y'); ?> هوارة شوب — توصيل في نفس اليوم لأولاد تايمة 🚚</p>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // ── Fill all hidden required fields immediately ──
    function fillHiddenFields() {
        var lastName = document.getElementById('billing_last_name');
        if (lastName && lastName.value === '') lastName.value = '.';

        var country = document.getElementById('billing_country');
        if (country && country.value !== 'MA') {
            country.value = 'MA';
            country.dispatchEvent(new Event('change', { bubbles: true }));
        }

        var city = document.getElementById('billing_city');
        if (city && city.value === '') city.value = 'أولاد تايمة';

        var zip = document.getElementById('billing_postcode');
        if (zip && zip.value === '') zip.value = '83350';

        var email = document.getElementById('billing_email');
        if (email && email.value === '') {
            email.value = 'order' + Date.now() + '@houarashop.com';
        }

        // Ensure COD is selected
        var codRadio = document.querySelector('input[name="payment_method"][value="cod"]');
        if (codRadio && !codRadio.checked) {
            codRadio.checked = true;
            codRadio.dispatchEvent(new Event('change', { bubbles: true }));
        }
        var paymentInput = document.querySelector('input[name="payment_method"]');
        if (!paymentInput) {
            var form = document.querySelector('form.woocommerce-checkout');
            if (form && !form.querySelector('input[name="payment_method"]')) {
                var hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'payment_method';
                hidden.value = 'cod';
                form.appendChild(hidden);
            }
        }
    }

    fillHiddenFields();

    // ── Translate labels to Arabic ──
    function translateLabels() {
        var fLabel = document.querySelector('label[for="billing_first_name"]');
        if (fLabel && !fLabel.innerHTML.includes('الإسم الكامل')) {
            fLabel.innerHTML = 'الإسم الكامل <abbr class="required" title="مطلوب">*</abbr>';
        }
        var aLabel = document.querySelector('label[for="billing_address_1"]');
        if (aLabel && !aLabel.innerHTML.includes('عنوان التوصيل')) {
            aLabel.innerHTML = 'عنوان التوصيل بالتفصيل (الحي، الشارع، الرقم) <abbr class="required" title="مطلوب">*</abbr>';
        }
        var pLabel = document.querySelector('label[for="billing_phone"]');
        if (pLabel && !pLabel.innerHTML.includes('رقم الهاتف')) {
            pLabel.innerHTML = 'رقم الهاتف <abbr class="required" title="مطلوب">*</abbr>';
        }
    }
    translateLabels();

    // ── Force phone input to required + tel type ──
    function enforcePhoneRequired() {
        var phone = document.getElementById('billing_phone');
        if (phone) {
            phone.setAttribute('required', 'required');
            phone.setAttribute('type', 'tel');
            phone.setAttribute('inputmode', 'tel');
            phone.setAttribute('pattern', '[0-9+ ]{9,}');
            phone.setAttribute('title', 'يرجى إدخال رقم هاتف صحيح (10 أرقام على الأقل)');
            if (!phone.placeholder) phone.placeholder = '06XXXXXXXX';
        }
    }
    enforcePhoneRequired();

    // ── Client-side phone validation BEFORE submitting ──
    var placeOrderBtn = document.getElementById('place_order');
    var checkoutForm = document.querySelector('form.woocommerce-checkout');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            var phone = document.getElementById('billing_phone');
            if (phone) {
                var cleanPhone = phone.value.replace(/[^0-9+]/g, '');
                if (cleanPhone.length < 9) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Show inline error
                    var existingError = document.getElementById('houara-phone-error');
                    if (!existingError) {
                        var errorDiv = document.createElement('div');
                        errorDiv.id = 'houara-phone-error';
                        errorDiv.className = 'woocommerce-error';
                        errorDiv.style.cssText = 'background:#fff3f3;border:2px solid #e74c3c;border-radius:10px;padding:16px 20px;margin-bottom:20px;color:#c0392b;font-weight:700;direction:rtl;';
                        errorDiv.innerHTML = '⚠️ رقم الهاتف مطلوب لتأكيد الطلب. الرجاء إدخال رقم صحيح (10 أرقام على الأقل)';
                        var wrapper = document.querySelector('.checkout-wrapper');
                        if (wrapper) wrapper.insertBefore(errorDiv, wrapper.firstChild);
                    }
                    phone.focus();
                    phone.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                } else {
                    // Remove any existing error
                    var existingError = document.getElementById('houara-phone-error');
                    if (existingError) existingError.remove();
                }
            }
        }, true);
    }

    // ── Hide payment radio UI + coupon + privacy text + create account ──
    function hideUnwantedUI() {
        var selectors = [
            '#payment .wc_payment_methods',
            '#payment ul.payment_methods',
            '#payment ul.wc_payment_methods',
            '#payment .payment_box',
            '.woocommerce-checkout-payment .payment_box',
            '.woocommerce-privacy-policy-text',
            '.woocommerce-form-coupon-toggle',
            '.checkout_coupon',
            '.woocommerce-form-coupon',
            '.woocommerce-account-fields',
            '#createaccount_field',
            'label[for="createaccount"]',
            '#ship-to-different-address',
            // Hide the "added to cart" green notice specifically on checkout
            '.woocommerce-checkout .woocommerce-message',
            '.checkout-wrapper > .woocommerce-message',
        ];
        selectors.forEach(function(sel) {
            document.querySelectorAll(sel).forEach(function(el) {
                el.style.setProperty('display', 'none', 'important');
            });
        });
        // Also remove any lingering "added to cart" notice that slips through
        document.querySelectorAll('.woocommerce-message').forEach(function(el) {
            if (el.textContent.indexOf('سلة مشترياتك') !== -1 ||
                el.textContent.indexOf('added to your cart') !== -1 ||
                el.textContent.indexOf('تم إضافة') !== -1) {
                el.style.setProperty('display', 'none', 'important');
                el.remove();
            }
        });
    }
    hideUnwantedUI();

    // Re-run after WooCommerce AJAX updates
    if (typeof jQuery !== 'undefined') {
        jQuery(document.body).on('updated_checkout', function() {
            fillHiddenFields();
            translateLabels();
            enforcePhoneRequired();
            hideUnwantedUI();
        });
        jQuery(document.body).on('payment_method_selected', function() {
            hideUnwantedUI();
        });
    }

    // Scroll to error if order fails
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1 && (
                    node.classList && node.classList.contains('woocommerce-error')
                )) {
                    setTimeout(function() {
                        var errorEl = document.querySelector('.woocommerce-error');
                        if (errorEl) {
                            errorEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }, 100);
                }
            });
        });
    });

    var checkoutWrapper = document.querySelector('.checkout-wrapper, form.woocommerce-checkout');
    if (checkoutWrapper) {
        observer.observe(checkoutWrapper, { childList: true, subtree: true });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
