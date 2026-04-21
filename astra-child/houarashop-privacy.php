<?php
/**
 * Template Name: HOUARA Privacy Policy
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
    <h2>سياسة <span>الخصوصية</span></h2>
    <p>كيف نحمي بياناتك ومعلوماتك الشخصية</p>
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

<p>تحترم <strong>هوارة شوب</strong> (houarashop.com) خصوصية زوارها وعملائها، وتلتزم بحماية بياناتك الشخصية وفقاً لأحكام القانون رقم <strong>09-08</strong> المتعلق بحماية الأشخاص الذاتيين تجاه معالجة المعطيات ذات الطابع الشخصي بالمملكة المغربية.</p>

<p>توضح هذه السياسة ما هي البيانات التي نجمعها، ولماذا نجمعها، وكيف نستعملها ونحميها، وما هي حقوقك تجاهها.</p>

<h2>1. من نحن</h2>
<p>هوارة شوب متجر إلكتروني محلي مقره <strong>أولاد تايمة، إقليم تارودانت، جهة سوس-ماسة، المغرب</strong>. للتواصل بخصوص هذه السياسة:</p>
<ul>
  <li>📧 البريد الإلكتروني: <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
  <li>📞 الهاتف / واتساب: <a href="tel:+212702048470">+212 702 04 84 70</a></li>
</ul>

<h2>2. ما هي البيانات التي نجمعها</h2>
<p>نجمع فقط الحد الأدنى من البيانات اللازم لتنفيذ طلبك:</p>
<ul>
  <li><strong>الاسم الكامل</strong> — لمعرفة لمن نسلم الطلب</li>
  <li><strong>رقم الهاتف</strong> — للتواصل قبل التوصيل وإثبات الطلب</li>
  <li><strong>عنوان التوصيل</strong> — لإيصال الطلب إلى مكانك</li>
</ul>

<p>كما نجمع تلقائياً، عبر متصفحك، بعض البيانات التقنية المحدودة:</p>
<ul>
  <li>عنوان IP، نوع المتصفح، نظام التشغيل، نوع الجهاز</li>
  <li>الصفحات التي زرتها وتاريخ الزيارة</li>
  <li>المنتجات التي أضفتها إلى السلة</li>
</ul>

<p><strong>ملاحظة:</strong> نحن <strong>لا نطلب ولا نخزن أي بيانات بنكية</strong>، لأن كل الطلبات تُسدد <strong>نقداً عند الاستلام</strong>.</p>

<h2>3. لماذا نستعمل هذه البيانات</h2>
<ul>
  <li><strong>تنفيذ الطلبات:</strong> تحضير منتجاتك، التواصل معك بخصوص موعد التوصيل، وتسليم الطلب</li>
  <li><strong>تحسين الموقع:</strong> فهم كيف يستخدم الزوار المتجر لنحسن التجربة</li>
  <li><strong>الدعم:</strong> الرد على استفساراتك والتعامل مع أي طلب إرجاع</li>
  <li><strong>التسويق:</strong> قياس فعالية إعلاناتنا (دون إرسال رسائل تسويقية مزعجة)</li>
</ul>

<h2>4. مع من نشارك بياناتك</h2>
<p>نحن <strong>لا نبيع</strong> بياناتك لأي طرف. نشاركها فقط مع الجهات التالية، وبالقدر اللازم لتنفيذ الطلب:</p>
<ul>
  <li><strong>فريق التوصيل المحلي</strong> في أولاد تايمة — يحصل على الاسم والهاتف والعنوان فقط</li>
  <li><strong>منصة الاستضافة (Hostinger)</strong> — تخزن بيانات الموقع على خوادمها</li>
  <li><strong>Google Analytics</strong> و<strong>Meta (Facebook) Pixel</strong> — لإحصائيات الزيارة وقياس الإعلانات (بيانات مجمّعة، لا تُعرّفك شخصياً)</li>
  <li><strong>السلطات المختصة</strong> — فقط في حال طلب قانوني رسمي</li>
</ul>

<h2>5. ملفات تعريف الارتباط (Cookies) وأدوات التتبع</h2>
<p>يستخدم موقعنا ملفات Cookies لتذكر محتويات السلة، وتحسين تجربة التصفح، وقياس أداء الإعلانات. يمكنك تعطيلها من إعدادات متصفحك، لكن ذلك قد يؤثر على عمل بعض ميزات الموقع (مثل السلة وإتمام الطلب).</p>

<h2>5.1 Meta Pixel (فيسبوك بكسل)</h2>
<p>نستخدم أداة <strong>Meta Pixel</strong> من شركة Meta Platforms Ireland Ltd. (المالكة لـ Facebook و Instagram) لقياس فعالية إعلاناتنا وفهم سلوك الزوار على موقعنا. تقوم هذه الأداة تلقائياً بجمع المعلومات التالية:</p>
<ul>
  <li>الصفحات التي زرتها على الموقع</li>
  <li>المنتجات التي عاينتها أو أضفتها إلى السلة</li>
  <li>إتمام الطلب (Purchase)</li>
  <li>عنوان IP، نوع المتصفح، ونوع الجهاز</li>
</ul>
<p>تُرسل هذه البيانات إلى Meta وتُستخدم لعرض إعلانات أكثر ملاءمة لك على Facebook و Instagram، وقياس أداء حملاتنا الإعلانية. تُعالَج بياناتك وفقاً لـ <a href="https://www.facebook.com/privacy/policy" target="_blank" rel="noopener">سياسة الخصوصية لـ Meta</a>.</p>
<p>يمكنك التحكم في إعلانات Meta الموجهة إليك من خلال <a href="https://www.facebook.com/adpreferences" target="_blank" rel="noopener">إعدادات الإعلانات في حسابك على Facebook</a>، أو تعطيل Cookies الطرف الثالث من متصفحك.</p>

<h2>5.2 Google Analytics 4</h2>
<p>نستخدم <strong>Google Analytics 4</strong> من Google Ireland Ltd. لفهم كيفية استخدام الزوار للموقع (الصفحات الأكثر زيارة، مدة الزيارة، مصدر الزيارة) بهدف تحسين تجربتك. تُجمع البيانات بصيغة مجمّعة مجهولة الهوية ولا تُستخدم لتعريفك شخصياً. يمكنك رفض التتبع عبر <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">إضافة إلغاء Google Analytics</a>.</p>

<h2>6. مدة الاحتفاظ بالبيانات</h2>
<ul>
  <li><strong>بيانات الطلب</strong> (الاسم/الهاتف/العنوان): تُحتفظ بها لمدة <strong>3 سنوات</strong> من تاريخ الطلب لأغراض محاسبية وقانونية</li>
  <li><strong>بيانات التصفح والتحليلات:</strong> 14 شهراً كحد أقصى</li>
  <li>بعد انتهاء المدة، تُحذف بشكل نهائي أو تُحوّل إلى صيغة مجمّعة لا تعرّف بأشخاص</li>
</ul>

<h2>7. حماية بياناتك</h2>
<p>نطبق إجراءات تقنية وتنظيمية معقولة لحماية بياناتك من الفقدان أو الوصول غير المشروع:</p>
<ul>
  <li>تشفير الموقع بـ HTTPS (شهادة SSL)</li>
  <li>وصول محدود لإدارة الموقع (مصادقة ثنائية)</li>
  <li>نسخ احتياطية منتظمة عبر استضافة Hostinger</li>
</ul>

<h2>8. حقوقك</h2>
<p>وفقاً للقانون 09-08 المغربي، لك في أي وقت الحق في:</p>
<ul>
  <li><strong>الاطلاع</strong> على البيانات التي نحتفظ بها عنك</li>
  <li><strong>تصحيح</strong> أي بيانات غير دقيقة</li>
  <li><strong>طلب حذف</strong> بياناتك (مع مراعاة الالتزامات القانونية)</li>
  <li><strong>الاعتراض</strong> على معالجة بياناتك لأغراض تسويقية</li>
</ul>
<p>لممارسة أي من هذه الحقوق، راسلنا على: <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a> — وسنرد خلال 30 يوماً كحد أقصى.</p>

<h2>9. الأطفال</h2>
<p>موقعنا ليس موجهاً للأطفال دون 16 سنة، ولا نجمع بياناتهم عن قصد. إذا كنت ولي أمر وعلمت بأن طفلك زودنا ببيانات، تواصل معنا لحذفها فوراً.</p>

<h2>10. تحديثات هذه السياسة</h2>
<p>قد نحدّث هذه السياسة من حين لآخر. سنُشعرك بأي تغيير جوهري عبر إشعار على الموقع. تاريخ آخر تحديث مذكور في أعلى الصفحة.</p>

<h2>11. التواصل والشكاوى</h2>
<p>لأي سؤال بخصوص خصوصيتك، تواصل معنا:</p>
<ul>
  <li>📧 <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
  <li>📞 <a href="tel:+212702048470">+212 702 04 84 70</a></li>
</ul>
<p>كما يمكنك تقديم شكوى لدى <strong>اللجنة الوطنية لمراقبة حماية المعطيات ذات الطابع الشخصي (CNDP)</strong> عبر موقعها <a href="https://www.cndp.ma" target="_blank" rel="noopener">www.cndp.ma</a>.</p>
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
