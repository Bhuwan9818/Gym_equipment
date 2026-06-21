<?php
/**
 * Handles all "enquiry" / "callback" form submissions from the public
 * site (the product modal and the homepage callback strip) and stores
 * them in data/enquiries.json so the Admin Panel can list them.
 *
 * Responds with JSON when called via fetch() (the normal path), or
 * redirects back to the referring page for old-fashioned, no-JS
 * form submissions.
 */
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/json');

$is_ajax = (
    (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'fetch')
    || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)
);

function respond($ok, $message, $is_ajax) {
    if ($is_ajax) {
        echo json_encode(['ok' => $ok, 'message' => $message]);
        exit;
    }
    $back = $_SERVER['HTTP_REFERER'] ?? url_for_home();
    $sep = (strpos($back, '?') === false) ? '?' : '&';
    header('Location: ' . $back . $sep . ($ok ? 'sent=1' : 'sent=0'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.', $is_ajax);
}

$type = trim($_POST['type'] ?? 'enquiry');
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$purpose = trim($_POST['purpose'] ?? '');
$product = trim($_POST['product'] ?? '');
$sku = trim($_POST['sku'] ?? '');
$page = trim($_POST['page'] ?? ($_SERVER['HTTP_REFERER'] ?? ''));

if ($phone === '' || mb_strlen($phone) < 7) {
    respond(false, 'Please enter a valid mobile number.', $is_ajax);
}

if ($type !== 'callback' && $name === '') {
    respond(false, 'Please enter your name.', $is_ajax);
}

$entry = [
    'type'    => $type === 'callback' ? 'callback' : 'enquiry',
    'name'    => $name !== '' ? $name : '(not provided)',
    'phone'   => $phone,
    'purpose' => $purpose,
    'product' => $product,
    'sku'     => $sku,
    'page'    => $page,
];

$saved = save_enquiry($entry);

if (!$saved) {
    respond(false, 'Could not save your enquiry right now. Please call us directly.', $is_ajax);
}

respond(true, 'Thank you! Our specialist will call you shortly.', $is_ajax);
