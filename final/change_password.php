<?php
// Include your database connection file and start a session
include("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $UserName = $_POST['UserName'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    $otp = $_POST['otp'];

    // Check if the OTP matches
    if ($_SESSION["otp"] == $otp) {
        // Check if the current password is correct
        $stmt = $conn->prepare("SELECT Password FROM user_accounts WHERE UserName = ?");
        $stmt->bind_param("s", $UserName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['Password'];
            
            if (password_verify($current_password, $stored_password)) {
                // Update the password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE user_accounts SET Password = ? WHERE UserName = ?");
                $stmt->bind_param("ss", $hashed_password, $UserName);
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    echo "Password changed successfully.";
                } else {
                    echo "Error updating password.";
                }
            } else {
                echo "Incorrect current password.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Invalid OTP.";
    }
}
