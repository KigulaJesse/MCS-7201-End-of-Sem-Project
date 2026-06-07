<?php
// secure version of the DVWA file inclusion page
require __DIR__ . '/../src/auth.php';
send_security_headers();
require_login();

// whitelist: only these file names are allowed
$allowed = ['file1.txt', 'file2.txt', 'file3.txt'];
$page = $_GET['page'] ?? '';
$content = '';
$error = '';

if ($page !== '') {
    // strict check. anything not on the list is rejected, including ../ tricks
    if (!in_array($page, $allowed, true)) {
        $error = 'ERROR: File not found';
    } else {
        $content = file_get_contents(__DIR__ . '/files/' . $page);
    }
}
?>
<!doctype html>
<html>
<head><title>File viewer</title><link rel="stylesheet" href="style.css"></head>
<body>
<p><a href="dashboard.php">Back</a></p>
<h2>File viewer</h2>
<ul>
    <li><a href="?page=file1.txt">file1.txt</a></li>
    <li><a href="?page=file2.txt">file2.txt</a></li>
    <li><a href="?page=file3.txt">file3.txt</a></li>
</ul>
<?php if ($error): ?>
    <p class="error"><?= e($error) ?></p>
<?php elseif ($content !== ''): ?>
    <pre><?= e($content) ?></pre>
<?php endif; ?>
</body>
</html>
