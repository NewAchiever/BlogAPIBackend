<?php

require_once '../config/response.php';

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$sql = "INSERT INTO user_post_saved (post_id, user_id, is_saved)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
            is_saved = VALUES(is_saved);";


$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iii", $data['postId'], $_SESSION['user_id'], $data['isSaved']);
$success = mysqli_stmt_execute($stmt);
if ($success) {

    sendResponse(200, []);

} else {

    sendResponse(500, []);

}

?>