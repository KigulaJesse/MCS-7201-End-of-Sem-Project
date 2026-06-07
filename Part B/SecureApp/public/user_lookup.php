<?php
// secure version of the DVWA SQL injection page
require __DIR__ . '/../src/auth.php';
require __DIR__ . '/../src/db.php';
send_security_headers();
require_login();

$result = null;
$error = '';
$searched = isset($_GET['id']) && $_GET['id'] !== '';

if ($searched) {
    $id = $_GET['id'];

    // input validation: the id must be only digits
    if (!ctype_digit($id)) {
        $error = 'User ID must be a number';
    } else {
        $db = get_db();
        // prepared statement, the value is bound and never becomes part of the query
        $stmt = $db->prepare("SELECT first_name, last_name FROM people WHERE user_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
    }
}
?>
<!doctype html>
<html>
<head><title>User lookup</title><link rel="stylesheet" href="style.css"></head>
<body>
<p><a href="dashboard.php">Back</a></p>
<h2>User lookup</h2>
<form method="get">
    <input type="text" name="id" placeholder="Enter a user id">
    <button type="submit">Look up</button>
</form>
<?php if ($error): ?>
    <p class="error"><?= e($error) ?></p>
<?php elseif ($result): ?>
    <p>First name: <?= e($result['first_name']) ?><br>
       Surname: <?= e($result['last_name']) ?></p>
<?php elseif ($searched): ?>
    <p>No user found.</p>
<?php endif; ?>
</body>
</html>
