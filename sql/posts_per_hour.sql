SELECT
    HOUR(created_at) AS post_hour,
    COUNT(*) AS total_posts
FROM posts
WHERE active = 1
GROUP BY HOUR(created_at)
ORDER BY post_hour;