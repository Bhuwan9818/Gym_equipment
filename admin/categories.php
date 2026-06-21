<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_login();

$categories = get_categories();
$message = '';
$message_type = 'success';

if (($_GET['saved'] ?? '') === '1') {
    $message = 'Category saved successfully.';
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    csrf_check();
    $id = $_POST['id'] ?? '';
    $in_use = count_products_in_category($id);
    if ($in_use > 0) {
        $message = "Can't delete \"$id\" — it still has $in_use product(s) assigned to it. Move or delete those products first.";
        $message_type = 'error';
    } else {
        $categories = array_values(array_filter($categories, fn($c) => $c['id'] !== $id));
        save_categories($categories);
        $message = 'Category deleted.';
    }
}

$page_title = 'Categories — Admin';
$active = 'categories';
include __DIR__ . '/includes/admin-header.php';
?>
<div class="a-topbar">
  <div><h1>Categories</h1><div class="sub">Top-level product categories shown in the main navigation.</div></div>
  <a href="category-edit.php" class="a-btn a-btn-p">+ Add Category</a>
</div>
<div class="a-content">
  <?php if ($message): ?><div class="a-alert a-alert-<?php echo $message_type; ?>"><?php echo h($message); ?></div><?php endif; ?>

  <div class="a-panel">
    <table class="a-table">
      <thead><tr><th>Category</th><th>Slug (ID)</th><th>Subcategories</th><th>Products</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($categories as $cat): ?>
        <tr>
          <td><strong><?php echo h($cat['name']); ?></strong><br><span style="color:var(--a-text2);font-size:.82rem"><?php echo h($cat['tagline']); ?></span></td>
          <td><code><?php echo h($cat['id']); ?></code></td>
          <td><?php echo h(implode(', ', array_map(fn($s) => $s['name'], $cat['subcategories'] ?? []))); ?></td>
          <td><?php echo count_products_in_category($cat['id']); ?></td>
          <td style="white-space:nowrap">
            <a href="category-edit.php?id=<?php echo urlencode($cat['id']); ?>" class="a-btn a-btn-sm">Edit</a>
            <form method="POST" style="display:inline">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?php echo h($cat['id']); ?>">
              <button type="submit" class="a-btn a-btn-sm a-btn-danger" data-confirm="Delete the &quot;<?php echo h($cat['name']); ?>&quot; category? This can't be undone.">Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
