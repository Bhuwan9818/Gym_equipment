<?php
/**
 * Shared header. Expects (optionally) the following variables to be set
 * by the including page before this file is required:
 *   $page_title        string  — used in <title>
 *   $meta_description  string  — used in meta description
 *   $body_data_theme   string  — 'dark' (default) or 'light'
 */
if (!defined('BASE_PATH')) {
    require_once __DIR__ . '/functions.php';
}
$page_title = $page_title ?? SITE_NAME . ' — ' . SITE_TAGLINE;
$meta_description = $meta_description ?? 'Premium commercial-grade gym equipment for home, professional and corporate gyms across India.';
$categories = get_categories();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo h($page_title); ?></title>
<meta name="description" content="<?php echo h($meta_description); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:ital,wght@0,300;0,400;0,500;0,600;1,300&family=Montserrat:wght@400;500;600;700;900&display=swap" rel="stylesheet">
<!-- Font Awesome for social icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo asset('assets/css/style.css'); ?>">
<script>
  window.SITE_BASE_PATH = <?php echo json_encode(SITE_BASE_PATH); ?>;
  window.ENQUIRE_URL = <?php echo json_encode(url_for_enquire()); ?>;
</script>
</head>
<body>

<!-- CURSOR -->
<div id="cur"><div id="cr"></div><div id="cd"></div></div>

<!-- TOP BAR -->
<div class="top-bar" id="topBar">
  <div class="top-bar-inner">
    <div class="top-bar-left">
      <a href="mailto:<?php echo h(SITE_EMAIL); ?>" class="top-bar-link">
        <i class="fa-solid fa-envelope"></i>
        <span><?php echo h(SITE_EMAIL); ?></span>
      </a>
      <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="top-bar-link">
        <i class="fa-solid fa-phone"></i>
        <span><?php echo h(SITE_PHONE_DISPLAY); ?></span>
      </a>
    </div>
    <div class="top-bar-right">
      <a href="https://www.facebook.com/" target="_blank" rel="noopener" class="top-bar-social" aria-label="Facebook">
        <i class="fa-brands fa-facebook-f"></i>
      </a>
      <a href="https://www.instagram.com/" target="_blank" rel="noopener" class="top-bar-social" aria-label="Instagram">
        <i class="fa-brands fa-instagram"></i>
      </a>
      <a href="https://www.youtube.com/" target="_blank" rel="noopener" class="top-bar-social" aria-label="YouTube">
        <i class="fa-brands fa-youtube"></i>
      </a>
      <a href="https://wa.me/<?php echo h(SITE_WHATSAPP); ?>" target="_blank" rel="noopener" class="top-bar-social" aria-label="WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
      </a>
      <a href="https://www.linkedin.com/" target="_blank" rel="noopener" class="top-bar-social" aria-label="LinkedIn">
        <i class="fa-brands fa-linkedin-in"></i>
      </a>
    </div>
  </div>
</div>

<!-- MOBILE NAV -->
<div class="mob-nav" id="mobNav">
  <a href="<?php echo url_for_home(); ?>">Home</a>
  <a href="<?php echo url_for_home(); ?>#about">About</a>
  <a href="<?php echo url_for_home(); ?>#categories">Category</a>
  <a href="<?php echo SITE_BASE_PATH; ?>/our-vision.php">Our Vision</a>
  <a href="<?php echo url_for_home(); ?>#contact">Contact</a>
  <div class="mob-theme">
    <span id="mobThLbl">Light Mode</span>
    <button class="t-btn" onclick="toggleTheme()" style="cursor:none" id="mobThBtn">☀️</button>
  </div>
  <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="btn-p" style="font-size:.95rem;margin-top:.5rem">📞 Get Quote</a>
</div>

<!-- NAV -->
<nav id="nav">
  <a href="<?php echo url_for_home(); ?>" class="logo">FITRON<em>FITNESS</em></a>
  <ul class="nav-links">
    <li>
      <a href="<?php echo url_for_home(); ?>">Home</a>
    </li>
    <li>
      <a href="<?php echo url_for_home(); ?>#about">About</a>
    </li>
    <li class="nav-dd">
      <a href="<?php echo url_for_home(); ?>#categories">Category</a>
      <div class="nav-dd-menu">
        <?php foreach ($categories as $cat): ?>
          <a href="<?php echo url_for_category($cat['id']); ?>">
            <span><?php echo h($cat['name']); ?></span>
            <small><?php echo product_count_label($cat['id']); ?></small>
          </a>
        <?php endforeach; ?>
      </div>
    </li>
    <li>
      <a href="<?php echo SITE_BASE_PATH; ?>/our-vision.php">Our Vision</a>
    </li>
    <li>
      <a href="<?php echo url_for_home(); ?>#contact">Contact</a>
    </li>
  </ul>
  <div class="nav-r">
    <button class="t-btn" onclick="toggleTheme()" id="deskThBtn" aria-label="Toggle theme">☀️</button>
    <a href="tel:<?php echo h(SITE_PHONE_TEL); ?>" class="btn-nav">Get Quote</a>
    <button class="ham" id="ham" aria-label="Menu"><span></span><span></span><span></span></button>
  </div>
</nav>
