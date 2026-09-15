<?php

require_once __DIR__ . "/../classes/Database.php";

$config = require __DIR__ . "/../config/database.php";

$db = new Database($config);

$posts = $db->select(
    "SELECT
        u.id AS user_id,
        u.name,
        u.email,
        u.birth_date,
        p.id AS post_id,
        p.title,
        p.content,
        p.created_at
     FROM users u
     INNER JOIN posts p
        ON p.user_id = u.id
     WHERE u.active = 1
       AND p.active = 1
     ORDER BY p.created_at DESC"
);


$birthdayPosts = $db->select(
    "SELECT
        u.id AS user_id,
        u.name,
        u.email,
        u.birth_date,
        p.id AS post_id,
        p.title,
        p.content,
        p.created_at
     FROM users u
     INNER JOIN posts p
        ON p.user_id = u.id
     WHERE u.active = 1
       AND p.active = 1
       AND MONTH(u.birth_date) = MONTH(CURDATE())
       AND p.id = (
            SELECT p2.id
            FROM posts p2
            WHERE p2.user_id = u.id
              AND p2.active = 1
            ORDER BY p2.created_at DESC, p2.id DESC
            LIMIT 1
       )
     ORDER BY u.name"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Posts Feed</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        h1 {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .post {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-name {
            font-weight: bold;
            font-size: 18px;
        }

        .email {
            color: #666;
            font-size: 14px;
        }

        .birthday {
            font-size: 13px;
            margin-top: 4px;
            color: #555;
        }

        .title {
            margin-top: 15px;
            font-size: 20px;
        }

        .content {
            line-height: 1.5;
        }

        .date {
            color: #888;
            font-size: 13px;
            margin-top: 15px;
        }

        .birthday-post {
            border: 2px solid #ddd;
        }

        .birthday-empty {
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

    </style>

</head>


<body>

<div class="container">

    <h1>Birthdays This Month </h1>


    <?php if (empty($birthdayPosts)): ?>

        <div class="birthday-empty">

            No birthdays this month.

        </div>

    <?php else: ?>


        <?php foreach ($birthdayPosts as $birthdayPost): ?>

            <div class="post birthday-post">


                <div class="user-info">

                    <img
                        class="avatar"
                        src="images/default-avatar.jpg"
                        alt="User avatar"
                    >


                    <div>

                        <div class="user-name">

                            <?= htmlspecialchars(
                                $birthdayPost["name"]
                            ) ?>

                        </div>


                        <div class="email">

                            <?= htmlspecialchars(
                                $birthdayPost["email"]
                            ) ?>

                        </div>


                        <div class="birthday">

                            Birthday:

                            <?= htmlspecialchars(
                                $birthdayPost["birth_date"]
                            ) ?>

                        </div>

                    </div>

                </div>


                <h2 class="title">

                    <?= htmlspecialchars(
                        $birthdayPost["title"]
                    ) ?>

                </h2>


                <div class="content">

                    <?= nl2br(
                        htmlspecialchars(
                            $birthdayPost["content"]
                        )
                    ) ?>

                </div>
                <div class="date">

                    Latest post:

                    <?= htmlspecialchars(
                        $birthdayPost["created_at"]
                    ) ?>

                </div>


            </div>

        <?php endforeach; ?>


    <?php endif; ?>

    <h1>Posts Feed</h1>


    <?php foreach ($posts as $post): ?>


        <div class="post">


            <div class="user-info">
                <img
                    class="avatar"
                    src="images/default-avatar.jpg"
                    alt="User avatar"
                >
                <div>
                    <div class="user-name">

                        <?= htmlspecialchars(
                            $post["name"]
                        ) ?>

                    </div>


                    <div class="email">

                        <?= htmlspecialchars(
                            $post["email"]
                        ) ?>

                    </div>

                </div>


            </div>


            <h2 class="title">

                <?= htmlspecialchars(
                    $post["title"]
                ) ?>

            </h2>


            <div class="content">

                <?= nl2br(
                    htmlspecialchars(
                        $post["content"]
                    )
                ) ?>

            </div>
            <div class="date">

                <?= htmlspecialchars(
                    $post["created_at"]
                ) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>