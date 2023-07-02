<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_change_password"])) {
    $new_password = mysqli_real_escape_string($conn, $_POST["new_password"]);
    $confirm_new_password = mysqli_real_escape_string($conn, $_POST["confirm_new_password"]);
    $UserName = mysqli_real_escape_string($conn, $_POST["UserName"]);

    if (isset($_SESSION["otp"])) {
        // Verify the OTP
        if ($_POST["otp"] == $_SESSION["otp"]) {
            if ($new_password != $confirm_new_password) {
                echo "New password and confirm new password do not match";
            } else {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $sql = "UPDATE user_accounts SET password = '$hashed_password' WHERE UserName = '$UserName'";
                if ($conn->query($sql) === TRUE) {
                    echo "Password changed successfully";
                } else {
                    echo "Error changing password: " . $conn->error;
                }
            }
        } else {
            echo "Incorrect OTP";
        }
    } else {
        echo "OTP not found in session";
    }

    // Close the connection
    $conn->close();
}
?>
