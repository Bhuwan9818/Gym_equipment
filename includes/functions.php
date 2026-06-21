<?php
/**
 * ============================================================
 *  SHARED HELPER FUNCTIONS
 *  Data access layer (JSON-file based) + small view helpers.
 * ============================================================
 */
require_once __DIR__ . '/config.php';

// ------------------------------------------------------------------
// Low-level JSON read/write helpers
// ------------------------------------------------------------------

function read_json_file($filename) {
    $path = DATA_PATH . '/' . $filename;
    if (!file_exists($path)) {
        return [];
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function write_json_file($filename, $data) {
    $path = DATA_PATH . '/' . $filename;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $fp = fopen($path, 'c+');
    if (!$fp) {
        return false;
    }
    $ok = false;
    if (flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        rewind($fp);
        $ok = (fwrite($fp, $json) !== false);
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
    return $ok;
}

// ------------------------------------------------------------------
// Categories
// ------------------------------------------------------------------

function get_categories() {
    return read_json_file('categories.json');
}

function get_category($slug) {
    foreach (get_categories() as $cat) {
        if ($cat['id'] === $slug) {
            return $cat;
        }
    }
    return null;
}

function get_subcategory_name($category, $subcat_id) {
    if (!$category || empty($category['subcategories'])) {
        return $subcat_id;
    }
    foreach ($category['subcategories'] as $sc) {
        if ($sc['id'] === $subcat_id) {
            return $sc['name'];
        }
    }
    return $subcat_id;
}

function save_categories($data) {
    return write_json_file('categories.json', $data);
}

// ------------------------------------------------------------------
// Products
// ------------------------------------------------------------------

function get_products() {
    return read_json_file('products.json');
}

function save_products($data) {
    return write_json_file('products.json', $data);
}

function get_product($slug) {
    foreach (get_products() as $p) {
        if ($p['slug'] === $slug) {
            return $p;
        }
    }
    return null;
}

function get_products_by_category($category_slug, $subcategory_slug = null) {
    $out = [];
    foreach (get_products() as $p) {
        if ($p['category'] !== $category_slug) continue;
        if ($subcategory_slug && $subcategory_slug !== 'all' && $p['subcategory'] !== $subcategory_slug) continue;
        $out[] = $p;
    }
    return $out;
}

function get_featured_products($limit = 8) {
    $out = [];
    foreach (get_products() as $p) {
        if (!empty($p['featured'])) {
            $out[] = $p;
        }
        if (count($out) >= $limit) break;
    }
    return $out;
}

function get_related_products($product, $limit = 4) {
    $out = [];
    foreach (get_products() as $p) {
        if ($p['slug'] === $product['slug']) continue;
        if ($p['subcategory'] !== $product['subcategory']) continue;
        $out[] = $p;
        if (count($out) >= $limit) break;
    }
    // pad with other products from same category if not enough
    if (count($out) < $limit) {
        foreach (get_products() as $p) {
            if ($p['slug'] === $product['slug']) continue;
            if ($p['category'] !== $product['category']) continue;
            if (in_array($p, $out, true)) continue;
            $already = false;
            foreach ($out as $o) { if ($o['slug'] === $p['slug']) { $already = true; break; } }
            if ($already) continue;
            $out[] = $p;
            if (count($out) >= $limit) break;
        }
    }
    return $out;
}

function count_products_in_category($category_slug) {
    return count(get_products_by_category($category_slug));
}

function product_count_label($category_slug) {
    $n = count_products_in_category($category_slug);
    return $n . ' Product' . ($n === 1 ? '' : 's');
}

// ------------------------------------------------------------------
// SKU / slug helpers (used by the admin panel)
// ------------------------------------------------------------------

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return $text === '' ? 'item' : $text;
}

function unique_slug($desired, $exclude_slug = null) {
    $base = slugify($desired);
    $slug = $base;
    $i = 2;
    $existing = array_column(get_products(), 'slug');
    while (in_array($slug, $existing, true) && $slug !== $exclude_slug) {
        $slug = $base . '-' . $i;
        $i++;
    }
    return $slug;
}

function next_sku($category_slug) {
    $prefix = $category_slug === 'outdoor-gym-equipment' ? 'OGE-OUT-' : 'OGE-IND-';
    $max = 0;
    foreach (get_products() as $p) {
        if (strpos($p['sku'], $prefix) === 0) {
            $num = (int) substr($p['sku'], strlen($prefix));
            if ($num > $max) $max = $num;
        }
    }
    return $prefix . str_pad($max + 1, 3, '0', STR_PAD_LEFT);
}

// ------------------------------------------------------------------
// Enquiries
// ------------------------------------------------------------------

function save_enquiry($data) {
    $enquiries = read_json_file('enquiries.json');
    $data['id'] = uniqid('enq_', true);
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['read'] = false;
    array_unshift($enquiries, $data);
    return write_json_file('enquiries.json', $enquiries);
}

function get_enquiries() {
    return read_json_file('enquiries.json');
}

function save_enquiries($data) {
    return write_json_file('enquiries.json', $data);
}

// ------------------------------------------------------------------
// URL / asset helpers
// ------------------------------------------------------------------

function asset($path) {
    return SITE_BASE_PATH . '/' . ltrim($path, '/');
}

function url_for_home() {
    return SITE_BASE_PATH . '/index.php';
}

function url_for_category($slug, $subcat = null) {
    if (USE_PRETTY_URLS) {
        $url = SITE_BASE_PATH . '/category/' . rawurlencode($slug);
    } else {
        $url = SITE_BASE_PATH . '/category.php?slug=' . rawurlencode($slug);
    }
    if ($subcat && $subcat !== 'all') {
        $url .= (USE_PRETTY_URLS ? '?' : '&') . 'sub=' . rawurlencode($subcat);
    }
    return $url;
}

function url_for_product($slug) {
    if (USE_PRETTY_URLS) {
        return SITE_BASE_PATH . '/product/' . rawurlencode($slug);
    }
    return SITE_BASE_PATH . '/product.php?slug=' . rawurlencode($slug);
}

function url_for_enquire() {
    return SITE_BASE_PATH . '/enquire.php';
}

function h($str) {
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

function format_price($product) {
    if (!empty($product['price_on_enquiry']) || empty($product['price'])) {
        return 'On Enquiry';
    }
    return '₹' . number_format((float) $product['price']);
}

function is_image_svg($path) {
    return strtolower(substr($path, -4)) === '.svg';
}

/**
 * Handles an optional <input type="file"> upload for the admin panel.
 * Returns the new relative path (e.g. "assets/images/products/indoor/foo.jpg")
 * on success, null if no file was submitted, or false on validation failure.
 *
 * $field_name   — name attribute of the file input
 * $dest_rel_dir — destination folder relative to BASE_PATH, e.g. "assets/images/products/indoor"
 * $base_name    — desired filename (without extension), already slugified
 */
function handle_image_upload($field_name, $dest_rel_dir, $base_name) {
    if (empty($_FILES[$field_name]) || $_FILES[$field_name]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES[$field_name];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    $allowed = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'svg' => 'image/svg+xml'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!isset($allowed[$ext])) {
        return false;
    }
    if ($file['size'] > 8 * 1024 * 1024) { // 8MB cap
        return false;
    }
    $dest_dir = BASE_PATH . '/' . trim($dest_rel_dir, '/');
    if (!is_dir($dest_dir)) {
        mkdir($dest_dir, 0755, true);
    }
    $filename = $base_name . '-' . substr(uniqid(), -5) . '.' . $ext;
    $dest_path = $dest_dir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $dest_path)) {
        return false;
    }
    return trim($dest_rel_dir, '/') . '/' . $filename;
}
