<?php

require_once __DIR__ . "/../classes/Database.php";
require_once __DIR__ . "/../services/JsonPlaceholderService.php";

$config = require __DIR__ . "/../config/database.php";

$db = new Database($config);
$service = new JsonPlaceholderService();

$users = $service->getUsers();

$birthDates = [
    1 => "1990-09-05",
    2 => "1988-03-12",
    3 => "1995-07-21",
    4 => "1992-09-18",
    5 => "1985-11-30",
    6 => "1998-01-15",
    7 => "1991-06-08",
    8 => "1994-09-25",
    9 => "1989-04-17",
    10 => "1996-12-03"
];

foreach ($users as $user) {

    $db->insert(
        "INSERT INTO users (id, name, email, active, birth_date)
         VALUES (?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            email = VALUES(email),
            active = VALUES(active),
            birth_date = VALUES(birth_date)",
        [
            $user["id"],
            $user["name"],
            $user["email"],
            1,
            $birthDates[$user["id"]]
        ]
    );
}

echo "Users imported successfully";