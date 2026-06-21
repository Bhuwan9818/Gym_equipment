<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_login();

$enquiries = get_enquiries();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    if ($action === 'delete') {
        $enquiries = array_values(array_filter($enquiries, fn($e) => $e['id'] !== $id));
        save_enquiries($enquiries);
        $message = 'Enquiry deleted.';
    } elseif ($action === 'mark_read') {
        foreach ($enquiries as &$e) { if ($e['id'] === $id) { $e['read'] = true; } }
        unset($e);
        save_enquiries($enquiries);
        $message = 'Marked as read.';
    } elseif ($action === 'mark_unread') {
        foreach ($enquiries as &$e) { if ($e['id'] === $id) { $e['read'] = false; } }
        unset($e);
        save_enquiries($enquiries);
        $message = 'Marked as unread.';
    } elseif ($action === 'mark_all_read') {
        foreach ($enquiries as &$e) { $e['read'] = true; }
        unset($e);
        save_enquiries($enquiries);
        $message = 'All enquiries marked as read.';
    }
}

$page_title = 'Enquiries — Admin';
$active = 'enquiries';
include __DIR__ . '/includes/admin-header.php';
?>
<div class="a-topbar">
  <div><h1>Enquiries</h1><div class="sub"><?php echo count($enquiries); ?> total submissions from the website contact form and product enquiry modal.</div></div>
  <?php if (!empty($enquiries)): ?>
  <form method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="action" value="mark_all_read">
    <button type="submit" class="a-btn">Mark All Read</button>
  </form>
  <?php endif; ?>
</div>
<div class="a-content">
  <?php if ($message): ?><div class="a-alert a-alert-success"><?php echo h($message); ?></div><?php endif; ?>

  <div class="a-panel">
    <table class="a-table">
      <thead><tr><th></th><th>Name</th><th>Phone</th><th>Type</th><th>Product</th><th>Purpose</th><th>Received</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($enquiries as $e): ?>
        <tr style="<?php echo empty($e['read']) ? 'background:#FFF9F0' : ''; ?>">
          <td><?php echo empty($e['read']) ? '<span class="a-badge a-badge-new">new</span>' : ''; ?></td>
          <td><?php echo h($e['name'] ?? ''); ?></td>
          <td><a href="tel:<?php echo h($e['phone'] ?? ''); ?>"><?php echo h($e['phone'] ?? ''); ?></a></td>
          <td><?php echo h($e['type'] ?? 'enquiry'); ?></td>
          <td><?php echo h($e['product'] ?? '—'); ?> <?php if (!empty($e['sku'])): ?><br><code style="font-size:.78rem"><?php echo h($e['sku']); ?></code><?php endif; ?></td>
          <td><?php echo h($e['purpose'] ?? '—'); ?></td>
          <td><?php echo h($e['created_at'] ?? ''); ?></td>
          <td style="white-space:nowrap">
            <form method="POST" style="display:inline">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="id" value="<?php echo h($e['id']); ?>">
              <?php if (empty($e['read'])): ?>
                <input type="hidden" name="action" value="mark_read">
                <button type="submit" class="a-btn a-btn-sm">Mark Read</button>
              <?php else: ?>
                <input type="hidden" name="action" value="mark_unread">
                <button type="submit" class="a-btn a-btn-sm">Mark Unread</button>
              <?php endif; ?>
            </form>
            <form method="POST" style="display:inline">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?php echo h($e['id']); ?>">
              <button type="submit" class="a-btn a-btn-sm a-btn-danger" data-confirm="Delete this enquiry?">Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($enquiries)): ?>
          <tr><td colspan="8"><div class="a-empty">No enquiries yet. Submissions from the website will appear here.</div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
