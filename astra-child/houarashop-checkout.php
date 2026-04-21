<?php
add_filter( 'woocommerce_checkout_is_block_checkout', '__return_false', 9999 );
/**
 * Template Name: HOUARA Checkout
 * Description: صفحة إتمام الطلب — هوارة شوب
 */
defined('ABSPATH') || exit;

add_filter('woocommerce_available_payment_gateways', function($gateways) {
    if (isset($gateways['cod'])) { return array('cod' => $gateways['cod']); }
    return $gateways;
}, 9999);

// ── Fill all hidden/backend fields automatically so WC never complains ──
add_filter('woocommerce_checkout_posted_data', function($data) {
    $data['payment_method']   = 'cod';
    $data['billing_country']  = 'MA';
    $data['billing_state']    = '';   // blank = no MAAGD shown
    $data['billing_city']     = 'أولاد تايمة'; // always set silently
    $data['billing_postcode'] = '83350';
    // Fill last name if empty (WC requires it internally)
    if ( empty( $data['billing_last_name'] ) ) {
        $data['billing_last_name'] = '.';
    }
    // Generate dummy email if empty
    if ( empty( $data['billing_email'] ) ) {
        $data['billing_email'] = 'order' . time() . '@houarashop.com';
    }
    return $data;
}, 9999);

add_filter('woocommerce_coupons_enabled', '__return_false');
add_action('template_redirect', function() {
    if (function_exists('is_checkout') && is_checkout()) { wc_clear_notices(); }
}, 20);
add_filter('woocommerce_add_success', function($message) {
    if (function_exists('is_checkout') && is_checkout()) { return ''; }
    return $message;
}, 10, 1);

// ── Field config: only phone is required. Address optional (customer contacts us). ──
add_filter('woocommerce_checkout_fields', function($fields) {
    // Phone: required
    if (isset($fields['billing']['billing_phone'])) {
        $fields['billing']['billing_phone']['required']    = true;
        $fields['billing']['billing_phone']['label']       = 'رقم الهاتف';
        $fields['billing']['billing_phone']['placeholder'] = '06XXXXXXXX';
    }
    // Name: required
    if (isset($fields['billing']['billing_first_name'])) {
        $fields['billing']['billing_first_name']['required'] = true;
    }
    // Address: optional — customer can leave blank, we'll call them
    if (isset($fields['billing']['billing_address_1'])) {
        $fields['billing']['billing_address_1']['required'] = false;
    }
    // City, state, postcode: NOT required (we fill these automatically)
    if (isset($fields['billing']['billing_city']))     { $fields['billing']['billing_city']['required']     = false; }
    if (isset($fields['billing']['billing_state']))    { $fields['billing']['billing_state']['required']    = false; }
    if (isset($fields['billing']['billing_postcode'])) { $fields['billing']['billing_postcode']['required'] = false; }
    if (isset($fields['billing']['billing_country']))  { $fields['billing']['billing_country']['required']  = false; }
    if (isset($fields['billing']['billing_email']))    { $fields['billing']['billing_email']['required']    = false; }
    if (isset($fields['billing']['billing_last_name'])){ $fields['billing']['billing_last_name']['required']= false; }
    return $fields;
}, 9999);

// ── Only validate phone — ignore city/state/address errors ──
add_action('woocommerce_checkout_process', function() {
    $phone = isset($_POST['billing_phone']) ? trim(sanitize_text_field($_POST['billing_phone'])) : '';
    if (empty($phone)) {
        wc_add_notice('رقم الهاتف مطلوب لتأكيد الطلب', 'error');
        return;
    }
    $clean = preg_replace('/[^0-9+]/', '', $phone);
    if (strlen($clean) < 9) {
        wc_add_notice('رقم الهاتف قصير جداً — يجب أن يتكون من 10 أرقام على الأقل', 'error');
    }
}, 99);

add_filter('woocommerce_checkout_registration_enabled', '__return_false');
add_filter('woocommerce_checkout_registration_required', '__return_false');

// ── Remove state/city from order confirmation address display ──
add_filter('woocommerce_order_formatted_billing_address', function($address, $order) {
    $address['state'] = '';
    $address['city']  = ''; // hide city from display (it's in address_1 anyway)
    return $address;
}, 10, 2);
add_filter('woocommerce_order_formatted_shipping_address', function($address, $order) {
    $address['state'] = '';
    $address['city']  = '';
    return $address;
}, 10, 2);
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>هوارة-شوب</title>
  <?php wp_head(); ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
  <style>
    :root { --orange:#FF6B00; --orange-light:#FF8C00; --navy:#1A1A2E; --navy-light:#2a2a45; --white:#ffffff; --gray-bg:#f8f8f8; --gray-light:#e8e8e8; --gray-text:#666; --shadow:0 4px 20px rgba(0,0,0,0.08); --radius:12px; }
    * { margin:0; padding:0; box-sizing:border-box; }
    html { direction:rtl; }
    body { font-family:'Cairo','Segoe UI',sans-serif; background:var(--gray-bg); color:var(--navy); min-height:100vh; }
    .houara-header { background:var(--navy); padding:0 20px; position:sticky; top:0; z-index:100; box-shadow:0 2px 12px rgba(0,0,0,0.3); }
    .houara-header-inner { max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; height:65px; }
    .secure-badge { display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.8); font-size:0.9rem; font-weight:600; }
    .secure-badge .dot { width:10px; height:10px; background:#00e676; border-radius:50%; animation:pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
    .checkout-progress { background:var(--white); border-bottom:1px solid var(--gray-light); padding:16px 20px; }
    .checkout-progress-inner { max-width:500px; margin:0 auto; display:flex; align-items:center; justify-content:center; gap:8px; }
    .progress-step { display:flex; flex-direction:column; align-items:center; gap:4px; }
    .progress-step .num { width:32px; height:32px; border-radius:50%; background:var(--gray-light); color:var(--gray-text); display:flex; align-items:center; justify-content:center; font-size:0.85rem; font-weight:700; }
    .progress-step span { font-size:0.75rem; color:var(--gray-text); font-weight:600; }
    .progress-step.done .num { background:#00a86b; color:#fff; }
    .progress-step.active .num { background:var(--orange); color:#fff; }
    .progress-step.active span { color:var(--orange); font-weight:700; }
    .progress-divider { flex:1; height:2px; background:var(--gray-light); border-radius:2px; min-width:30px; }
    .progress-divider.done { background:#00a86b; }
    .page-hero { background:linear-gradient(135deg,var(--navy) 0%,var(--navy-light) 100%); padding:30px 20px; text-align:center; }
    .page-hero h1 { color:#fff; font-size:1.6rem; font-weight:900; margin-bottom:6px; }
    .page-hero p { color:rgba(255,255,255,0.7); font-size:0.9rem; }
    .checkout-wrapper { max-width:1000px; margin:40px auto; padding:0 20px 60px; }
    .woocommerce-checkout .woocommerce-message, body.woocommerce-checkout > .woocommerce-message, .checkout-wrapper .woocommerce-message { display:none !important; }
    .woocommerce-account-fields, .create-account, #createaccount_field, .woocommerce-form-login-toggle, input#createaccount, label[for="createaccount"], .woocommerce-form__label-for-checkbox, #ship-to-different-address, .shipping_address { display:none !important; }
    .woocommerce-notices-wrapper { display:block !important; }
    .woocommerce-error { display:block !important; background:#fff3f3 !important; border:2px solid #e74c3c !important; border-radius:10px !important; padding:16px 20px !important; margin-bottom:20px !important; font-family:'Cairo',sans-serif !important; font-weight:700 !important; color:#c0392b !important; list-style:none !important; direction:rtl !important; }
    .woocommerce-error li { padding:4px 0 !important; font-size:0.95rem !important; }
    .woocommerce-error li::before { content:"⚠️ " !important; }
    .woocommerce-info { display:block !important; background:#f0f6ff !important; border:2px solid #3498db !important; border-radius:10px !important; padding:16px 20px !important; margin-bottom:20px !important; font-family:'Cairo',sans-serif !important; font-weight:700 !important; color:#1a5276 !important; direction:rtl !important; }
    .woocommerce-form-coupon-toggle, .checkout_coupon, .woocommerce-form-coupon, form.checkout_coupon, .wc-block-components-totals-coupon, p.form-row.coupon-field { display:none !important; }
    .woocommerce-checkout #customer_details, .woocommerce-checkout .col2-set { width:100% !important; float:none !important; }
    .woocommerce form .form-row { margin-bottom:18px; }
    .woocommerce form .form-row label { display:block; font-size:0.9rem; font-weight:700; color:var(--navy); margin-bottom:6px; }
    .woocommerce form .form-row input, .woocommerce form .form-row textarea, .woocommerce form .form-row select { width:100%; padding:12px 16px; border:2px solid var(--gray-light); border-radius:10px; font-family:'Cairo',sans-serif; font-size:1rem; color:var(--navy); background:#fff; transition:border-color 0.2s; }
    .woocommerce form .form-row input:focus, .woocommerce form .form-row select:focus { border-color:var(--orange); outline:none; }
    .woocommerce form .form-row .optional { display:none !important; }
    #billing_phone { direction:ltr; text-align:right; }
    .woocommerce .woocommerce-billing-fields { background:#fff; border-radius:var(--radius); padding:28px; box-shadow:var(--shadow); margin-bottom:24px; }
    .woocommerce .woocommerce-billing-fields__field-wrapper { display:block !important; }
    .woocommerce .woocommerce-billing-fields h3 { font-size:1.1rem; font-weight:900; color:var(--navy); margin-bottom:20px; padding-bottom:12px; border-bottom:2px solid var(--gray-light); }
    .woocommerce-checkout-review-order { background:#fff; border-radius:var(--radius); padding:28px; box-shadow:var(--shadow); margin-bottom:24px; }
    .woocommerce-checkout #order_review_heading { font-size:1.1rem; font-weight:900; color:var(--navy); margin-bottom:20px; padding-bottom:12px; border-bottom:2px solid var(--gray-light); }
    .woocommerce table.shop_table { width:100%; border-collapse:collapse; }
    .woocommerce table.shop_table th { padding:10px 0; font-size:0.85rem; font-weight:700; color:var(--gray-text); text-align:right; border-bottom:2px solid var(--gray-light); }
    .woocommerce table.shop_table td { padding:12px 0; border-bottom:1px solid var(--gray-light); font-size:0.95rem; }
    .woocommerce table.shop_table .product-name { font-weight:700; color:var(--navy); }
    .woocommerce table.shop_table .product-total, .woocommerce table.shop_table .order-total td { color:var(--orange); font-weight:900; }
    .cod-highlight { background:rgba(255,107,0,0.06); border:2px solid var(--orange); border-radius:12px; padding:18px 20px; display:flex; align-items:center; gap:16px; margin-bottom:20px; }
    .cod-highlight .icon { font-size:2rem; }
    .cod-highlight .text strong { display:block; font-size:1rem; font-weight:900; color:var(--navy); margin-bottom:4px; }
    .cod-highlight .text span { font-size:0.9rem; color:var(--gray-text); }
    #payment .wc_payment_methods, #payment ul.payment_methods, #payment ul.wc_payment_methods, #payment .payment_box, .woocommerce-privacy-policy-text, .woocommerce-privacy-policy-text p { display:none !important; }
    #payment { background:#fff; border-radius:var(--radius); padding:28px; box-shadow:var(--shadow); margin-bottom:24px; }
    #payment .place-order { margin-top:20px; }
    #payment .place-order #place_order { width:100%; background:linear-gradient(135deg,var(--orange),var(--orange-light)) !important; color:#fff !important; font-family:'Cairo',sans-serif !important; font-size:1.15rem !important; font-weight:900 !important; padding:18px !important; border-radius:10px !important; border:none !important; cursor:pointer !important; box-shadow:0 4px 15px rgba(255,107,0,0.4) !important; transition:transform 0.15s !important; }
    #payment .place-order #place_order:hover { transform:translateY(-2px) !important; }

    /* ── TRUST BADGES ── */
    .checkout-trust-badges { margin-top:20px; padding-top:20px; border-top:1px solid var(--gray-light); display:grid; grid-template-columns:repeat(3,1fr); gap:12px; text-align:center; }
    .checkout-trust-badge { display:flex; flex-direction:column; align-items:center; gap:6px; }
    .checkout-trust-badge .badge-icon { font-size:1.6rem; line-height:1; }
    .checkout-trust-badge .badge-title { font-size:0.78rem; font-weight:800; color:var(--navy); line-height:1.3; }
    .checkout-trust-badge .badge-sub { font-size:0.7rem; color:var(--gray-text); line-height:1.3; }
    @media (max-width:400px) { .checkout-trust-badges { grid-template-columns:repeat(2,1fr); } }

    .houara-footer { background:var(--navy); color:rgba(255,255,255,0.7); text-align:center; padding:24px 20px; font-size:0.85rem; }

    /* ── Hide all fields except name, address, phone ── */
    #billing_last_name_field, #billing_company_field, #billing_country_field,
    #billing_address_2_field, #billing_city_field, #billing_state_field,
    #billing_postcode_field, #billing_email_field,
    .woocommerce-additional-fields, .woocommerce-billing-fields h3 { display:none !important; }
    #billing_first_name_field, #billing_phone_field, #billing_address_1_field { width:100% !important; float:none !important; clear:both !important; }

    @media (max-width:768px) { .checkout-wrapper { padding:0 12px 40px; } .page-hero h1 { font-size:1.3rem; } .checkout-progress-inner { gap:4px; } .progress-divider { min-width:20px; } .woocommerce .woocommerce-billing-fields, .woocommerce-checkout-review-order, #payment { padding:18px; } }
  </style>
</head>
<body class="woocommerce-checkout">
<header class="houara-header">
  <div class="houara-header-inner">
        <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
            <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img" style="height:40px;">
        </a>
    <div class="secure-badge">
      <div class="dot"></div>
      <span>🔒 دفع آمن 100%</span>
    </div>
  </div>
</header>
<div class="checkout-progress">
  <div class="checkout-progress-inner">
    <div class="progress-step done"><div class="num">✓</div><span>السلة</span></div>
    <div class="progress-divider done"></div>
    <div class="progress-step active"><div class="num">2</div><span>تأكيد الطلب</span></div>
    <div class="progress-divider"></div>
    <div class="progress-step"><div class="num">3</div><span>التوصيل</span></div>
  </div>
</div>
<div class="page-hero">
  <h1>✅ إتمام الطلب</h1>
  <p>أدخل بياناتك ليصلك المنتج اليوم، إن قمت بالطلب قبل الساعة 4 مساءً</p>
</div>
<div class="checkout-wrapper">
  <?php
  add_action('woocommerce_review_order_before_payment', function() {
    echo '<div class="cod-highlight"><div class="icon">💵</div><div class="text"><strong>الدفع عند الاستلام</strong><span>ادفع نقداً حين يصلك طلبك — لا بطاقة مطلوبة</span></div></div>';
  });
  add_action('woocommerce_review_order_after_submit', function() {
    echo '<div class="checkout-trust-badges">
      <div class="checkout-trust-badge">
        <span class="badge-icon">🔒</span>
        <span class="badge-title">طلبك آمن 100%</span>
        <span class="badge-sub">بياناتك محمية</span>
      </div>
      <div class="checkout-trust-badge">
        <span class="badge-icon">💵</span>
        <span class="badge-title">دفع عند الاستلام</span>
        <span class="badge-sub">لا بطاقة مطلوبة</span>
      </div>
      <div class="checkout-trust-badge">
        <span class="badge-icon">🚚</span>
        <span class="badge-title">توصيل سريع</span>
        <span class="badge-sub">نفس اليوم لأولاد تايمة</span>
      </div>
    </div>';
  });
  the_content();
  if (!have_posts()) { echo do_shortcode('[woocommerce_checkout]'); }
  ?>
</div>
<?php houarashop_render_footer(); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    function fillHiddenFields() {
        // Fill backend fields silently — customer never sees these
        var lastName = document.getElementById('billing_last_name');
        if (lastName && !lastName.value) lastName.value = '.';

        var country = document.getElementById('billing_country');
        if (country && country.value !== 'MA') {
            country.value = 'MA';
            country.dispatchEvent(new Event('change', { bubbles: true }));
        }

        var city = document.getElementById('billing_city');
        if (city && !city.value) city.value = 'أولاد تايمة';

        var state = document.getElementById('billing_state');
        if (state) state.value = '';

        var zip = document.getElementById('billing_postcode');
        if (zip && !zip.value) zip.value = '83350';

        var email = document.getElementById('billing_email');
        if (email && !email.value) {
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
                hidden.type = 'hidden'; hidden.name = 'payment_method'; hidden.value = 'cod';
                form.appendChild(hidden);
            }
        }
    }
    fillHiddenFields();

    function translateLabels() {
        var fLabel = document.querySelector('label[for="billing_first_name"]');
        if (fLabel && !fLabel.innerHTML.includes('الإسم الكامل')) fLabel.innerHTML = 'الإسم الكامل <abbr class="required" title="مطلوب">*</abbr>';
        // Address is now optional — update label accordingly
        var aLabel = document.querySelector('label[for="billing_address_1"]');
        if (aLabel) aLabel.innerHTML = 'عنوان التوصيل';
        var pLabel = document.querySelector('label[for="billing_phone"]');
        if (pLabel && !pLabel.innerHTML.includes('رقم الهاتف')) pLabel.innerHTML = 'رقم الهاتف <abbr class="required" title="مطلوب">*</abbr>';
    }
    translateLabels();

    function enforcePhoneRequired() {
        var phone = document.getElementById('billing_phone');
        if (phone) {
            phone.setAttribute('required','required');
            phone.setAttribute('type','tel');
            phone.setAttribute('inputmode','tel');
            phone.setAttribute('pattern','[0-9+ ]{9,}');
            if (!phone.placeholder) phone.placeholder = '06XXXXXXXX';
        }
        // Address is no longer required
        var address = document.getElementById('billing_address_1');
        if (address) {
            address.removeAttribute('required');
            if (!address.placeholder) address.placeholder = 'الحي، الشارع...';
        }
    }
    enforcePhoneRequired();

    // Client-side: only block submission if phone is missing
    var checkoutForm = document.querySelector('form.woocommerce-checkout');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            var phone = document.getElementById('billing_phone');
            if (phone) {
                var cleanPhone = phone.value.replace(/[^0-9+]/g, '');
                if (cleanPhone.length < 9) {
                    e.preventDefault(); e.stopPropagation();
                    var existingError = document.getElementById('houara-phone-error');
                    if (!existingError) {
                        var errorDiv = document.createElement('div');
                        errorDiv.id = 'houara-phone-error';
                        errorDiv.style.cssText = 'background:#fff3f3;border:2px solid #e74c3c;border-radius:10px;padding:16px 20px;margin-bottom:20px;color:#c0392b;font-weight:700;direction:rtl;';
                        errorDiv.innerHTML = '⚠️ رقم الهاتف مطلوب لتأكيد الطلب. الرجاء إدخال رقم صحيح (10 أرقام على الأقل)';
                        var wrapper = document.querySelector('.checkout-wrapper');
                        if (wrapper) wrapper.insertBefore(errorDiv, wrapper.firstChild);
                    }
                    phone.focus(); phone.scrollIntoView({ behavior: 'smooth', block: 'center' }); return false;
                } else {
                    var existingError = document.getElementById('houara-phone-error');
                    if (existingError) existingError.remove();
                }
            }
        }, true);
    }

    function hideUnwantedUI() {
        var selectors = [
            '#payment .wc_payment_methods','#payment ul.payment_methods',
            '#payment .payment_box','.woocommerce-privacy-policy-text',
            '.woocommerce-form-coupon-toggle','.checkout_coupon',
            '.woocommerce-account-fields','#createaccount_field',
            '.woocommerce-checkout .woocommerce-message'
        ];
        selectors.forEach(function(sel) {
            document.querySelectorAll(sel).forEach(function(el) {
                el.style.setProperty('display','none','important');
            });
        });
        document.querySelectorAll('.woocommerce-message').forEach(function(el) {
            if (el.textContent.indexOf('سلة مشترياتك') !== -1 || el.textContent.indexOf('تم إضافة') !== -1) {
                el.style.setProperty('display','none','important');
                el.remove();
            }
        });
    }
    hideUnwantedUI();

    if (typeof jQuery !== 'undefined') {
        jQuery(document.body).on('updated_checkout', function() {
            fillHiddenFields();
            translateLabels();
            enforcePhoneRequired();
            hideUnwantedUI();
        });
    }
});
</script>
<?php wp_footer(); ?>
</body>
</html>
