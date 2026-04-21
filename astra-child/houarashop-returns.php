<?php
/**
 * Template Name: HOUARA Return Policy
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
    <h2>سياسة <span>الإرجاع</span></h2>
    <p>كل ما تحتاج معرفته عن إرجاع واستبدال المنتجات</p>
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

<p>في <strong>هوارة شوب</strong> نريدك أن تشتري بثقة كاملة. هذه السياسة تشرح بوضوح كيف يمكنك إرجاع منتج أو طلب استرجاع مبلغ في الحالات المحددة. اقرأها بهدوء قبل الطلب.</p>

<h2>1. القاعدة الذهبية: المعاينة قبل الدفع</h2>
<p>بما أن كل طلباتنا تعمل بنظام <strong>الدفع نقداً عند الاستلام</strong>، لديك الحق الكامل في:</p>
<ul>
  <li><strong>معاينة المنتج</strong> أمام عامل التوصيل قبل أن تدفع</li>
  <li><strong>التأكد من مطابقته</strong> لما طلبته (النوع، اللون، الحجم)</li>
  <li><strong>رفض الطلب كلياً</strong> دون أي رسوم إذا لم يعجبك أو وجدت عيباً</li>
</ul>
<p>هذه هي أسهل طريقة: إن لم تُرض المنتج، لا تدفع. ينتهي الأمر هنا.</p>

<h2>2. الإرجاع بعد الاستلام</h2>
<p>إذا استلمت المنتج ودفعت، ثم اكتشفت لاحقاً مشكلة، يحق لك الإرجاع خلال <strong>48 ساعة</strong> من وقت التوصيل، بشرط توفر إحدى الحالات التالية:</p>
<ul>
  <li>المنتج <strong>معيب أو تالف</strong> من المصنع</li>
  <li>المنتج <strong>لا يطابق الوصف</strong> المذكور في صفحة المنتج</li>
  <li>تم تسليمك <strong>منتجاً مختلفاً</strong> عن الذي طلبته</li>
</ul>

<h2>3. شروط قبول الإرجاع</h2>
<ul>
  <li>أن يكون المنتج <strong>غير مستعمل</strong> أو استعمل بأدنى حد للفحص فقط</li>
  <li>أن يكون في <strong>التغليف الأصلي</strong> مع كل ملحقاته (كابلات، علب، تعليمات...)</li>
  <li>ألا يكون <strong>قد مر على استلامه أكثر من 48 ساعة</strong></li>
  <li>أن تتواصل معنا أولاً قبل إعادة المنتج (لا نقبل الإرجاع بدون تنسيق مسبق)</li>
</ul>

<h2>4. المنتجات غير القابلة للإرجاع</h2>
<p>بعض الفئات لا تُقبل للإرجاع لأسباب صحية أو تقنية:</p>
<ul>
  <li>المنتجات الشخصية التي فُتح غلافها المحكم (سماعات داخل الأذن، منتجات العناية الشخصية...)</li>
  <li>المنتجات المخفّضة بشكل نهائي (مذكور "بيع نهائي" في الصفحة)</li>
  <li>المنتجات التي تعرّضت للتلف بسبب سوء الاستعمال بعد الاستلام</li>
</ul>

<h2>5. كيف تطلب الإرجاع — خطوة بخطوة</h2>
<ol>
  <li><strong>تواصل معنا خلال 48 ساعة</strong> من الاستلام عبر:
    <ul>
      <li>💬 <a href="https://wa.me/212702048470" target="_blank" rel="noopener">واتساب: +212 702 04 84 70</a></li>
      <li>📧 <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
    </ul>
  </li>
  <li><strong>اذكر:</strong> رقم الطلب، اسم المنتج، سبب الإرجاع، وصور واضحة للمشكلة إن وُجدت</li>
  <li>سنرد عليك خلال <strong>24 ساعة</strong> بتأكيد قبول الإرجاع وطريقة استرجاع المنتج</li>
  <li>يأتي عامل التوصيل لاستلام المنتج أو نرتب معك نقطة تسليم قريبة</li>
  <li>بعد فحص المنتج والتأكد من الحالة، نسترجع لك المبلغ</li>
</ol>

<h2>6. استرجاع المبلغ</h2>
<ul>
  <li>بما أن الدفع كان نقداً، <strong>الاسترجاع يكون نقداً</strong> يسلمه عامل التوصيل في زيارة قادمة، أو نتفق معك على طريقة ملائمة</li>
  <li>يتم الاسترجاع خلال <strong>3 إلى 7 أيام عمل</strong> من تاريخ وصول المنتج واستلامه من طرفنا</li>
  <li>في حالة <strong>الاستبدال</strong>، نرسل المنتج البديل دون أي رسوم إضافية</li>
</ul>

<h2>7. من يتحمل رسوم إعادة المنتج</h2>
<ul>
  <li>إذا كان سبب الإرجاع <strong>عيباً في المنتج أو خطأً من طرفنا</strong>: نتحمل نحن رسوم الإعادة بالكامل</li>
  <li>إذا كان الإرجاع <strong>لأنك غيرت رأيك</strong> بعد الاستلام والدفع: قد تطبَّق رسوم رمزية للنقل تُخصم من المبلغ المسترجع (نخبرك بها قبل الموافقة)</li>
</ul>

<h2>8. المنتج وصل تالفاً أو مكسوراً</h2>
<p>إذا لاحظت أن الغلاف الخارجي تالف وقت التسليم، <strong>نرجو منك:</strong></p>
<ul>
  <li>فتح الطرد أمام عامل التوصيل وفحص المنتج</li>
  <li>رفض الاستلام إذا كان المنتج نفسه مكسوراً</li>
  <li>أو استلامه وتوثيق الحالة بالصور فوراً، ثم التواصل معنا في نفس اليوم</li>
</ul>

<h2>9. الضمان</h2>
<p>بعض المنتجات تأتي بضمان من الشركة المصنّعة. في هذه الحالة:</p>
<ul>
  <li>نسلمك بطاقة الضمان (إن وُجدت) مع المنتج</li>
  <li>بعد انتهاء مدة 48 ساعة، يصبح التعامل مع العيوب عبر الضمان الأصلي وليس سياسة الإرجاع</li>
</ul>

<h2>10. الخلاصة السريعة</h2>
<ul>
  <li>✅ <strong>قبل الدفع:</strong> افحص المنتج وارفضه إن لم يعجبك — بدون أي تكلفة</li>
  <li>✅ <strong>خلال 48 ساعة بعد الدفع:</strong> يحق لك الإرجاع لسبب وجيه مع التغليف الأصلي</li>
  <li>❌ <strong>بعد 48 ساعة أو بعد استعمال المنتج:</strong> الإرجاع غير ممكن عدا حالات الضمان</li>
</ul>

<h2>11. التواصل</h2>
<p>لأي طلب إرجاع أو استفسار:</p>
<ul>
  <li>💬 <strong>واتساب (الأسرع):</strong> <a href="https://wa.me/212702048470" target="_blank" rel="noopener">+212 702 04 84 70</a></li>
  <li>📧 <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
  <li>📞 <a href="tel:+212702048470">+212 702 04 84 70</a></li>
</ul>

<p><em>شكراً لثقتك في هوارة شوب.</em></p>
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
