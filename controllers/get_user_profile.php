<?php
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'GET'){

    require_once '../config/response.php';
    $sql = "SELECT username, email, profile_pic FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
    $success = mysqli_stmt_execute($stmt);
    $result_1 = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result_1);


    
    $savedPostSQL = "SELECT * FROM posts as p INNER JOIN user_post_saved as ups ON
    p.id = ups.post_id WHERE ups.is_saved = 1 AND ups.user_id = ?";
    $stmt_2 = mysqli_prepare($conn, $savedPostSQL);
    mysqli_stmt_bind_param($stmt_2, "i", $_SESSION['user_id']);
    $success = mysqli_stmt_execute($stmt_2);
    $result_2 = mysqli_stmt_get_result($stmt_2);

    $saved_posts = [];

    while ($row = mysqli_fetch_assoc($result_2)) {
        $saved_posts[] = $row;
    }

    if (!$success) {
        sendResponse(500, [
            "success" => false,
            "message" => "Something went wrong try again later."
        ]);
    } else {        
        sendResponse(200,  [
            "user" => $user,
            "savedPosts" => $saved_posts
        ]);
    }
}


?>