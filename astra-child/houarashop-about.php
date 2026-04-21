<?php
/**
 * Template Name: HOUARA About
 * Description: صفحة من نحن — هوارة شوب
 */
defined('ABSPATH') || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>من نحن — هوارة شوب</title>
  <?php wp_head(); ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
  <style>
    :root { --orange:#FF6B00; --orange-light:#FF8C00; --navy:#1A1A2E; --navy-light:#2a2a45; --white:#ffffff; --gray-bg:#f8f9fa; --gray-light:#e8e8e8; --gray-text:#666; --shadow:0 4px 20px rgba(0,0,0,0.08); --radius:14px; }
    * { margin:0; padding:0; box-sizing:border-box; }
    html { direction:rtl; }
    body { font-family:'Cairo','Segoe UI',sans-serif; background:#fff; color:#333; }
    a { text-decoration:none; color:inherit; }

    .countdown-bar { background:var(--orange); padding:10px 20px; text-align:center; }
    .countdown-bar p { color:#fff; font-size:0.95rem; font-weight:700; margin:0; line-height:1.3; }
    #timer { color:#FFE000; font-weight:900; direction:ltr; display:inline-block; }

    .site-header { background:var(--navy); padding:15px 40px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1000; box-shadow:0 4px 20px rgba(0,0,0,0.1); }
    .header-left { display:flex; align-items:center; gap:15px; }
    .header-nav { display:flex; gap:20px; align-items:center; }
    .header-nav a { color:#ccc; font-size:15px; font-weight:600; transition:color 0.2s; }
    .header-nav a:hover { color:var(--orange); }
    .header-nav a.active { color:var(--orange); }
    .header-cart { background:var(--orange); color:#fff; padding:8px 20px; border-radius:25px; font-weight:700; font-size:15px; }
    .hs-hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; background:none; border:none; padding:5px; }
    .hs-hamburger span { display:block; width:25px; height:3px; background:#fff; border-radius:3px; }
    .hs-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9998; }
    .hs-overlay.open { display:block; }
    .hs-mobile-nav { display:none; position:fixed; top:0; right:0; width:280px; height:100%; background:var(--navy); z-index:9999; padding:20px; box-shadow:-5px 0 20px rgba(0,0,0,0.3); transform:translateX(100%); transition:transform 0.3s; overflow-y:auto; }
    .hs-mobile-nav.open { transform:translateX(0); }
    .mobile-nav-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; padding-bottom:15px; border-bottom:1px solid rgba(255,255,255,0.1); }
    .close-nav { color:#fff; font-size:24px; cursor:pointer; background:none; border:none; }
    .hs-mobile-nav a { display:block; color:#ccc; font-size:16px; font-weight:600; padding:15px 0; border-bottom:1px solid rgba(255,255,255,0.07); }
    .hs-mobile-nav a:hover { color:var(--orange); }
    .mobile-nav-cart { margin-top:20px; background:var(--orange) !important; color:#fff !important; padding:14px 20px !important; border-radius:8px; text-align:center; font-weight:700 !important; }

    .about-hero { background:linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%); color:#fff; padding:70px 20px 60px; text-align:center; }
    .about-hero .badge { display:inline-block; background:rgba(255,107,0,0.18); color:var(--orange); border:1px solid rgba(255,107,0,0.3); padding:6px 18px; border-radius:25px; font-size:13px; font-weight:700; margin-bottom:18px; }
    .about-hero h1 { font-size:2.4rem; font-weight:900; margin-bottom:12px; line-height:1.2; }
    .about-hero h1 span { color:var(--orange); }
    .about-hero p { font-size:1.05rem; color:rgba(255,255,255,0.85); max-width:680px; margin:0 auto; line-height:1.65; }

    .about-wrapper { max-width:900px; margin:0 auto; padding:60px 20px; }
    .about-section { margin-bottom:48px; }
    .about-section:last-child { margin-bottom:0; }
    .about-section h2 { display:flex; align-items:center; gap:12px; font-size:1.5rem; font-weight:900; color:var(--navy); margin-bottom:18px; padding-bottom:10px; border-bottom:3px solid var(--orange); width:fit-content; }
    .about-section h2 .ico { font-size:1.6rem; }
    .about-section p { font-size:1rem; line-height:1.85; color:#444; margin-bottom:14px; }

    .pillars { display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; margin:36px 0; }
    .pillar { background:var(--gray-bg); border:1px solid var(--gray-light); border-radius:var(--radius); padding:24px 20px; text-align:center; transition:all 0.2s; }
    .pillar:hover { transform:translateY(-4px); border-color:var(--orange); box-shadow:0 8px 24px rgba(0,0,0,0.06); }
    .pillar .pi { font-size:2.4rem; margin-bottom:12px; }
    .pillar h3 { font-size:1.05rem; font-weight:800; color:var(--navy); margin-bottom:8px; }
    .pillar p { font-size:0.9rem; color:#666; line-height:1.55; margin:0; }

    .about-cta { background:linear-gradient(135deg, #25D366, #1ebe5a); color:#fff; padding:40px 20px; text-align:center; border-radius:var(--radius); margin-top:40px; }
    .about-cta h3 { font-size:1.35rem; font-weight:900; margin-bottom:8px; }
    .about-cta p { font-size:0.95rem; margin-bottom:20px; opacity:0.95; }
    .about-cta .btn { display:inline-block; background:#fff; color:#25D366; padding:13px 30px; border-radius:10px; font-weight:800; font-size:1rem; transition:transform 0.2s; }
    .about-cta .btn:hover { transform:translateY(-2px); }

    @media (max-width:768px) {
      .site-header { padding:12px 20px; }
      .header-nav { display:none; }
      .hs-hamburger { display:flex; }
      .hs-mobile-nav { display:block; }
      .about-hero { padding:50px 18px 40px; }
      .about-hero h1 { font-size:1.8rem; }
      .about-wrapper { padding:40px 18px; }
      .about-section h2 { font-size:1.25rem; }
      .pillars { grid-template-columns:1fr; gap:14px; }
    }
  </style>
</head>
<body <?php body_class(); ?>>
<div class="hs-overlay" id="hsOverlay" onclick="closeHSDrawer()"></div>

<!-- MOBILE NAV -->
<nav class="hs-mobile-nav" id="hsMobileNav">
  <div class="mobile-nav-header">
    <div>
      <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
        <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img site-logo-img--mobile">
      </a>
    </div>
    <button class="close-nav" onclick="closeHSDrawer()">✕</button>
  </div>
  <a href="<?php echo home_url('/'); ?>">🏠 الرئيسية</a>
  <a href="<?php echo home_url('/matjar/'); ?>">🛍️ المتجر</a>
  <a href="<?php echo home_url('/من-نحن/'); ?>">ℹ️ من نحن</a>
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
    <button class="hs-hamburger" onclick="openHSDrawer()"><span></span><span></span><span></span></button>
    <a href="<?php echo home_url('/'); ?>" class="logo-img-link">
      <img src="https://houarashop.com/wp-content/uploads/2026/04/cropped-Adobe-Express-file.png" alt="هوارة شوب" class="site-logo-img">
    </a>
  </div>
  <nav class="header-nav">
    <a href="<?php echo home_url('/'); ?>">الرئيسية</a>
    <a href="<?php echo home_url('/matjar/'); ?>">المتجر</a>
    <a href="<?php echo home_url('/من-نحن/'); ?>" class="active">من نحن</a>
    <a href="<?php echo home_url('/contact/'); ?>">تواصل معنا</a>
    <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">حسابي</a>
  </nav>
  <a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>" class="header-cart">
    🛒 (<span class="cart-count-badge"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?></span>)
  </a>
</header>

<!-- HERO -->
<section class="about-hero">
  <span class="badge">📍 من قلب أولاد تايمة</span>
  <h1>من نحن — <span>هوارة شوب</span></h1>
  <p>متجرك المحلي في قلب أولاد تايمة. أنشأناه لنخدم منطقة هوارة بسرعة وأمانة، ونوصل لك ما تحتاجه في نفس يوم الطلب.</p>
</section>

<!-- BODY -->
<div class="about-wrapper">

  <div class="about-section">
    <h2><span class="ico">🎯</span> مهمتنا</h2>
    <p>أنشأنا هوارة شوب من هنا، من أولاد تايمة، لنكون أقرب متجر إلكتروني لك. متجر يفهم حاجيات منطقة هوارة، ويحترم وقتك وثقتك. رؤيتنا بسيطة: أن نوصل لك المنتجات التي تحتاجها في يوم الطلب نفسه، بأسعار عادلة ودون أي تعقيد.</p>
    <p>نؤمن بأن التجارة الإلكترونية المحلية يجب أن تكون قريبة من الناس، لا بعيدة عنهم. لهذا نعمل من المنطقة، نعرف شوارعها وأحياءها، ونتعامل مع كل عميل كجار وصديق.</p>
  </div>

  <div class="about-section">
    <h2><span class="ico">⭐</span> ما يميزنا</h2>
    <p>نحن لسنا متجراً بعيداً في مدينة أخرى. نحن جيرانك. كل طلب تضعه يذهب مباشرة إلى فريقنا المحلي الذي يعرف شوارع أولاد تايمة وضواحيها، ويحرص على أن يصلك طلبك قبل نهاية اليوم إذا طلبت قبل الساعة 4 مساءً.</p>
    <p>ولا تدفع إلا عند استلام المنتج ومعاينته بيدك. لا بطاقة بنكية، لا تحويلات معقدة. فقط منتج تطلبه، يصلك إلى باب بيتك، وتدفع نقداً عند الاستلام.</p>
  </div>

  <div class="pillars">
    <div class="pillar">
      <div class="pi">🚚</div>
      <h3>توصيل نفس اليوم</h3>
      <p>اطلب قبل 4 مساءً، يصلك قبل 11 ليلاً داخل أولاد تايمة.</p>
    </div>
    <div class="pillar">
      <div class="pi">💵</div>
      <h3>الدفع عند الاستلام</h3>
      <p>عاين المنتج أولاً ثم ادفع نقداً. لا مخاطرة، لا التزام مسبق.</p>
    </div>
    <div class="pillar">
      <div class="pi">💬</div>
      <h3>دعم محلي مباشر</h3>
      <p>فريق الدعم متاح كل يوم عبر الواتساب من 8 صباحاً حتى 11 ليلاً.</p>
    </div>
  </div>

  <div class="about-section">
    <h2><span class="ico">🤝</span> التزامنا تجاهك</h2>
    <p>نلتزم بثلاثة مبادئ نقف وراءها: منتجات بجودة نضمنها، توصيل سريع لا نَعِد به إلا ما نستطيع تحقيقه، ودعم مباشر عبر الواتساب قبل الطلب وبعده. إذا لم يعجبك شيء أو واجهت أي مشكلة، تواصل معنا مباشرة وسنجد حلاً.</p>
    <p>نحرص على أن تكون كل تجربة شراء معنا تجربة بسيطة وآمنة وسريعة. لأن ثقتك أغلى من أي طلبية.</p>
  </div>

  <div class="about-section">
    <h2><span class="ico">🌍</span> رؤيتنا للمستقبل</h2>
    <p>اليوم نخدم أولاد تايمة ومنطقة هوارة. غداً سنوسّع خدمتنا إلى أكادير والجهات المجاورة، وبعدها — إن شاء الله — إلى باقي سوس ماسة. هدفنا أن نصبح الخيار الأول لكل بيت مغربي يبحث عن متجر محلي يثق به.</p>
    <p>نبني اليوم بصبر ومسؤولية، حتى يكون لك متجر محلي حقيقي تعتمد عليه لسنوات قادمة.</p>
  </div>

  <div class="about-cta">
    <h3>هل لديك سؤال أو تحتاج مساعدة؟</h3>
    <p>تواصل معنا مباشرة عبر الواتساب — نحن هنا كل يوم من 8 صباحاً إلى 11 ليلاً</p>
    <a href="https://wa.me/212702048470?text=مرحبا، أريد الاستفسار عن منتج" target="_blank" class="btn">💬 ابدأ المحادثة الآن</a>
  </div>

</div>

<!-- FOOTER -->
<?php houarashop_render_footer(); ?>

<script>
function updateTimer() {
    var now = new Date(), cutoff = new Date(), isPastCutoff = false;
    cutoff.setHours(16, 0, 0, 0);
    if (now >= cutoff) { cutoff.setDate(cutoff.getDate() + 1); isPastCutoff = true; }
    var txtToday = document.getElementById('promo-text-today');
    var txtTomorrow = document.getElementById('promo-text-tomorrow');
    if (txtToday && txtTomorrow) {
        if (isPastCutoff) { txtToday.style.display='none'; txtTomorrow.style.display='inline'; }
        else { txtToday.style.display='inline'; txtTomorrow.style.display='none'; }
    }
    var diff = cutoff - now;
    var h = Math.floor(diff / 3600000), m = Math.floor((diff % 3600000) / 60000);
    var timerEl = document.getElementById('timer');
    if (timerEl) timerEl.innerHTML = h + ' h ' + m + ' m';
}
updateTimer(); setInterval(updateTimer, 60000);
function openHSDrawer() { document.getElementById('hsMobileNav').classList.add('open'); document.getElementById('hsOverlay').classList.add('open'); document.body.style.overflow='hidden'; }
function closeHSDrawer() { document.getElementById('hsMobileNav').classList.remove('open'); document.getElementById('hsOverlay').classList.remove('open'); document.body.style.overflow=''; }
jQuery(document).ready(function($) {
    $.post("<?php echo admin_url('admin-ajax.php'); ?>", {action:"houara_cart_count"}, function(data) {
        if (data && data.success && data.data) $(".cart-count-badge").text(data.data.count);
    });
});
</script>
<?php wp_footer(); ?>
</body>
</html>
