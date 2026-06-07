<?php
// session setup, login checks and csrf helpers
// this file is included at the top of every page

// set safe cookie options before the session starts
session_set_cookie_params([
    'httponly' => true,    // javascript cannot read the session cookie
    'samesite' => 'Lax',   // helps stop cross site request forgery
    'secure'   => false,   // set this to true once the site runs over https
    'path'     => '/',
]);
session_start();

// send a few security headers on every response
function send_security_headers() {
    header("Content-Security-Policy: default-src 'self'");
    header("X-Frame-Options: DENY");              // stops clickjacking
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: no-referrer");
}

// make a csrf token once per session
function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

// check the token that came back with a form post
function check_csrf() {
    $sent = $_POST['csrf'] ?? '';
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $sent)) {
        http_response_code(400);
        exit('Bad request');
    }
}

// block the page if nobody is logged in
function require_login() {
    if (empty($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
}

// short helper for safe output
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
