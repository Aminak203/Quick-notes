<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

if (isset($_SESSION['UserName']) && !empty($_SESSION['UserName'])) {
    $UserName = $_SESSION['UserName'];
} else {
    header("Location: details.html");
}
?>