<?php
session_start();

if (isset($_SESSION['UserName'])) {
    echo $_SESSION['UserName'];
} else {
    header("HTTP/1.0 403 Forbidden");
    echo "User not logged in";
}
?>
