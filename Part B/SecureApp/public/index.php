<?php
// login page
require __DIR__ . '/../src/auth.php';
require __DIR__ . '/../src/db.php';
send_security_headers();

// if already signed in, skip the login page
if (!empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $db = get_db();
    // prepared statement, so the username can never change the query
    $stmt = $db->prepare("SELECT username, password_hash FROM accounts WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    // check the password against the stored hash
    if ($row && password_verify($password, $row['password_hash'])) {
        // new session id on login to stop session fixation
        session_regenerate_id(true);
        $_SESSION['user'] = $row['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        // one generic message, we do not say which part was wrong
        $error = 'Invalid username or password';
    }
}
?>
<!doctype html>
<html>
<head><title>Secure App - Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<h2>Login</h2>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <p>Username: <input type="text" name="username"></p>
    <p>Password: <input type="password" name="password"></p>
    <p><button type="submit">Sign in</button></p>
</form>
<p><small>Demo account: admin / Passw0rd!</small></p>
</body>
</html>
