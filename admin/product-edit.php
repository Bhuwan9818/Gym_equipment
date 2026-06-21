<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_login();

$categories = get_categories();
$products = get_products();
$editing_slug = $_GET['slug'] ?? null;
$product = null;
if ($editing_slug) {
    foreach ($products as $p) { if ($p['slug'] === $editing_slug) { $product = $p; break; } }
    if (!$product) { header('Location: products.php'); exit; }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $name = trim($_POST['name'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $category_id = trim($_POST['category'] ?? '');
    $subcategory_id = trim($_POST['subcategory'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $featured = isset($_POST['featured']);
    $placeholder = isset($_POST['placeholder']);
    $price_on_enquiry = isset($_POST['price_on_enquiry']);
    $price = trim($_POST['price'] ?? '');

    $slug_input = trim($_POST['slug'] ?? '');
    $slug = $slug_input !== '' ? slugify($slug_input) : slugify($name);
    $slug = unique_slug($slug, $editing_slug);

    if ($name === '') $errors[] = 'Product name is required.';
    if ($sku === '') $errors[] = 'SKU is required.';
    if ($category_id === '' || !get_category($category_id)) $errors[] = 'Please choose a valid category.';
    if ($subcategory_id === '') $errors[] = 'Please choose a subcategory.';
    if ($short_description === '') $errors[] = 'A short description is required.';

    // SKU uniqueness
    foreach ($products as $p) {
        if ($p['sku'] === $sku && $p['slug'] !== $editing_slug) {
            $errors[] = "SKU \"$sku\" is already used by another product.";
            break;
        }
    }

    // Specs
    $specs = [];
    foreach (($_POST['specs_key'] ?? []) as $i => $k) {
        $k = trim($k);
        $val = trim($_POST['specs_val'][$i] ?? '');
        if ($k === '' || $val === '') continue;
        $specs[$k] = $val;
    }

    // Image
    $image_path = $product['image'] ?? '';
    $upload_dir = 'assets/images/products/' . ($category_id !== '' ? $category_id : 'misc');
    $uploaded = handle_image_upload('image_file', $upload_dir, $slug);
    if ($uploaded === false) $errors[] = 'Image upload failed (allowed types: jpg, png, webp, svg — max 8MB).';
    if ($uploaded) $image_path = $uploaded;
    if ($image_path === '') $errors[] = 'A product photo is required.';

    if (empty($errors)) {
        $new_product = [
            'sku' => $sku,
            'slug' => $slug,
            'name' => $name,
            'category' => $category_id,
            'subcategory' => $subcategory_id,
            'image' => $image_path,
            'short_description' => $short_description,
            'specs' => $specs,
            'price_on_enquiry' => $price_on_enquiry || $price === '',
            'featured' => $featured,
            'placeholder' => $placeholder,
        ];
        if ($price !== '' && !$price_on_enquiry) {
            $new_product['price'] = $price;
        }

        if ($editing_slug) {
            foreach ($products as $i => $p) {
                if ($p['slug'] === $editing_slug) { $products[$i] = $new_product; break; }
            }
        } else {
            $products[] = $new_product;
        }
        save_products($products);
        header('Location: products.php?saved=1');
        exit;
    }
}

$page_title = ($editing_slug ? 'Edit' : 'Add') . ' Product — Admin';
$active = 'products';
include __DIR__ . '/includes/admin-header.php';

$is_failed_post = ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errors));

$f_name = $is_failed_post ? ($_POST['name'] ?? '') : ($product['name'] ?? '');
$f_slug = $is_failed_post ? ($_POST['slug'] ?? '') : ($editing_slug ?? '');
$f_sku = $is_failed_post ? ($_POST['sku'] ?? '') : ($product['sku'] ?? next_sku($categories[0]['id'] ?? ''));
$f_category = $is_failed_post ? ($_POST['category'] ?? '') : ($product['category'] ?? ($categories[0]['id'] ?? ''));
$f_subcategory = $is_failed_post ? ($_POST['subcategory'] ?? '') : ($product['subcategory'] ?? '');
$f_desc = $is_failed_post ? ($_POST['short_description'] ?? '') : ($product['short_description'] ?? '');
$f_featured = $is_failed_post ? isset($_POST['featured']) : ($product['featured'] ?? false);
$f_placeholder = $is_failed_post ? isset($_POST['placeholder']) : ($product['placeholder'] ?? false);
// Default to checked for a brand-new (never-submitted) form; otherwise reflect
// the most recent known state (failed-POST submission, or existing product).
if ($is_failed_post) {
    $f_price_oe = isset($_POST['price_on_enquiry']);
} elseif ($product) {
    $f_price_oe = $product['price_on_enquiry'] ?? true;
} else {
    $f_price_oe = true;
}
$f_price = $is_failed_post ? ($_POST['price'] ?? '') : ($product['price'] ?? '');
$f_specs = $product['specs'] ?? [];
if ($is_failed_post) {
    $f_specs = [];
    foreach (($_POST['specs_key'] ?? []) as $i => $k) {
        $f_specs[$k] = $_POST['specs_val'][$i] ?? '';
    }
}

?>
<div class="a-topbar">
  <div><h1><?php echo $editing_slug ? 'Edit Product' : 'Add Product'; ?></h1><div class="sub">Fill in the details below — fields marked * are required.</div></div>
  <a href="products.php" class="a-btn">← Back to Products</a>
</div>
<div class="a-content">
  <?php foreach ($errors as $err): ?><div class="a-alert a-alert-error"><?php echo h($err); ?></div><?php endforeach; ?>

  <form method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="a-panel">
      <div class="a-panel-body">
        <div class="a-form-grid">
          <div class="a-form-row">
            <label for="nameInput">Product Name *</label>
            <input type="text" class="a-input" id="nameInput" name="name" required value="<?php echo h($f_name); ?>">
          </div>
          <div class="a-form-row">
            <label for="slugInput">URL Slug</label>
            <input type="text" class="a-input" id="slugInput" name="slug" value="<?php echo h($f_slug); ?>" placeholder="auto-generated from name">
            <span class="hint">Used in the product URL. Changing this on an existing product will change its live URL.</span>
          </div>
        </div>
        <div class="a-form-grid">
          <div class="a-form-row">
            <label for="skuInput">SKU *</label>
            <input type="text" class="a-input" id="skuInput" name="sku" required value="<?php echo h($f_sku); ?>">
          </div>
          <div class="a-form-row">
            <label for="categorySelect">Category *</label>
            <select class="a-select" id="categorySelect" name="category" required onchange="updateSubcatOptions()">
              <?php foreach ($categories as $cat): ?>
                <option value="<?php echo h($cat['id']); ?>" <?php echo $f_category === $cat['id'] ? 'selected' : ''; ?>><?php echo h($cat['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="a-form-row">
          <label for="subcategorySelect">Subcategory *</label>
          <select class="a-select" id="subcategorySelect" name="subcategory" required></select>
        </div>
        <div class="a-form-row">
          <label for="shortDesc">Short Description *</label>
          <textarea class="a-textarea" id="shortDesc" name="short_description" required placeholder="1-2 sentences shown on product cards and the product page"><?php echo h($f_desc); ?></textarea>
        </div>

        <div class="a-form-grid">
          <div class="a-form-row">
            <div class="a-checkbox-row"><input type="checkbox" id="priceOe" name="price_on_enquiry" <?php echo $f_price_oe ? 'checked' : ''; ?> onchange="document.getElementById('priceRow').style.display=this.checked?'none':'block'"><label for="priceOe" style="margin:0">Show "On Enquiry" (no public price)</label></div>
          </div>
          <div class="a-form-row" id="priceRow" style="display:<?php echo $f_price_oe ? 'none' : 'block'; ?>">
            <label for="priceInput">Price (₹)</label>
            <input type="number" class="a-input" id="priceInput" name="price" value="<?php echo h($f_price); ?>" min="0" step="1">
          </div>
        </div>

        <div class="a-form-grid">
          <div class="a-form-row"><div class="a-checkbox-row"><input type="checkbox" id="featuredCb" name="featured" <?php echo $f_featured ? 'checked' : ''; ?>><label for="featuredCb" style="margin:0">Show on homepage (Featured)</label></div></div>
          <div class="a-form-row"><div class="a-checkbox-row"><input type="checkbox" id="placeholderCb" name="placeholder" <?php echo $f_placeholder ? 'checked' : ''; ?>><label for="placeholderCb" style="margin:0">Mark as sample / placeholder listing</label></div></div>
        </div>

        <div class="a-form-row">
          <label>Product Photo <?php echo $editing_slug ? '' : '*'; ?></label>
          <?php if ($editing_slug && !empty($product['image'])): ?>
            <img src="<?php echo asset($product['image']); ?>" class="a-img-preview" id="imgPreview">
          <?php else: ?>
            <img src="" class="a-img-preview" id="imgPreview" style="display:none">
          <?php endif; ?>
          <input type="file" class="a-input" name="image_file" accept=".jpg,.jpeg,.png,.webp,.svg" data-preview="#imgPreview" onchange="document.getElementById('imgPreview').style.display='block'">
          <span class="hint">Square product photo on a white background works best. Leave blank to keep the current photo.</span>
        </div>
      </div>
    </div>

    <div class="a-panel">
      <div class="a-panel-head"><h2>Specifications</h2></div>
      <div class="a-panel-body">
        <div id="specRows">
          <?php foreach ($f_specs as $k => $val): ?>
            <div class="a-spec-row">
              <input type="text" class="a-input" name="specs_key[]" placeholder="e.g. Main Frame" value="<?php echo h($k); ?>">
              <input type="text" class="a-input" name="specs_val[]" placeholder="e.g. Rectangular Steel Tube" value="<?php echo h($val); ?>">
              <button type="button" class="a-spec-remove" onclick="this.closest('.a-spec-row').remove()" aria-label="Remove">×</button>
            </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="a-btn a-btn-sm" onclick="addSpecRow()">+ Add Specification</button>
        <p class="hint" style="margin-top:.6rem">These appear as rows in the specifications table on the product page, in the order shown here.</p>
      </div>
    </div>

    <button type="submit" class="a-btn a-btn-p" style="padding:.85rem 1.8rem">💾 Save Product</button>
    <a href="products.php" class="a-btn">Cancel</a>
  </form>
</div>

<script>
const CATEGORIES_DATA = <?php echo json_encode($categories, JSON_HEX_TAG); ?>;
const CURRENT_SUBCAT = <?php echo json_encode($f_subcategory); ?>;

function updateSubcatOptions() {
  const catSelect = document.getElementById('categorySelect');
  const subSelect = document.getElementById('subcategorySelect');
  const cat = CATEGORIES_DATA.find(c => c.id === catSelect.value);
  subSelect.innerHTML = '';
  if (!cat) return;
  (cat.subcategories || []).forEach(sc => {
    const opt = document.createElement('option');
    opt.value = sc.id;
    opt.textContent = sc.name;
    if (sc.id === CURRENT_SUBCAT) opt.selected = true;
    subSelect.appendChild(opt);
  });
}
updateSubcatOptions();
</script>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
