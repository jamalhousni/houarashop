<?php
/**
 * Template Name: HOUARA Terms of Service
 * 
 */
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هوارة-شوب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', sans-serif; direction: rtl; background: #fff; color: #333; }
        a { text-decoration: none; color: inherit; }
        .countdown-bar { background: #FF6B00; padding: 10px 20px; text-align: center; position: sticky; top: 0; z-index: 1000; }
        .countdown-bar p { color: #fff; font-size: 18px; margin: 0; line-height: 1.2; font-weight: 700; }
        #timer { color: #FFE000; font-weight: 900; direction: ltr; display: inline-block; }
        .site-header { background: #1A1A2E; padding: 15px 40px; display: flex; align-items: center; justify-content: space-between; }
        .header-nav { display: flex; gap: 20px; align-items: center; }
        .header-nav a { color: #ccc; font-size: 15px; font-weight: 600; transition: color 0.2s; }
        .header-nav a:hover { color: #FF6B00; }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-cart { background: #FF6B00; color: #fff; padding: 8px 20px; border-radius: 25px; font-weight: 700; font-size: 15px; }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; padding: 5px; }
        .hamburger span { display: block; width: 25px; height: 3px; background: #fff; border-radius: 3px; }
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; }
        .overlay.open { display: block; }
        .mobile-nav { display: none; position: fixed; top: 0; right: 0; width: 280px; height: 100%; background: #1A1A2E; z-index: 9999; padding: 20px; box-shadow: -5px 0 20px rgba(0,0,0,0.3); transform: translateX(100%); transition: transform 0.3s; overflow-y: auto; }
        .mobile-nav.open { transform: translateX(0); }
        .mobile-nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .close-nav { color: #fff; font-size: 24px; cursor: pointer; background: none; border: none; }
        .mobile-nav a { display: block; color: #ccc; font-size: 16px; font-weight: 600; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .mobile-nav a:hover { color: #FF6B00; }
        .mobile-nav-cart { margin-top: 20px; background: #FF6B00 !important; color: #fff !important; padding: 14px 20px !important; border-radius: 8px; text-align: center; font-weight: 700 !important; border: none !important; }
        .section-title { text-align: center; padding: 50px 20px 30px; }
        .section-title h2 { font-size: 30px; font-weight: 900; color: #1A1A2E; margin-bottom: 10px; }
        .section-title h2 span { color: #FF6B00; }
        .section-title p { color: #777; font-size: 16px; }
        .title-line { width: 60px; height: 4px; background: #FF6B00; margin: 12px auto 0; border-radius: 2px; }
        .btn-primary { background: #FF6B00; color: #fff; padding: 16px 40px; border-radius: 8px; font-size: 17px; font-weight: 700; font-family: 'Cairo', sans-serif; border: none; cursor: pointer; transition: all 0.3s; display: inline-block; }
        .btn-primary:hover { background: #e55f00; transform: translateY(-2px); }
        .site-footer { background: #111122; padding: 40px; text-align: center; }
        .footer-logo { margin-bottom: 12px; }
        .footer-tagline { color: #aab4c8; font-size: 14px; margin-bottom: 20px; }
        .footer-links { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; }
        .footer-links a { color: #aab4c8; font-size: 14px; }
        .footer-links a:hover { color: #FF6B00; }
        .footer-copy { color: #555; font-size: 13px; }
        @media (max-width: 768px) {
            .site-header { padding: 12px 20px; }
            .header-nav { display: none; }
            .hamburger { display: flex; }
            .mobile-nav { display: block; }
            .site-footer { padding: 30px 20px; }
        }
    </style>
</head>
<body <?php body_class(); ?>>
<div class="overlay" id="overlay" onclick="closeMenu()"></div>
<nav class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-header">
        <div>
            <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
                <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img site-logo-img--mobile">
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
<div class="countdown-bar">
    <p>
        <span id="promo-text-today" style="display:none;">🚚 اطلب قبل 04:00 مساءاً ليصلك طلبك اليوم &nbsp;&nbsp; ⏱️ الوقت المتبقي: <span id="timer"></span></span>
        <span id="promo-text-tomorrow" style="display:none;">🚀 اطلب الآن لضمان توصيل طلبك خلال 24 ساعة</span>
    </p>
</div>
<header class="site-header">
    <div class="header-left">
        <button class="hamburger" onclick="openMenu()"><span></span><span></span><span></span></button>
        <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
            <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img">
        </a>
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

<div class="section-title" style="margin-top: 40px;">
    <h2>الشروط <span>والأحكام</span></h2>
    <p>القواعد والشروط المنظمة لاستخدامك لمتجرنا</p>
    <div class="title-line"></div>
</div>
<div class="legal-section" style="max-width: 900px; margin: 0 auto; padding: 20px 20px 80px;">
    <div style="background: #fff; border-radius: 16px; padding: 40px 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid #f0f0f0; line-height: 1.9; color: #444; font-size: 17px;">
        <style>
            .legal-section h2 { color: #1A1A2E; margin-top: 35px; margin-bottom: 15px; font-weight: 900; font-size: 24px; position: relative; padding-bottom: 10px; }
            .legal-section h2::after { content: ''; position: absolute; bottom: 0; right: 0; width: 40px; height: 3px; background: #FF6B00; border-radius: 2px; }
            .legal-section p { margin-bottom: 20px; }
            .legal-section ul, .legal-section ol { margin-bottom: 25px; padding-right: 25px; }
            .legal-section li { margin-bottom: 10px; }
            .legal-section a { color: #FF6B00; font-weight: 700; text-decoration: none; }
            .legal-section a:hover { text-decoration: underline; }
            .legal-section strong { color: #1A1A2E; font-weight: 800; }
        </style>
        <p><strong>آخر تحديث:</strong> 21 أبريل 2026</p>

<p>مرحباً بك في <strong>هوارة شوب</strong>. باستخدامك موقعنا أو طلبك لأي منتج، فإنك توافق على الشروط التالية. نرجو قراءتها جيداً قبل إتمام أي طلب.</p>

<h2>1. عن المتجر</h2>
<ul>
  <li><strong>اسم المتجر:</strong> هوارة شوب (Houara Shop)</li>
  <li><strong>الموقع الإلكتروني:</strong> <a href="https://houarashop.com">houarashop.com</a></li>
  <li><strong>المقر:</strong> أولاد تايمة، إقليم تارودانت، جهة سوس-ماسة، المملكة المغربية</li>
  <li><strong>البريد:</strong> <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
  <li><strong>الهاتف / واتساب:</strong> <a href="tel:+212702048470">+212 702 04 84 70</a></li>
</ul>

<h2>2. طبيعة الخدمة</h2>
<p>هوارة شوب متجر إلكتروني محلي يعرض منتجات متنوعة للاستعمال المنزلي والشخصي، مع توصيل محلي مباشر داخل منطقة أولاد تايمة والضواحي. كل المعاملات تخضع للقانون المغربي.</p>

<h2>3. كيفية الطلب</h2>
<ol>
  <li>اختر المنتج وأضفه إلى السلة</li>
  <li>ادخل اسمك، رقم هاتفك، وعنوان التوصيل في صفحة إتمام الطلب</li>
  <li>أكد طلبك — ستصلك مكالمة أو رسالة واتساب من فريقنا لتأكيد الموعد</li>
  <li>استلم المنتج وادفع نقداً عند الاستلام</li>
</ol>
<p>يحق لنا رفض أو إلغاء أي طلب إذا كانت المعلومات المقدمة غير صحيحة أو غير مكتملة، أو في حال عدم تمكننا من الاتصال بك للتأكيد.</p>

<h2>4. التوصيل</h2>
<ul>
  <li><strong>منطقة التغطية:</strong> أولاد تايمة والضواحي المباشرة</li>
  <li><strong>موعد الطلب:</strong> الطلبات قبل <strong>16:00 (الرابعة مساءً)</strong> تُسلّم في نفس اليوم حتى الساعة 23:00</li>
  <li><strong>الطلبات بعد 16:00:</strong> تُسلّم في اليوم الموالي</li>
  <li>قد يتأخر التوصيل لأسباب خارجة عن إرادتنا (أحوال جوية، ازدحام، قوة قاهرة) — سنخبرك فوراً</li>
  <li>من مسؤوليتك التواجد في العنوان المذكور أو توفير من يستلم نيابة عنك</li>
  <li>في حال تعذر الوصول إليك ثلاث مرات متتالية، يُعاد الطلب إلى المخزن</li>
</ul>

<h2>5. الأسعار والدفع</h2>
<ul>
  <li>جميع الأسعار مذكورة بالدرهم المغربي (MAD) وتشمل الضرائب المطبقة</li>
  <li><strong>طريقة الدفع الوحيدة: الدفع نقداً عند الاستلام (COD)</strong></li>
  <li>لا نطلب أي دفعة مسبقة، ولا نجمع بيانات بنكية</li>
  <li>لا توجد رسوم إضافية على التوصيل داخل منطقة التغطية حالياً</li>
  <li>نحتفظ بحق تعديل الأسعار في أي وقت، لكن السعر المعتمد هو السعر المعروض لحظة تأكيد طلبك</li>
</ul>

<h2>6. توفر المنتجات</h2>
<p>نحرص على تحديث المخزون بشكل مستمر، لكن قد يحدث أن ينفد منتج بعد طلبه مباشرة. في هذه الحالة سنتواصل معك فوراً ونقترح عليك:</p>
<ul>
  <li>انتظار عودة المنتج إلى المخزون</li>
  <li>استبداله بمنتج مماثل</li>
  <li>إلغاء الطلب كاملاً</li>
</ul>

<h2>7. المسؤولية</h2>
<ul>
  <li>نبذل جهدنا لعرض المنتجات بصور ومواصفات دقيقة، لكن قد تختلف الصور قليلاً عن الواقع بسبب الإضاءة أو إعدادات الشاشة</li>
  <li>لا نتحمل مسؤولية أي استخدام خاطئ للمنتج لا يتوافق مع التعليمات المرفقة</li>
  <li>مسؤوليتنا القصوى في أي نزاع محدودة بقيمة الطلب المعني</li>
</ul>

<h2>8. الإرجاع والاسترجاع</h2>
<p>شروط الإرجاع مفصلة في صفحة <a href="/return-policy/">سياسة الإرجاع والاسترجاع</a>. تلخيصاً: يمكنك معاينة المنتج عند التوصيل قبل الدفع، ولك حق إرجاع أي منتج معيب خلال 48 ساعة من الاستلام.</p>

<h2>9. الملكية الفكرية</h2>
<p>جميع محتويات الموقع (الشعار، النصوص، الصور، التصميم، الكود) ملك لهوارة شوب، ولا يجوز نسخها أو استعمالها دون إذن كتابي مسبق.</p>

<h2>10. تعديل الشروط</h2>
<p>نحتفظ بحق تعديل هذه الشروط في أي وقت. التعديلات تسري فور نشرها على هذه الصفحة. استمرارك في استخدام الموقع بعد التعديل يعتبر قبولاً ضمنياً للشروط الجديدة.</p>

<h2>11. القانون المطبق وحل النزاعات</h2>
<p>تخضع هذه الشروط للقانون المغربي. في حال نشوء أي نزاع، نسعى لحله ودياً أولاً عبر التواصل المباشر. وفي حال تعذر ذلك، يكون الاختصاص حصرياً <strong>للمحاكم المختصة بدائرة تارودانت، المملكة المغربية</strong>.</p>

<h2>12. التواصل</h2>
<p>لأي سؤال أو شكوى:</p>
<ul>
  <li>📧 <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
  <li>📞 <a href="tel:+212702048470">+212 702 04 84 70</a></li>
  <li>💬 <a href="https://wa.me/212702048470" target="_blank" rel="noopener">واتساب</a></li>
</ul>
    </div>
</div>

<?php houarashop_render_footer(); ?>
<script>
function updateTimer() {
    var now = new Date(), cutoff = new Date(), isPastCutoff = false;
    cutoff.setHours(16, 0, 0, 0);
    if (now >= cutoff) { cutoff.setDate(cutoff.getDate() + 1); isPastCutoff = true; }
    var txtToday = document.getElementById('promo-text-today');
    var txtTomorrow = document.getElementById('promo-text-tomorrow');
    if (txtToday && txtTomorrow) {
        if (isPastCutoff) { txtToday.style.display = 'none'; txtTomorrow.style.display = 'inline'; }
        else { txtToday.style.display = 'inline'; txtTomorrow.style.display = 'none'; }
    }
    var diff = cutoff - now;
    var h = Math.floor(diff / 3600000), m = Math.floor((diff % 3600000) / 60000);
    var timerEl = document.getElementById('timer');
    if (timerEl) timerEl.innerHTML = h + ' h ' + m + ' m';
}
updateTimer(); setInterval(updateTimer, 60000);
function openMenu() { document.getElementById('mobileNav').classList.add('open'); document.getElementById('overlay').classList.add('open'); document.body.style.overflow='hidden'; }
function closeMenu() { document.getElementById('mobileNav').classList.remove('open'); document.getElementById('overlay').classList.remove('open'); document.body.style.overflow=''; }
</script>
<?php wp_footer(); ?>
</body>
</html>
