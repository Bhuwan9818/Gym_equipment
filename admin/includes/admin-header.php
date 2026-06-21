<?php
/**
 * Shared admin layout. Expects:
 *   $page_title (string)
 *   $active     (string) — one of: dashboard, categories, products, enquiries
 * require_admin_login() must already have been called by the including page.
 */
$page_title = $page_title ?? 'Admin — ' . SITE_NAME;
$active = $active ?? '';
$new_enquiries = 0;
foreach (get_enquiries() as $e) { if (empty($e['read'])) $new_enquiries++; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title><?php echo h($page_title); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo asset('admin/assets/css/admin.css'); ?>">
</head>
<body>
<div class="a-shell">
  <aside class="a-sidebar">
    <div class="a-logo">FITRON<em>FITNESS</em><br><span style="font-size:.85rem;letter-spacing:.04em;color:#9296A0">Admin Panel</span></div>
    <nav class="a-nav">
      <a href="<?php echo ADMIN_BASE_PATH; ?>/index.php" class="<?php echo $active === 'dashboard' ? 'active' : ''; ?>">📊 Dashboard</a>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/categories.php" class="<?php echo $active === 'categories' ? 'active' : ''; ?>">🗂️ Categories</a>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/products.php" class="<?php echo $active === 'products' ? 'active' : ''; ?>">🏋️ Products</a>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/enquiries.php" class="<?php echo $active === 'enquiries' ? 'active' : ''; ?>">📩 Enquiries<?php if ($new_enquiries): ?> <span class="a-badge a-badge-new" style="margin-left:.3rem"><?php echo $new_enquiries; ?> new</span><?php endif; ?></a>
    </nav>
    <div class="a-nav-foot">
      <a href="<?php echo ADMIN_BASE_PATH; ?>/generate-hash.php">🔑 Change Password</a>
      <a href="<?php echo url_for_home(); ?>" target="_blank">↗ View Live Site</a>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/logout.php">⏻ Log Out</a>
    </div>
  </aside>
  <div class="a-main">
