<?php
require_once '../config/response.php';


$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$userid = $_SESSION['user_id'];
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*
$sql = "SELECT
    c.id,
    c.user_id,
    c.comment,
    c.comment_id,
    u.username
FROM comments AS c
INNER JOIN users AS u
    ON u.id = c.user_id
WHERE c.comment_id = ?";
*/
$sql="SELECT
    c.id,
    c.user_id,
    c.comment,
    c.comment_id,
    u.username,

    COALESCE(user_like.is_liked, 0) AS isLiked,
    COALESCE(like_count.total_likes, 0) AS likes,
    COALESCE(reply_count.total_replies, 0) AS total_replies

FROM comments AS c

INNER JOIN users AS u
    ON u.id = c.user_id

-- Current user's like status
LEFT JOIN user_comment_likes AS user_like
    ON user_like.comment_id = c.id
    AND user_like.user_id = ?

-- Total likes for each reply
LEFT JOIN (
    SELECT
        comment_id,
        COUNT(*) AS total_likes
    FROM user_comment_likes
    WHERE is_liked = 1
    GROUP BY comment_id
) AS like_count
    ON like_count.comment_id = c.id

-- Total direct replies for each reply
LEFT JOIN (
    SELECT
        comment_id,
        COUNT(*) AS total_replies
    FROM comments
    WHERE comment_id IS NOT NULL
    GROUP BY comment_id
) AS reply_count
    ON reply_count.comment_id = c.id

-- Get replies of the specified comment
WHERE c.comment_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $data["commentId"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);


sendResponse(200, $comments);

?>