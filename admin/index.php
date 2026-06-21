<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_login();

$products = get_products();
$categories = get_categories();
$enquiries = get_enquiries();

$indoor_count = count(array_filter($products, fn($p) => $p['category'] === 'indoor-gym-equipment'));
$outdoor_count = count(array_filter($products, fn($p) => $p['category'] === 'outdoor-gym-equipment'));
$placeholder_count = count(array_filter($products, fn($p) => !empty($p['placeholder'])));
$new_enquiry_count = count(array_filter($enquiries, fn($e) => empty($e['read'])));

$page_title = 'Dashboard — Admin';
$active = 'dashboard';
include __DIR__ . '/includes/admin-header.php';
?>
<div class="a-topbar">
  <div>
    <h1>Dashboard</h1>
    <div class="sub">Welcome back, <?php echo h($_SESSION['admin_username'] ?? 'admin'); ?>.</div>
  </div>
  <a href="<?php echo ADMIN_BASE_PATH; ?>/product-edit.php" class="a-btn a-btn-p">+ Add Product</a>
</div>
<div class="a-content">

  <div class="a-grid">
    <div class="a-stat"><div class="num"><?php echo count($products); ?></div><div class="lbl">Total Products</div></div>
    <div class="a-stat"><div class="num accent"><?php echo $indoor_count; ?></div><div class="lbl">Indoor Gym Equipment</div></div>
    <div class="a-stat"><div class="num accent"><?php echo $outdoor_count; ?></div><div class="lbl">Outdoor Gym Equipment</div></div>
    <div class="a-stat"><div class="num"><?php echo $new_enquiry_count; ?></div><div class="lbl">New Enquiries</div></div>
  </div>

  <?php if ($placeholder_count > 0): ?>
    <div class="a-alert a-alert-info">
      You have <strong><?php echo $placeholder_count; ?></strong> sample/placeholder product<?php echo $placeholder_count===1?'':'s'; ?> in the Outdoor Gym Equipment category. Edit them under <a href="<?php echo ADMIN_BASE_PATH; ?>/products.php">Products</a> to add your real photos and specifications whenever you're ready.
    </div>
  <?php endif; ?>

  <div class="a-panel">
    <div class="a-panel-head">
      <h2>Categories</h2>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/categories.php" class="a-btn a-btn-sm">Manage Categories →</a>
    </div>
    <table class="a-table">
      <thead><tr><th>Category</th><th>Subcategories</th><th>Products</th></tr></thead>
      <tbody>
        <?php foreach ($categories as $cat): ?>
        <tr>
          <td><strong><?php echo h($cat['name']); ?></strong></td>
          <td><?php echo count($cat['subcategories'] ?? []); ?></td>
          <td><?php echo count_products_in_category($cat['id']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="a-panel">
    <div class="a-panel-head">
      <h2>Recent Enquiries</h2>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/enquiries.php" class="a-btn a-btn-sm">View All →</a>
    </div>
    <?php $recent = array_slice($enquiries, 0, 5); ?>
    <?php if (empty($recent)): ?>
      <div class="a-empty">No enquiries received yet. They'll show up here as soon as a visitor submits the contact form.</div>
    <?php else: ?>
    <table class="a-table">
      <thead><tr><th>Name</th><th>Phone</th><th>Product</th><th>Received</th></tr></thead>
      <tbody>
        <?php foreach ($recent as $e): ?>
        <tr>
          <td><?php echo h($e['name'] ?? ''); ?> <?php if (empty($e['read'])): ?><span class="a-badge a-badge-new">new</span><?php endif; ?></td>
          <td><?php echo h($e['phone'] ?? ''); ?></td>
          <td><?php echo h($e['product'] ?? '—'); ?></td>
          <td><?php echo h($e['created_at'] ?? ''); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>

</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
