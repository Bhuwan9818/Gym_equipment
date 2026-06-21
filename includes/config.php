<?php
/**
 * ============================================================
 *  SITE CONFIGURATION
 *  Edit the values below to match your business details.
 * ============================================================
 */

// ---- Basic site info -------------------------------------------------
define('SITE_NAME', 'FITRONFITNESS');
define('SITE_TAGLINE', 'Premium Gym Equipment — India');
define('SITE_PHONE_DISPLAY', '99111 15960');
define('SITE_PHONE_TEL', '+919911115960');
define('SITE_WHATSAPP', '919911115960'); // digits only, with country code, no +
define('SITE_EMAIL', 'shashank995390@gmail.com');
define('SITE_ADDRESS', 'Ground Floor, Plot No. 660, Khasra No. 1111 & 1116, Unnamed Road, Bhalswa Jahangir Puri, New Delhi, Delhi, India, 110033');

// ---- File system paths (needed before path auto-detection below) ------
define('BASE_PATH', dirname(__DIR__));
define('DATA_PATH', BASE_PATH . '/data');

// ---- URL / path setup --------------------------------------------------
// SITE_BASE_PATH is auto-detected below by comparing this folder's real
// filesystem path against your server's document root — this is what
// makes css/js/images and links work correctly whether the site lives at
// your domain root (https://example.com/) or in a sub-folder
// (https://example.com/shop/), with NO manual editing needed.
//
// If you ever see broken CSS/images/links and the auto-detection below
// isn't getting it right for your particular host, set this to a fixed
// value instead (e.g. '/shop', or '' for the domain root) and it will be
// used as-is instead of being auto-detected.
define('SITE_BASE_PATH_OVERRIDE', null);

function detect_site_base_path() {
    if (SITE_BASE_PATH_OVERRIDE !== null) {
        return rtrim(SITE_BASE_PATH_OVERRIDE, '/');
    }
    $doc_root = $_SERVER['DOCUMENT_ROOT'] ?? '';
    if ($doc_root === '') {
        return '';
    }
    $doc_root_real = realpath($doc_root);
    $project_real = realpath(BASE_PATH);
    if ($doc_root_real === false || $project_real === false) {
        return '';
    }
    // Normalize slashes (Windows/XAMPP/WAMP use backslashes) and compare
    // case-insensitively (Windows drive letters can differ in case).
    $doc_root_norm = rtrim(str_replace('\\', '/', $doc_root_real), '/');
    $project_norm = rtrim(str_replace('\\', '/', $project_real), '/');
    if (stripos($project_norm, $doc_root_norm) === 0) {
        return rtrim(substr($project_norm, strlen($doc_root_norm)), '/');
    }
    return '';
}
define('SITE_BASE_PATH', detect_site_base_path());

// Pretty URLs like /category/indoor-gym-equipment and
// /product/vertical-chest-press require your web server to actively apply
// the rewrite rules in the included .htaccess (Apache's mod_rewrite module
// enabled, AND "AllowOverride All" set for this folder). Most shared/cPanel
// hosting already has this on by default — but local XAMPP/WAMP/MAMP
// installs commonly ship with .htaccess overrides DISABLED, in which case
// those URLs hit Apache's own 404 page before PHP ever runs (showing up as
// a blank, unstyled page with no products/categories).
//
// Defaulting to false here means the site works everywhere out of the box,
// using category.php?slug=... / product.php?slug=... links instead. Once
// you've confirmed pretty URLs actually work on your server (visit
// /category/indoor-gym-equipment directly and check it's not a blank/plain
// 404), set this to true.
define('USE_PRETTY_URLS', false);


// ---- Admin panel --------------------------------------------------------
// Default login: username "admin", password "ChangeMe123!"
// CHANGE THIS IMMEDIATELY using admin/generate-hash.php — see README.md
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$xwnJVrm7WZ73LHhEiMKK7.UkeJGKM54CqzdvHTaIAPmT13EbKHxDK');

// Random secret used to make the session cookie name unique to this site.
define('ADMIN_SESSION_NAME', 'fitron_admin_session');

// ---- Misc -----------------------------------------------------------
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
