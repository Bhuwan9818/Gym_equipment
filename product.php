<?php
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$product = get_product($slug);

if (!$product) {
    http_response_code(404);
    $page_title = 'Product Not Found — ' . SITE_NAME;
    include __DIR__ . '/includes/header.php';
    echo '<div class="sec" style="text-align:center">';
    echo '<div class="eyebrow" style="justify-content:center">404</div>';
    echo '<h2 class="sh2">PRODUCT NOT <span class="g">FOUND</span></h2>';
    echo '<p style="color:var(--tx2);margin:1.2rem 0">This product may have been removed or the link is incorrect.</p>';
    echo '<a href="' . url_for_home() . '" class="btn-p">Back to Home →</a>';
    echo '</div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$category = get_category($product['category']);
$related = get_related_products($product, 4);

$page_title = $product['name'] . ' — ' . SITE_NAME;
$meta_description = $product['short_description'];
include __DIR__ . '/includes/header.php';

$wa_text = rawurlencode('Hi, I would like a price quote for ' . $product['name'] . ' (' . $product['sku'] . ').');
?>

<!-- BREADCRUMB -->
<div class="crumb">
  <a href="<?php echo url_for_home(); ?>">Home</a>
  <span class="sep">/</span>
  <?php if ($category): ?>
    <a href="<?php echo url_for_category($category['id']); ?>"><?php echo h($category['name']); ?></a>
    <span class="sep">/</span>
  <?php endif; ?>
  <span class="cur"><?php echo h($product['name']); ?></span>
</div>

<!-- PRODUCT DETAIL -->
<div class="pd-wrap">
  <div class="pd-img reveal">
    <?php if (!empty($product['placeholder'])): ?><div class="pbadge">Sample</div><?php endif; ?>
    <img src="<?php echo asset($product['image']); ?>" alt="<?php echo h($product['name']); ?>">
  </div>
  <div class="pd-info reveal d1">
    <div class="ptag"><?php echo h($category ? get_subcategory_name($category, $product['subcategory']) : ''); ?></div>
    <h1><?php echo h($product['name']); ?></h1>
    <div class="pd-sku">SKU: <?php echo h($product['sku']); ?><?php if (!empty($product['specs']['Model'])): ?> &nbsp;·&nbsp; Model: <?php echo h($product['specs']['Model']); ?><?php endif; ?></div>
    <p class="pd-desc"><?php echo h($product['short_description']); ?></p>
    <div class="pd-price"><?php echo h(format_price($product)); ?><small>Call for the best price, EMI options &amp; delivery timelines</small></div>
    <div class="pd-cta">
      <button class="btn-p" type="button" onclick="enquire('<?php echo h(addslashes($product['name'])); ?>','<?php echo h($product['sku']); ?>')">Enquire Now →</button>
      <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="btn-ghost">📞 Call Now</a>
      <a href="https://wa.me/<?php echo h(SITE_WHATSAPP); ?>?text=<?php echo $wa_text; ?>" class="btn-ghost" target="_blank" rel="noopener">💬 WhatsApp</a>
    </div>

    <?php if (!empty($product['specs'])): ?>
    <div class="pd-specs">
      <h3>Specifications</h3>
      <dl style="margin:0">
        <?php foreach ($product['specs'] as $key => $val): ?>
          <div class="spec-row">
            <dt><?php echo h($key); ?></dt>
            <dd><?php echo h($val); ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>
    <?php endif; ?>

    <?php if (!empty($product['placeholder'])): ?>
      <div class="pd-placeholder-note">
        This is a sample placeholder listing shown so you can see how the <?php echo h($category['name'] ?? 'category'); ?> page works. Replace the illustration and specifications above with your real product photos and data any time from the Admin Panel.
      </div>
    <?php endif; ?>
  </div>
</div>

<?php if (!empty($related)): ?>
<!-- RELATED PRODUCTS -->
<section class="sec related-sec" style="padding-top:0">
  <div class="eyebrow reveal">You May Also Like</div>
  <h2 class="sh2 reveal">RELATED <span class="g">PRODUCTS</span></h2>
  <div class="prod-grid">
    <?php foreach ($related as $i => $rp): ?>
      <a href="<?php echo url_for_product($rp['slug']); ?>" class="pcard reveal d<?php echo ($i % 4) + 1; ?>">
        <div class="pcard-img">
          <img src="<?php echo asset($rp['image']); ?>" alt="<?php echo h($rp['name']); ?>" loading="lazy">
          <div class="pcard-over">
            <button class="enq-btn" type="button" onclick="event.preventDefault();event.stopPropagation();enquire('<?php echo h(addslashes($rp['name'])); ?>','<?php echo h($rp['sku']); ?>')">Enquire Now</button>
          </div>
          <?php if (!empty($rp['placeholder'])): ?><div class="pbadge">Sample</div><?php endif; ?>
        </div>
        <div class="pcard-body">
          <div class="ptag"><?php echo h($category ? get_subcategory_name($category, $rp['subcategory']) : ''); ?></div>
          <div class="pname"><?php echo h($rp['name']); ?></div>
          <div class="pdesc"><?php echo h(mb_strimwidth($rp['short_description'], 0, 90, '…')); ?></div>
          <div class="pprice">On Enquiry <small>/ Call for best price</small></div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- ══ CONTACT / CTA SPLIT ══ -->
<div class="cta-wrap" id="contact">
  <div class="cta-left">
    <div class="eyebrow reveal">Get a Free Quote</div>
    <h2 class="sh2 reveal">LET'S TALK<br>ABOUT YOUR <span class="g">SPACE</span></h2>
    <p class="reveal">Speak with our equipment specialists. Zero pressure — 100% tailored advice for your space and budget.</p>
    <div class="cta-phone-row reveal">
      <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="cta-ph"><div class="cta-ph-ic">📞</div><?php echo h(SITE_PHONE_DISPLAY); ?></a>
      <div class="cta-or">— or drop your number —</div>
      <div class="form-r">
        <input type="tel" class="f-inp" placeholder="Your mobile number" id="phInp">
        <button class="f-sub" type="button" onclick="submitCb()">Call Me</button>
      </div>
    </div>
  </div>
  <div class="cta-right reveal d1">
    <img src="<?php echo asset($product['image']); ?>" alt="<?php echo h($product['name']); ?>" loading="lazy" style="object-fit:<?php echo is_image_svg($product['image']) ? 'contain;background:#111' : 'cover'; ?>">
    <div class="cta-right-ov"></div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
