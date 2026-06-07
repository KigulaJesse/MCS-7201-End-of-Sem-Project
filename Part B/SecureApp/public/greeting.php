<?php
// secure version of the DVWA reflected XSS page
require __DIR__ . '/../src/auth.php';
send_security_headers();
require_login();

$name = $_GET['name'] ?? '';
?>
<!doctype html>
<html>
<head><title>Greeting</title><link rel="stylesheet" href="style.css"></head>
<body>
<p><a href="dashboard.php">Back</a></p>
<h2>Greeting</h2>
<form method="get">
    <input type="text" name="name" placeholder="What's your name?">
    <button type="submit">Submit</button>
</form>
<?php if ($name !== ''): ?>
    <!-- the name is escaped, so a script tag prints as text and never runs -->
    <p>Hello <?= e($name) ?></p>
<?php endif; ?>
</body>
</html>
