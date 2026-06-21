<?php
require_once __DIR__ . '/includes/auth.php';
require_admin_login();

$hash = '';
$new_username = ADMIN_USERNAME;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    $new_username = trim($_POST['username'] ?? ADMIN_USERNAME);
    if ($password === '' || mb_strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = "Passwords don't match.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
}

$page_title = 'Change Admin Password — Admin';
$active = '';
include __DIR__ . '/includes/admin-header.php';
?>
<div class="a-topbar">
  <div><h1>Change Admin Password</h1><div class="sub">Generate a new login hash, then paste it into includes/config.php.</div></div>
</div>
<div class="a-content">
  <div class="a-panel">
    <div class="a-panel-body">
      <?php if (!empty($error)): ?><div class="a-alert a-alert-error"><?php echo h($error); ?></div><?php endif; ?>

      <?php if ($hash): ?>
        <div class="a-alert a-alert-success">
          Hash generated. Copy the two lines below into <code>includes/config.php</code>, replacing the existing <code>ADMIN_USERNAME</code> and <code>ADMIN_PASSWORD_HASH</code> lines, then save the file and log in again with your new password.
        </div>
        <div class="a-form-row">
          <label>New config.php lines</label>
          <textarea class="a-textarea" rows="3" readonly onclick="this.select()" style="font-family:monospace;font-size:.85rem"><?php echo "define('ADMIN_USERNAME', '" . h($new_username) . "');\ndefine('ADMIN_PASSWORD_HASH', '" . h($hash) . "');"; ?></textarea>
        </div>
        <p class="hint">For security, this hash is shown only once and is not saved anywhere by this tool — you must copy it into the file yourself via FTP, your hosting file manager, or a code editor.</p>
      <?php else: ?>
        <form method="POST">
          <?php echo csrf_field(); ?>
          <div class="a-form-row">
            <label for="username">Admin Username</label>
            <input type="text" class="a-input" id="username" name="username" value="<?php echo h($new_username); ?>" required>
          </div>
          <div class="a-form-row">
            <label for="password">New Password</label>
            <input type="password" class="a-input" id="password" name="password" required minlength="8">
            <span class="hint">At least 8 characters.</span>
          </div>
          <div class="a-form-row">
            <label for="confirm">Confirm New Password</label>
            <input type="password" class="a-input" id="confirm" name="confirm" required minlength="8">
          </div>
          <button type="submit" class="a-btn a-btn-p">Generate Hash →</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
