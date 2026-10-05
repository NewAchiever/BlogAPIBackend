<?php

require_once '../config/response.php';

$sql = "SELECT id, title FROM posts";

$result = mysqli_query($conn, $sql);

$posts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

sendResponse(200, $posts);

?>