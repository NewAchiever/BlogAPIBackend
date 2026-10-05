<?php

function uploadFile($file){
    
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

    if (!isset($allowedTypes[$mimeType])) {
        sendResponse(400, [
            "success" => false,
            "message" => "Invalid image type."
        ]);
    }

    $userId = $_SESSION['user_id'];
    $extension = $allowedTypes[$mimeType];
    $fileName = $userId . "." . $extension;
    $uploadDir = __DIR__ . "/../uploads/avatar/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filePath = $uploadDir . $fileName;
    $dbFilePath = 'http://localhost/blog_api/uploads/avatar/'.$fileName;
    move_uploaded_file($file['tmp_name'], $filePath);
    return $dbFilePath;

}

?>