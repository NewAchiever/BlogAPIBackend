<?php
require_once '../config/response.php';
session_start();
session_unset();
session_destroy();
sendResponse(200, [])
?>