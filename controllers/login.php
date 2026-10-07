<?php

$method = $_SERVER['REQUEST_METHOD'];



if($method === "POST"){


    require_once '../config/session.php';
    require_once '../config/response.php';


    // 1. Read the raw text stream from the input body
    $json_data = file_get_contents('php://input');

    // 2. Convert the JSON string into an associative PHP array
    $data = json_decode($json_data, true);

    // 3. Now you can access your frontend fields safely!
    // For example, if your React app sent { "username": "JohnDoe" }:
    $email = $data['email'] ?? null; 
    $password = $data['password'] ?? null;

    $sql = "SELECT id, username 
        FROM users
        WHERE email = ? AND password = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $email, $password);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
  
    if (!$user) {
        
        sendResponse(401, [
            "success" => false,
            "message" => "Invalid username or password"
        ]);

    } else {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        //session_start();
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user['id'];
        

        sendResponse(200, [
            "success" => true,
            "message" => "Successfully logged in.",
            "user" => $user
        ]);
        
        
    }
}

?>