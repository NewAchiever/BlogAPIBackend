<?php

require_once '../config/response.php';
//$sql = "SELECT * FROM posts WHERE id = ?";

$sql = "SELECT
    p.id,
    p.user_id,
    p.title,
    p.content,


    COALESCE(user_like.is_liked, 0) AS isLiked,
    COALESCE(like_count.total_likes, 0) AS likes

FROM posts AS p

LEFT JOIN user_post_likes AS user_like
    ON user_like.post_id = p.id
    AND user_like.user_id = ?

LEFT JOIN (
    SELECT
        post_id,
        COUNT(*) AS total_likes
    FROM user_post_likes
    WHERE is_liked = 1
    GROUP BY post_id
) AS like_count
    ON like_count.post_id = p.id

WHERE p.id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $postId);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$post = mysqli_fetch_assoc($result);

require 'get_comments.php';

$post['comments'] = $comments; 

sendResponse(200, $post);


?>