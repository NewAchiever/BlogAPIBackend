<?php

$method = $_SERVER["REQUEST_METHOD"];


if($method === 'POST'){

    $post_id = $_POST['blog_id'];
    $comment_id = $_POST['comment_id'];
    $reply = $_POST['reply'];
    
    $sql = "INSERT INTO comments (comment, post_id, comment_id)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $reply,
        $post_id,
        $comment_id
    );

    if (mysqli_stmt_execute($stmt)) {
        header('Location: /blog_api/public/get_post');
    } else {
        header('Location: /blog_api/public/get_post');
    }

}



?>