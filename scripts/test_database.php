<?php

require_once __DIR__ . "/../classes/Database.php";

$config = require __DIR__ . "/../config/database.php";

$db = new Database($config);

$testUserId = 9999;

$db->delete(
    "DELETE FROM users WHERE id = ?",
    [$testUserId]
);

$db->insert(
    "INSERT INTO users (id, name, email, active, birth_date)
     VALUES (?, ?, ?, ?, ?)",
    [
        $testUserId,
        "Test User",
        "test@example.com",
        1,
        "1990-01-01"
    ]
);

echo "After INSERT:\n";

print_r(
    $db->select(
        "SELECT * FROM users WHERE id = ?",
        [$testUserId]
    )
);

$updatedRows = $db->update(
    "UPDATE users SET name = ? WHERE id = ?",
    [
        "Updated User",
        $testUserId
    ]
);

echo "\nUpdated rows: " . $updatedRows . "\n";
echo "After UPDATE:\n";

print_r(
    $db->select(
        "SELECT * FROM users WHERE id = ?",
        [$testUserId]
    )
);

$deletedRows = $db->delete(
    "DELETE FROM users WHERE id = ?",
    [$testUserId]
);

echo "\nDeleted rows: " . $deletedRows . "\n";
echo "After DELETE:\n";

print_r(
    $db->select(
        "SELECT * FROM users WHERE id = ?",
        [$testUserId]
    )
);