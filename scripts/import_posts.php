<?php

require_once __DIR__ . "/../classes/Database.php";
require_once __DIR__ . "/../services/JsonPlaceholderService.php";

$config = require __DIR__ . "/../config/database.php";

$db = new Database($config);
$service = new JsonPlaceholderService();

$posts = $service->getPosts();

foreach ($posts as $post) {

    $day = (($post["id"] - 1) % 28) + 1;
    $hour = ($post["id"] - 1) % 24;

    $createdAt = sprintf(
        "2026-09-%02d %02d:00:00",
        $day,
        $hour
    );

    $db->insert(
        "INSERT INTO posts
            (id, user_id, title, content, created_at, active)
         VALUES (?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
            user_id = VALUES(user_id),
            title = VALUES(title),
            content = VALUES(content),
            created_at = VALUES(created_at),
            active = VALUES(active)",
        [
            $post["id"],
            $post["userId"],
            $post["title"],
            $post["body"],
            $createdAt,
            1
        ]
    );
}

echo "Posts imported successfully";