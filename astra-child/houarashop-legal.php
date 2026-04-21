<?php
/**
 * Template Name: HOUARA Legal
 * Description: Branded template for legal pages (Privacy / Terms / Return).
 *              All content is baked into this file. The page in WP only needs
 *              to: (1) have the right slug — privacy-policy / terms / return-policy
 *              (2) have this template assigned in Page Attributes.
 *              Page editor content can be empty.
 */
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="google-site-verification" content="-ZId_3E2ruthMpUT7XyHDNysXs1JSxJvN76fFJsC11M" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo wp_get_document_title(); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', sans-serif; direction: rtl; background: #fff; color: #333; }
        a { text-decoration: none; color: inherit; }

        /* Countdown promo bar */
        .countdown-bar { background: #FF6B00; padding: 10px 20px; text-align: center; position: sticky; top: 0; z-index: 1000; }
        .countdown-bar p { color: #fff; font-size: 18px; margin: 0; line-height: 1.2; font-weight: 700; }
        #timer { color: #FFE000; font-weight: 900; direction: ltr; display: inline-block; }

        /* Header */
        .site-header { background: #1A1A2E; padding: 15px 40px; display: flex; align-items: center; justify-content: space-between; }
        .header-nav { display: flex; gap: 20px; align-items: center; }
        .header-nav a { color: #ccc; font-size: 15px; font-weight: 600; transition: color 0.2s; }
        .header-nav a:hover { color: #FF6B00; }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-cart { background: #FF6B00; color: #fff; padding: 8px 20px; border-radius: 25px; font-weight: 700; font-size: 15px; }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; padding: 5px; }
        .hamburger span { display: block; width: 25px; height: 3px; background: #fff; border-radius: 3px; }

        /* Mobile nav */
        .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9998; }
        .overlay.open { display: block; }
        .mobile-nav { display: none; position: fixed; top: 0; right: 0; width: 280px; height: 100%; background: #1A1A2E; z-index: 9999; padding: 20px; box-shadow: -5px 0 20px rgba(0,0,0,0.3); transform: translateX(100%); transition: transform 0.3s; overflow-y: auto; }
        .mobile-nav.open { transform: translateX(0); }
        .mobile-nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .close-nav { color: #fff; font-size: 24px; cursor: pointer; background: none; border: none; }
        .mobile-nav a { display: block; color: #ccc; font-size: 16px; font-weight: 600; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .mobile-nav a:hover { color: #FF6B00; }
        .mobile-nav-cart { margin-top: 20px; background: #FF6B00 !important; color: #fff !important; padding: 14px 20px !important; border-radius: 8px; text-align: center; font-weight: 700 !important; border: none !important; }

        /* Hero title */
        .legal-hero { background: #f8f9fa; padding: 60px 20px 40px; text-align: center; border-bottom: 1px solid #eee; }
        .legal-hero h1 { font-size: 34px; font-weight: 900; color: #1A1A2E; margin-bottom: 10px; }
        .legal-hero .title-line { width: 60px; height: 4px; background: #FF6B00; margin: 14px auto 0; border-radius: 2px; }

        /* Content area */
        .legal-content { max-width: 860px; margin: 0 auto; padding: 50px 24px 80px; }
        .legal-content > p,
        .legal-content > ul,
        .legal-content > ol { color: #3d3d4a; font-size: 17px; line-height: 1.95; margin-bottom: 18px; }
        .legal-content h2 { color: #1A1A2E; font-size: 24px; font-weight: 800; margin: 42px 0 18px; padding-bottom: 10px; border-bottom: 2px solid #FF6B00; display: inline-block; }
        .legal-content h3 { color: #1A1A2E; font-size: 19px; font-weight: 700; margin: 28px 0 12px; }
        .legal-content strong { color: #1A1A2E; font-weight: 700; }
        .legal-content a { color: #FF6B00; font-weight: 600; border-bottom: 1px dashed rgba(255,107,0,0.4); transition: color 0.2s, border-color 0.2s; }
        .legal-content a:hover { color: #1A1A2E; border-bottom-color: #1A1A2E; }
        .legal-content ul,
        .legal-content ol { padding-right: 26px; }
        .legal-content li { margin-bottom: 10px; line-height: 1.9; }
        .legal-content li ul,
        .legal-content li ol { margin-top: 8px; margin-bottom: 8px; }
        .legal-content em { color: #666; font-style: italic; }

        /* Mobile */
        @media (max-width: 768px) {
            .site-header { padding: 12px 20px; }
            .header-nav { display: none; }
            .hamburger { display: flex; }
            .mobile-nav { display: block; }
            .legal-hero { padding: 40px 20px 30px; }
            .legal-hero h1 { font-size: 26px; }
            .legal-content { padding: 36px 18px 60px; }
            .legal-content > p,
            .legal-content > ul,
            .legal-content > ol { font-size: 16px; }
            .legal-content h2 { font-size: 21px; margin-top: 32px; }
            .legal-content h3 { font-size: 17px; }
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

<?php
// ─────────────────────────────────────────────────────────────
// Pick which legal content to show, based on the page slug.
// Slugs MUST match: privacy-policy, terms, return-policy.
// ─────────────────────────────────────────────────────────────
$houara_slug = '';
if ( is_singular() ) {
    $houara_post = get_post();
    if ( $houara_post ) { $houara_slug = $houara_post->post_name; }
}
?>

<section class="legal-hero">
    <h1><?php the_title(); ?></h1>
    <div class="title-line"></div>
</section>

<main class="legal-content">

<?php if ( $houara_slug === 'privacy-policy' ) : ?>

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

    <h3>5.1 Meta Pixel (فيسبوك بكسل)</h3>
    <p>نستخدم أداة <strong>Meta Pixel</strong> من شركة Meta Platforms Ireland Ltd. (المالكة لـ Facebook و Instagram) لقياس فعالية إعلاناتنا وفهم سلوك الزوار على موقعنا. تقوم هذه الأداة تلقائياً بجمع المعلومات التالية:</p>
    <ul>
      <li>الصفحات التي زرتها على الموقع</li>
      <li>المنتجات التي عاينتها أو أضفتها إلى السلة</li>
      <li>إتمام الطلب (Purchase)</li>
      <li>عنوان IP، نوع المتصفح، ونوع الجهاز</li>
    </ul>
    <p>تُرسل هذه البيانات إلى Meta وتُستخدم لعرض إعلانات أكثر ملاءمة لك على Facebook و Instagram، وقياس أداء حملاتنا الإعلانية. تُعالَج بياناتك وفقاً لـ <a href="https://www.facebook.com/privacy/policy" target="_blank" rel="noopener">سياسة الخصوصية لـ Meta</a>.</p>
    <p>يمكنك التحكم في إعلانات Meta الموجهة إليك من خلال <a href="https://www.facebook.com/adpreferences" target="_blank" rel="noopener">إعدادات الإعلانات في حسابك على Facebook</a>، أو تعطيل Cookies الطرف الثالث من متصفحك.</p>

    <h3>5.2 Google Analytics 4</h3>
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

<?php elseif ( $houara_slug === 'terms' ) : ?>

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
    <p>شروط الإرجاع مفصلة في صفحة <a href="<?php echo esc_url( home_url('/return-policy/') ); ?>">سياسة الإرجاع والاسترجاع</a>. تلخيصاً: يمكنك معاينة المنتج عند التوصيل قبل الدفع، ولك حق إرجاع أي منتج معيب خلال 48 ساعة من الاستلام.</p>

    <h2>9. الملكية الفكرية</h2>
    <p>جميع محتويات الموقع (الشعار، النصوص، الصور، التصميم، الكود) ملك لهوارة شوب، ولا يجوز نسخها أو استعمالها دون إذن كتابي مسبق.</p>

    <h2>10. تعديل الشروط</h2>
    <p>نحتفظ بحق تعديل هذه الشروط في أي وقت. التعديلات تسري فور نشرها على هذه الصفحة. استمرارك في استخدام الموقع بعد التعديل يعتبر قبولاً ضمنياً للشروط الجديدة.</p>

    <h2>11. القانون المطبق وحل النزاعات</h2>
    <p>تخضع هذه الشروط للقانون المغربي. في حال نشوء أي نزاع، نسعى لحله ودياً أولاً عبر التواصل المباشر. وفي حال تعذر ذلك، يكون الاختصاص حصرياً <strong>للمحاكم المختصة بدائرة تارودانت، المملكة المغربية</strong>.</p>

    <h2>12. التواصل</h2>
    <ul>
      <li>📧 <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
      <li>📞 <a href="tel:+212702048470">+212 702 04 84 70</a></li>
      <li>💬 <a href="https://wa.me/212702048470" target="_blank" rel="noopener">واتساب</a></li>
    </ul>

<?php elseif ( $houara_slug === 'return-policy' ) : ?>

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
    <ul>
      <li>💬 <strong>واتساب (الأسرع):</strong> <a href="https://wa.me/212702048470" target="_blank" rel="noopener">+212 702 04 84 70</a></li>
      <li>📧 <a href="mailto:houarashop.store@gmail.com">houarashop.store@gmail.com</a></li>
      <li>📞 <a href="tel:+212702048470">+212 702 04 84 70</a></li>
    </ul>
    <p><em>شكراً لثقتك في هوارة شوب.</em></p>

<?php else : ?>

    <p>لم يتم العثور على المحتوى. تأكد من أن رابط الصفحة (slug) أحد القيم التالية: <code>privacy-policy</code>, <code>terms</code>, <code>return-policy</code>.</p>

<?php endif; ?>

</main>

<?php if ( function_exists( 'houarashop_render_footer' ) ) { houarashop_render_footer(); } ?>

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
updateTimer();
setInterval(updateTimer, 60000);
function openMenu() { document.getElementById('mobileNav').classList.add('open'); document.getElementById('overlay').classList.add('open'); document.body.style.overflow='hidden'; }
function closeMenu() { document.getElementById('mobileNav').classList.remove('open'); document.getElementById('overlay').classList.remove('open'); document.body.style.overflow=''; }
</script>

<?php wp_footer(); ?>
</body>
</html>
