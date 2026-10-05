<?php
include '../config/db.php';
require_once '../config/response.php';
require_once './utils/auth.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$path = str_replace("/blog_api/public", "", $path);

/*
$INCLUDE_LOGIN_PATHS = ['/login', '/signup']
if(!require_login() && !in_array( $path, $INCLUDE_LOGIN_PATHS)) {
    sendResponse(401,[
            "message" => "Logged out"
        ]
    );
}
*/
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

header('Content-Type: application/json');
if ($path === '/add_post') {
require_login();    
require '../controllers/add_post.php';
}
elseif ($path === '/get_post') {
require_login();    
require '../controllers/get_post.php'; 
}
elseif ($method === "GET" && preg_match('#^/get_post/(\d+)$#', $path, $matches)) {
require_login();    
$postId = $matches[1];
    require '../controllers/get_post_id.php';
}
elseif ($path === '/add_user') {
    
    require '../controllers/add_user.php';    
}
elseif ($path === '/login') {
    require '../controllers/login.php';    
}
elseif ($method === 'GET' && $path === '/logout') {    
    require_login();
    require '../controllers/logout.php';    
}
elseif ($method === 'POST' && $path === '/authenticate_user') {
    echo "Authenticate user";
}
elseif ($method === 'POST' && $path === '/get_user') {
    echo "Authenticate user";   
}
elseif ($method === 'POST' && $path === '/add_comment') {
    echo "Create user";
}
elseif ($method === 'GET' && $path === '/get_comments') {
    echo "Fetch comments";
}
elseif($method === 'PATCH' && $path === '/like_post'){
    require_login();
    require_once '../controllers/handle_post_like.php';
}
elseif($method === 'PATCH' && $path === '/like_comment'){
    require_login();
    require_once '../controllers/handle_comment_like.php';
}
elseif($method === 'POST' && $path === '/view_more'){
    require_login();
    require_once '../controllers/handle_view_more.php';
}
elseif($method === 'POST' && $path === '/comment_reply'){
    require_login();
    require_once '../controllers/handle_comment_reply.php';
}
elseif ($method === 'POST' && $path === '/post_reply') {
    require '../controllers/post_reply.php';
}
elseif ($method === 'GET' && $path === '/get_user_profile') {
    require_login();
    require '../controllers/get_user_profile.php';
}
elseif ($method === 'POST' && $path === '/update_user_profile') {
    require_login();
    require '../controllers/update_user_profile.php';
}
elseif ($method === 'POST' && $path === '/handle_save_post') {
    require_login();
    require '../controllers/handle_post_save.php';
}
else {
    http_response_code(404);
    echo $path."<br/>";
    echo "Route not found";
}

$conn->close();
?>

