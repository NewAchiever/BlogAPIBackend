<?php

$method = $_SERVER["REQUEST_METHOD"];

if($method === 'GET'){
    

    require '../templates/create_post.html';
    exit;
}
elseif($method === 'POST'){

    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = $_SESSION['user_id'];
    
    $sql = "INSERT INTO posts (title, content, user_id)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $title,
        $content,
        $userId
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Post created successfully";
    } else {
        echo "Failed to create post: " . mysqli_stmt_error($stmt);
    }

}



?>