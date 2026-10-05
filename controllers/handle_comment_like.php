<?php

require_once '../config/response.php';

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$userid = $_SESSION['user_id'];
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


try{
    if($data['isLiked']){

        $sql = "INSERT INTO user_comment_likes (comment_id, user_id, is_liked)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE
                is_liked = VALUES(is_liked)
                ";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $data['commentId'], $userid, $data['isLiked']);

        if (mysqli_stmt_execute($stmt)) {

            sendResponse(200, []);

        } else {

            sendResponse(500, []);

        }
    }
    
    else{
        $sql = "INSERT INTO user_comment_likes (comment_id, user_id, is_liked)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE
                is_liked = VALUES(is_liked)
                ";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $data['commentId'], $userid, $data['isLiked']);

        if (mysqli_stmt_execute($stmt)) {

            sendResponse(200, []);

        } else {

            sendResponse(500, []);

        }
    }

}
catch(mysqli_sql_exception $e){
    
    sendResponse(500, [
        "error" => "Database error"
    ]);

}catch (Throwable $e) {

    sendResponse(500, [
        "error" => "Server error"
    ]);

}




?>