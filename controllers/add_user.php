<?php

$method = $_SERVER['REQUEST_METHOD'];


if($method === "GET"){
    
    require '../templates/add_user.html';
    exit;
}
elseif($method === "POST"){


//    $username = $_POST['username'];
//    $email = $_POST['email'];
//    $password = $_POST['password'];

    // 1. Read the raw text stream from the input body
    $json_data = file_get_contents('php://input');

    // 2. Convert the JSON string into an associative PHP array
    $data = json_decode($json_data, true);

    // 3. Now you can access your frontend fields safely!
    // For example, if your React app sent { "username": "JohnDoe" }:
    $username = $data['username'] ?? null; 
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;



    $sql = "INSERT INTO users (username, email, password)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);

    $success = mysqli_stmt_execute($stmt);

    if($success){
        
    }
    else{
        // return error
    }


}

?>