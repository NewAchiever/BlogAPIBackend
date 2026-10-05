<?php



function require_login(){
    session_start();

    if (!isset($_SESSION['user_id'])) {
        sendResponse(401, [
            "success" => false,
            "message" => "Authentication required"
        ]);
    exit;
    }
}

?>