<?php
// simple sqlite connection and first time setup
// the database file is created inside the data folder on first run

function get_db() {
    $dataDir = __DIR__ . '/../data';
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0775, true);
    }
    $dbFile = $dataDir . '/app.db';
    $firstRun = !file_exists($dbFile);

    // turn on exceptions so database errors do not pass silently
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if ($firstRun) {
        seed_db($db);
    }
    return $db;
}

function seed_db($db) {
    // table that holds login accounts
    $db->exec("CREATE TABLE accounts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password_hash TEXT NOT NULL
    )");

    // table used by the user lookup feature
    $db->exec("CREATE TABLE people (
        user_id INTEGER PRIMARY KEY,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL
    )");

    // one demo account. the password is stored as a bcrypt hash, never in plain text
    $hash = password_hash('Passw0rd!', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO accounts (username, password_hash) VALUES (?, ?)");
    $stmt->execute(['admin', $hash]);

    // a few people to look up
    $people = [
        [1, 'Admin', 'User'],
        [2, 'Gordon', 'Brown'],
        [3, 'Pablo', 'Picasso'],
        [4, 'Bob', 'Smith'],
    ];
    $ins = $db->prepare("INSERT INTO people (user_id, first_name, last_name) VALUES (?, ?, ?)");
    foreach ($people as $p) {
        $ins->execute($p);
    }
}
