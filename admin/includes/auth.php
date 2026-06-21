<?php
/**
 * Admin authentication helpers.
 * require_once this at the top of every protected admin page.
 */
require_once __DIR__ . '/../../includes/functions.php';

session_name(ADMIN_SESSION_NAME);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function admin_is_logged_in() {
    return !empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_admin_login() {
    if (!admin_is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

function csrf_check() {
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(400);
        die('Security check failed. Please go back, refresh the page, and try again.');
    }
}

define('ADMIN_BASE_PATH', SITE_BASE_PATH . '/admin');
