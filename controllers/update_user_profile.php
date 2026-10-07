<?php

$method = $_SERVER['REQUEST_METHOD'];



if($method === "POST"){
    require_once '../config/response.php';
    require_once 'handle_avatar_change.php';
    // 1. Read the raw text stream from the input body
    $json_data = file_get_contents('php://input');
    // 2. Convert the JSON string into an associative PHP array
    $data = json_decode($json_data, true);
    // 3. Now you can access your frontend fields safely!
    // For example, if your React app sent { "username": "JohnDoe" }:
    $email = $data['email'] ?? null; 
    $username = $data['username'] ?? null;
    $sql = "";
    $filePath = "";
    $fields = [];
    $values = [];
    $types = "";
    
    if ($username !== null) {
        $fields[] = "username = ?";
        $values[] = $username;
        $types .= "s";
    }

    if ($email !== null) {
        $fields[] = "email = ?";
        $values[] = $email;
        $types .= "s";
    }

    if (isset($_FILES['profile_pic'])) {    
        $file = $_FILES['profile_pic'];
        $filePath = uploadAvatarFile($file);
        $fields[] = "profile_pic = ?";
        $values[] = $filePath;
        $types .= "s";
    }

    
    $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
    $values[] = $_SESSION['user_id'];
    $types .= "i";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$values);

    $success = mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$success) {
        sendResponse(500, [
            "success" => false,
            "message" => "Something went wrong try again later."
        ]);
    } else {        
        sendResponse(200,  []);
    }
}


?>