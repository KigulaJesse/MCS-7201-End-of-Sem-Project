<?php
require __DIR__ . '/../src/auth.php';
send_security_headers();
require_login();
?>
<!doctype html>
<html>
<head><title>Secure App - Home</title><link rel="stylesheet" href="style.css"></head>
<body>
<p>Signed in as <?= e($_SESSION['user']) ?> | <a href="logout.php">Logout</a></p>
<h2>Home</h2>
<ul>
    <li><a href="user_lookup.php">User lookup (safe from SQL injection)</a></li>
    <li><a href="greeting.php">Greeting (safe from XSS)</a></li>
    <li><a href="file_view.php">File viewer (safe from path traversal)</a></li>
</ul>
</body>
</html>
