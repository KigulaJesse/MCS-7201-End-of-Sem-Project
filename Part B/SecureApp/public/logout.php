<?php
require __DIR__ . '/../src/auth.php';
// clear the session and send the user back to login
$_SESSION = [];
session_destroy();
header('Location: index.php');
exit;
