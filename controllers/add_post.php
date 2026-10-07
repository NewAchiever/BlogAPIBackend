<?php

function getCategoryId($conn, $category){
    $sql = "SELECT id FROM post_category WHERE category = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $category);
    $result = mysqli_stmt_execute($stmt);
    if(!$result){
        sendResponse(500, [
            "success" => false,
            "message" => "Failed to create blog file. in getCategoryId function"
        ]);
    }
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['id'];

}

function getFileName($userId, $extension){
    $timestamp = date('Ymd_His');
    $fileName = "user_{$userId}_{$timestamp}.".$extension;
    return $fileName;
}

function getDBFilePath($fileName){
    $uploadDir = "http://loalhost/blog_api/uploads/posts/";
    $filePath = $uploadDir . $fileName;
    return $filePath;
}

function getFilePath($fileName){
    $uploadDir = __DIR__ . "/../uploads/posts/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $filePath = $uploadDir . $fileName;
    return $filePath;
}

function createAndSaveBlogFile($fileName, $content){
    $filePath = getFilePath($fileName);

    $bytesWritten = file_put_contents($filePath, $content);

    if (!file_exists($filePath) || $bytesWritten === false) {
        sendResponse(500, [
            "success" => false,
            "message" => "Failed to create blog file. In byteswritten"
        ]);
    }    
}

function uploadCoverImageFile($file){
        $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    
    if (!isset($allowedTypes[$mimeType])) {
        sendResponse(400, [
            "success" => false,
            "message" => "Invalid image type."
        ]);
    }

    $userId = $_SESSION['user_id'];
    $extension = $allowedTypes[$mimeType];
    $fileName = getFileName($userId, $extension);
    $uploadDir = __DIR__ . "/../uploads/cover_image/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filePath = $uploadDir . $fileName;
    $dbFilePath = 'http://localhost/blog_api/uploads/cover_image/'.$fileName;
    move_uploaded_file($file['tmp_name'], $filePath);
    return $dbFilePath;

}
$method = $_SERVER["REQUEST_METHOD"];

if($method === 'GET'){
    require '../templates/create_post.html';
    exit;
}

elseif($method === 'POST'){

    $data = json_decode(file_get_contents("php://input"), true);
    
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $excerpt = $_POST['excerpt'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $isPublished = $_POST['isPublished'];
    $coverImage = null;
    $coverImageFilePath = null;

    $userId = $_SESSION['user_id'];
    $fileName = getFileName($userId, 'txt');

    createAndSaveBlogFile($fileName, $content);
    
    $content_path = getDBFilePath($fileName);
    $category = getCategoryId($conn, $category);

    if (isset($_FILES['coverImage'])) {    
        $file = $_FILES['coverImage'];
        $coverImageFilePath = uploadCoverImageFile($file);
        
    }
    else{
        sendResponse(400, [
            "success" => false,
            "message" => "Invalid image type.",
            "file" => isset($_FILES['coverImage'])
        ]);
    }


    $sql = "INSERT INTO posts 
    (title, slug, excerpt, tags, category, content_path, cover_image, is_published, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssissii",
        $title,
        $slug,
        $excerpt,
        $tags,
        $category,
        $content_path,
        $coverImageFilePath,
        $isPublished,
        $userId
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Post created successfully";
    } else {
        echo "Failed to create post: " . mysqli_stmt_error($stmt);
    }
}



?>