<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp"])) {
    // Check if the submitted OTP matches the one stored in the session
    if (isset($_SESSION["otp"]) && $_POST["otp"] == $_SESSION["otp"]) {
        // OTP is correct
        echo 'success';
    } else {
        // OTP is incorrect
        echo 'error';
    }
}
?>
