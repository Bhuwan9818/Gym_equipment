<?php
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$category = get_category($slug);

if (!$category) {
    http_response_code(404);
    $page_title = 'Category Not Found — ' . SITE_NAME;
    include __DIR__ . '/includes/header.php';
    echo '<div class="sec" style="text-align:center">';
    echo '<div class="eyebrow" style="justify-content:center">404</div>';
    echo '<h2 class="sh2">CATEGORY NOT <span class="g">FOUND</span></h2>';
    echo '<p style="color:var(--tx2);margin:1.2rem 0">The category you are looking for does not exist or may have been removed.</p>';
    echo '<a href="' . url_for_home() . '" class="btn-p">Back to Home →</a>';
    echo '</div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$sub = $_GET['sub'] ?? 'all';
$products = get_products_by_category($category['id']);
$other_categories = array_values(array_filter(get_categories(), function ($c) use ($category) {
    return $c['id'] !== $category['id'];
}));

$page_title = $category['name'] . ' — ' . SITE_NAME;
$meta_description = $category['description'];
include __DIR__ . '/includes/header.php';
?>

<!-- BREADCRUMB -->
<div class="crumb">
  <a href="<?php echo url_for_home(); ?>">Home</a>
  <span class="sep">/</span>
  <span class="cur"><?php echo h($category['name']); ?></span>
</div>

<!-- CATEGORY BANNER -->
<div class="banner">
  <img src="<?php echo asset($category['banner_image']); ?>" alt="<?php echo h($category['name']); ?>" loading="eager">
  <div class="banner-ov"></div>
  <div class="banner-body">
    <div class="eyebrow"><?php echo product_count_label($category['id']); ?></div>
    <h2><?php echo strtoupper(h($category['name'])); ?></h2>
    <p><?php echo h($category['tagline']); ?></p>
    <a href="#cat-products" class="btn-p">Browse Products ↓</a>
  </div>
</div>

<!-- PRODUCTS -->
<section class="sec prod-sec" id="cat-products">
  <div class="prod-head reveal">
    <div>
      <div class="eyebrow">Our Range</div>
      <h2 class="sh2"><?php echo strtoupper(h($category['short_name'] ?? $category['name'])); ?></h2>
    </div>
    <p><?php echo h($category['description']); ?></p>
  </div>

  <?php if (!empty($category['subcategories'])): ?>
  <div class="tab-row reveal">
    <a href="<?php echo url_for_category($category['id']); ?>" class="tab<?php echo $sub === 'all' ? ' a' : ''; ?>" data-subcat="all">All</a>
    <?php foreach ($category['subcategories'] as $sc): ?>
      <a href="<?php echo url_for_category($category['id'], $sc['id']); ?>" class="tab<?php echo $sub === $sc['id'] ? ' a' : ''; ?>" data-subcat="<?php echo h($sc['id']); ?>"><?php echo h($sc['name']); ?></a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <div class="prod-grid" id="prodGrid">
    <?php if (empty($products)): ?>
      <div class="empty-state">
        <strong>No products here yet</strong>
        Check back soon, or add the first one from the Admin Panel.
      </div>
    <?php else: ?>
      <?php foreach ($products as $i => $p):
        $hidden = ($sub !== 'all' && $p['subcategory'] !== $sub);
      ?>
        <a href="<?php echo url_for_product($p['slug']); ?>"
           class="pcard reveal d<?php echo ($i % 4) + 1; ?>"
           data-subcat="<?php echo h($p['subcategory']); ?>"
           <?php echo $hidden ? 'style="display:none"' : ''; ?>>
          <div class="pcard-img">
            <img src="<?php echo asset($p['image']); ?>" alt="<?php echo h($p['name']); ?>" loading="lazy">
            <div class="pcard-over">
              <button class="enq-btn" type="button" onclick="event.preventDefault();event.stopPropagation();enquire('<?php echo h(addslashes($p['name'])); ?>','<?php echo h($p['sku']); ?>')">Enquire Now</button>
            </div>
            <?php if (!empty($p['placeholder'])): ?><div class="pbadge">Sample</div><?php endif; ?>
          </div>
          <div class="pcard-body">
            <div class="ptag"><?php echo h(get_subcategory_name($category, $p['subcategory'])); ?></div>
            <div class="pname"><?php echo h($p['name']); ?></div>
            <div class="pdesc"><?php echo h(mb_strimwidth($p['short_description'], 0, 90, '…')); ?></div>
            <div class="pprice">On Enquiry <small>/ Call for best price</small></div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<?php if (!empty($other_categories)): ?>
<!-- CROSS-SELL BANNER -->
<div class="banner reveal" style="margin-top:3px">
  <img src="<?php echo asset($other_categories[0]['banner_image']); ?>" alt="<?php echo h($other_categories[0]['name']); ?>" loading="lazy">
  <div class="banner-ov"></div>
  <div class="banner-body">
    <div class="eyebrow">Also Explore</div>
    <h2><?php echo strtoupper(h($other_categories[0]['name'])); ?></h2>
    <p><?php echo h($other_categories[0]['tagline']); ?></p>
    <a href="<?php echo url_for_category($other_categories[0]['id']); ?>" class="btn-p">Browse <?php echo h($other_categories[0]['name']); ?> →</a>
  </div>
</div>
<?php endif; ?>

<!-- ══ CONTACT / CTA SPLIT ══ -->
<div class="cta-wrap" id="contact">
  <div class="cta-left">
    <div class="eyebrow reveal">Get a Free Quote</div>
    <h2 class="sh2 reveal">NEED HELP<br>CHOOSING THE <span class="g">RIGHT</span><br>EQUIPMENT?</h2>
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
    <img src="<?php echo asset($category['banner_image']); ?>" alt="<?php echo h($category['name']); ?>" loading="lazy">
    <div class="cta-right-ov"></div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
