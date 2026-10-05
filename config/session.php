<?php

session_set_cookie_params([
    'httponly' => true,
    'secure' => false,       //true for HTTPS only
    'samesite' => 'Lax'
]);

session_start();

?>