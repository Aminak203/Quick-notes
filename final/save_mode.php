<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mode'])) {
        $_SESSION['mode'] = $_POST['mode'];
        http_response_code(204); // Set response code to 204 (No Content)
        exit;
    }
}

http_response_code(400); // Set response code to 400 (Bad Request)
echo 'Bad request';
?>
