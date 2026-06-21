<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_login();

$categories = get_categories();
$editing_id = $_GET['id'] ?? null;
$category = null;
if ($editing_id) {
    foreach ($categories as $c) { if ($c['id'] === $editing_id) { $category = $c; break; } }
    if (!$category) { header('Location: categories.php'); exit; }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $name = trim($_POST['name'] ?? '');
    $slug = $editing_id ? $editing_id : slugify(trim($_POST['slug'] ?? $name));
    $short_name = trim($_POST['short_name'] ?? '');
    $tagline = trim($_POST['tagline'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '') $errors[] = 'Category name is required.';
    if ($slug === '') $errors[] = 'Category slug is required.';

    // Slug uniqueness (only matters when creating new)
    if (!$editing_id) {
        foreach ($categories as $c) {
            if ($c['id'] === $slug) { $errors[] = "A category with the slug \"$slug\" already exists."; break; }
        }
    }

    // Subcategories
    $sub_ids = $_POST['subcat_id'] ?? [];
    $sub_names = $_POST['subcat_name'] ?? [];
    $subcategories = [];
    foreach ($sub_ids as $i => $sid) {
        $sname = trim($sub_names[$i] ?? '');
        $sid = trim($sid);
        if ($sname === '') continue;
        $sid = $sid !== '' ? slugify($sid) : slugify($sname);
        $subcategories[] = ['id' => $sid, 'name' => $sname];
    }

    // Images
    $image_path = $category['image'] ?? '';
    $banner_path = $category['banner_image'] ?? '';
    $uploaded_image = handle_image_upload('image_file', 'assets/images/categories', $slug . '-cover');
    if ($uploaded_image === false) $errors[] = 'Cover image upload failed (allowed types: jpg, png, webp, svg — max 8MB).';
    if ($uploaded_image) $image_path = $uploaded_image;

    $uploaded_banner = handle_image_upload('banner_file', 'assets/images/categories', $slug . '-banner');
    if ($uploaded_banner === false) $errors[] = 'Banner image upload failed (allowed types: jpg, png, webp, svg — max 8MB).';
    if ($uploaded_banner) $banner_path = $uploaded_banner;

    if ($image_path === '') $errors[] = 'A cover image is required (upload one).';
    if ($banner_path === '') $banner_path = $image_path;

    if (empty($errors)) {
        $new_cat = [
            'id' => $slug,
            'name' => $name,
            'short_name' => $short_name !== '' ? $short_name : $name,
            'tagline' => $tagline,
            'description' => $description,
            'image' => $image_path,
            'banner_image' => $banner_path,
            'subcategories' => $subcategories,
        ];

        if ($editing_id) {
            foreach ($categories as $i => $c) {
                if ($c['id'] === $editing_id) { $categories[$i] = $new_cat; break; }
            }
        } else {
            $categories[] = $new_cat;
        }
        save_categories($categories);
        header('Location: categories.php?saved=1');
        exit;
    }
}

$page_title = ($editing_id ? 'Edit' : 'Add') . ' Category — Admin';
$active = 'categories';
include __DIR__ . '/includes/admin-header.php';

// values to repopulate the form (POST takes priority on validation error)
$v = function ($key, $default = '') {
    return $_POST[$key] ?? $default;
};
$f_name = $editing_id ? ($category['name'] ?? '') : '';
$f_slug = $editing_id ? $editing_id : '';
$f_short = $editing_id ? ($category['short_name'] ?? '') : '';
$f_tag = $editing_id ? ($category['tagline'] ?? '') : '';
$f_desc = $editing_id ? ($category['description'] ?? '') : '';
$f_subs = $editing_id ? ($category['subcategories'] ?? []) : [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f_name = $v('name'); $f_short = $v('short_name'); $f_tag = $v('tagline'); $f_desc = $v('description');
    $f_subs = [];
    foreach (($_POST['subcat_id'] ?? []) as $i => $sid) {
        $f_subs[] = ['id' => $sid, 'name' => $_POST['subcat_name'][$i] ?? ''];
    }
}
?>
<div class="a-topbar">
  <div><h1><?php echo $editing_id ? 'Edit Category' : 'Add Category'; ?></h1><div class="sub">Top-level categories appear in the main navigation and homepage.</div></div>
  <a href="categories.php" class="a-btn">← Back to Categories</a>
</div>
<div class="a-content">
  <?php foreach ($errors as $err): ?><div class="a-alert a-alert-error"><?php echo h($err); ?></div><?php endforeach; ?>

  <form method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="a-panel">
      <div class="a-panel-body">
        <div class="a-form-grid">
          <div class="a-form-row">
            <label for="nameInput">Category Name *</label>
            <input type="text" class="a-input" id="nameInput" name="name" required value="<?php echo h($f_name); ?>">
          </div>
          <div class="a-form-row">
            <label for="slugInput">URL Slug *</label>
            <input type="text" class="a-input" id="slugInput" name="slug" required value="<?php echo h($f_slug); ?>" <?php echo $editing_id ? 'readonly style="background:#F4F5F7;color:var(--a-text2)"' : ''; ?>>
            <span class="hint"><?php echo $editing_id ? "Slug can't be changed once products are assigned to this category." : 'Used in the URL, e.g. /category/' . h($f_slug ?: 'your-slug'); ?></span>
          </div>
        </div>
        <div class="a-form-row">
          <label for="shortName">Short Name (used in nav / tabs)</label>
          <input type="text" class="a-input" id="shortName" name="short_name" value="<?php echo h($f_short); ?>" placeholder="e.g. Indoor Equipment">
        </div>
        <div class="a-form-row">
          <label for="tagline">Tagline</label>
          <input type="text" class="a-input" id="tagline" name="tagline" value="<?php echo h($f_tag); ?>" placeholder="One short line shown on the category banner">
        </div>
        <div class="a-form-row">
          <label for="description">Description</label>
          <textarea class="a-textarea" id="description" name="description" placeholder="2–3 sentences shown at the top of the category page"><?php echo h($f_desc); ?></textarea>
        </div>

        <div class="a-form-grid">
          <div class="a-form-row">
            <label>Cover Image <?php echo $editing_id ? '' : '*'; ?></label>
            <?php if ($editing_id && !empty($category['image'])): ?>
              <img src="<?php echo asset($category['image']); ?>" class="a-img-preview" id="coverPreview">
            <?php else: ?>
              <img src="" class="a-img-preview" id="coverPreview" style="display:none">
            <?php endif; ?>
            <input type="file" class="a-input" name="image_file" accept=".jpg,.jpeg,.png,.webp,.svg" data-preview="#coverPreview" onchange="document.getElementById('coverPreview').style.display='block'">
            <span class="hint">Shown in the "Shop by Category" grid on the homepage. Leave blank to keep the current image.</span>
          </div>
          <div class="a-form-row">
            <label>Banner Image</label>
            <?php if ($editing_id && !empty($category['banner_image'])): ?>
              <img src="<?php echo asset($category['banner_image']); ?>" class="a-img-preview" id="bannerPreview">
            <?php else: ?>
              <img src="" class="a-img-preview" id="bannerPreview" style="display:none">
            <?php endif; ?>
            <input type="file" class="a-input" name="banner_file" accept=".jpg,.jpeg,.png,.webp,.svg" data-preview="#bannerPreview" onchange="document.getElementById('bannerPreview').style.display='block'">
            <span class="hint">Wide image shown at the top of the category page. Falls back to the cover image if left blank.</span>
          </div>
        </div>
      </div>
    </div>

    <div class="a-panel">
      <div class="a-panel-head"><h2>Subcategories</h2></div>
      <div class="a-panel-body">
        <div id="specRows">
          <?php foreach ($f_subs as $sc): ?>
            <div class="a-spec-row">
              <input type="text" class="a-input" name="subcat_name[]" placeholder="e.g. Chest & Back" value="<?php echo h($sc['name']); ?>">
              <input type="text" class="a-input" name="subcat_id[]" placeholder="auto from name" value="<?php echo h($sc['id']); ?>">
              <button type="button" class="a-spec-remove" onclick="this.closest('.a-spec-row').remove()" aria-label="Remove">×</button>
            </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="a-btn a-btn-sm" onclick="addSubcatRow()">+ Add Subcategory</button>
        <p class="hint" style="margin-top:.6rem">Subcategories power the filter tabs on the category page. Leave the second box blank to auto-generate a slug from the name.</p>
      </div>
    </div>

    <button type="submit" class="a-btn a-btn-p" style="padding:.85rem 1.8rem">💾 Save Category</button>
    <a href="categories.php" class="a-btn">Cancel</a>
  </form>
</div>
<script>
// Deliberately named differently from admin.js's addSpecRow() (which builds
// specs_key[]/specs_val[] rows for the product form) to avoid the two
// same-named global functions clobbering each other.
function addSubcatRow() {
  const wrap = document.getElementById('specRows');
  const row = document.createElement('div');
  row.className = 'a-spec-row';
  row.innerHTML = '<input type="text" class="a-input" name="subcat_name[]" placeholder="e.g. Chest &amp; Back">' +
    '<input type="text" class="a-input" name="subcat_id[]" placeholder="auto from name">' +
    '<button type="button" class="a-spec-remove" onclick="this.closest(\'.a-spec-row\').remove()" aria-label="Remove">×</button>';
  wrap.appendChild(row);
}
</script>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
