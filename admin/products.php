<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_login();

$products = get_products();
$categories = get_categories();
$message = '';
$message_type = 'success';

if (($_GET['saved'] ?? '') === '1') {
    $message = 'Product saved successfully.';
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    csrf_check();
    $slug = $_POST['slug'] ?? '';
    $products = array_values(array_filter($products, fn($p) => $p['slug'] !== $slug));
    save_products($products);
    $message = 'Product deleted.';
}

$filter_cat = $_GET['cat'] ?? '';
$visible = $products;
if ($filter_cat !== '') {
    $visible = array_values(array_filter($visible, fn($p) => $p['category'] === $filter_cat));
}

$page_title = 'Products — Admin';
$active = 'products';
include __DIR__ . '/includes/admin-header.php';
?>
<div class="a-topbar">
  <div><h1>Products</h1><div class="sub"><?php echo count($products); ?> total across <?php echo count($categories); ?> categories.</div></div>
  <a href="product-edit.php" class="a-btn a-btn-p">+ Add Product</a>
</div>
<div class="a-content">
  <?php if ($message): ?><div class="a-alert a-alert-<?php echo $message_type; ?>"><?php echo h($message); ?></div><?php endif; ?>

  <div class="a-panel">
    <div class="a-panel-head">
      <div class="a-toolbar">
        <input type="text" class="a-input a-search" id="tableSearch" placeholder="🔍 Search products by name or SKU...">
        <div class="a-toolbar">
          <a href="products.php" class="a-btn a-btn-sm <?php echo $filter_cat === '' ? 'a-btn-p' : ''; ?>">All</a>
          <?php foreach ($categories as $cat): ?>
            <a href="products.php?cat=<?php echo urlencode($cat['id']); ?>" class="a-btn a-btn-sm <?php echo $filter_cat === $cat['id'] ? 'a-btn-p' : ''; ?>"><?php echo h($cat['short_name'] ?? $cat['name']); ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <table class="a-table">
      <thead><tr><th></th><th>Name</th><th>SKU</th><th>Category</th><th>Subcategory</th><th>Tags</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($visible as $p):
          $cat = get_category($p['category']);
          $search_text = strtolower($p['name'] . ' ' . $p['sku']);
        ?>
        <tr data-search="<?php echo h($search_text); ?>">
          <td><img src="<?php echo asset($p['image']); ?>" class="a-thumb" alt=""></td>
          <td><strong><?php echo h($p['name']); ?></strong></td>
          <td><code><?php echo h($p['sku']); ?></code></td>
          <td><span class="a-badge <?php echo $p['category'] === 'indoor-gym-equipment' ? 'a-badge-indoor' : 'a-badge-outdoor'; ?>"><?php echo h($cat['short_name'] ?? $p['category']); ?></span></td>
          <td><?php echo h($cat ? get_subcategory_name($cat, $p['subcategory']) : $p['subcategory']); ?></td>
          <td>
            <?php if (!empty($p['featured'])): ?><span class="a-badge a-badge-featured">Featured</span><?php endif; ?>
            <?php if (!empty($p['placeholder'])): ?><span class="a-badge a-badge-sample">Sample</span><?php endif; ?>
          </td>
          <td style="white-space:nowrap">
            <a href="<?php echo url_for_product($p['slug']); ?>" target="_blank" class="a-btn a-btn-sm" title="View on site">View</a>
            <a href="product-edit.php?slug=<?php echo urlencode($p['slug']); ?>" class="a-btn a-btn-sm">Edit</a>
            <form method="POST" style="display:inline">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="slug" value="<?php echo h($p['slug']); ?>">
              <button type="submit" class="a-btn a-btn-sm a-btn-danger" data-confirm="Delete &quot;<?php echo h($p['name']); ?>&quot;? This can't be undone.">Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($visible)): ?>
          <tr><td colspan="7"><div class="a-empty">No products found.</div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
