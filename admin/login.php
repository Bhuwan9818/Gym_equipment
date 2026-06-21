<?php
require_once __DIR__ . '/includes/auth.php';

if (admin_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        // Prevent session fixation
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    }
    $error = 'Incorrect username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>Admin Login — <?php echo h(SITE_NAME); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo asset('admin/assets/css/admin.css'); ?>">
</head>
<body>
<div class="a-login-wrap">
  <div class="a-login-box">
    <div class="a-logo">FITRON<em>FITNESS</em></div>
    <p class="sub">Sign in to manage categories, products and enquiries.</p>
    <?php if ($error): ?><div class="a-alert a-alert-error"><?php echo h($error); ?></div><?php endif; ?>
    <form method="POST">
      <?php echo csrf_field(); ?>
      <div class="a-form-row">
        <label for="username">Username</label>
        <input type="text" class="a-input" id="username" name="username" required autofocus value="<?php echo h($_POST['username'] ?? ''); ?>">
      </div>
      <div class="a-form-row">
        <label for="password">Password</label>
        <input type="password" class="a-input" id="password" name="password" required>
      </div>
      <button type="submit" class="a-btn a-btn-p" style="width:100%;justify-content:center;padding:.8rem">Log In →</button>
    </form>
  </div>
</div>
</body>
</html>
