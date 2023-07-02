<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_change_username"])) {
    $current_username = mysqli_real_escape_string($conn, $_POST["current_username"]);
    $new_username = mysqli_real_escape_string($conn, $_POST["new_username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Verify the current username and password
    $sql = "SELECT * FROM user_accounts WHERE UserName = '$current_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            // Insert a new row in the user_accounts table with the new username
            $sql_insert_new_user = "INSERT INTO user_accounts (UserName, PhoneNumber, Email, password) VALUES ('$new_username', '{$user['PhoneNumber']}', '{$user['Email']}', '{$user['password']}')";
            if ($conn->query($sql_insert_new_user) === TRUE) {
                // Update the notes table
                $sql_update_notes = "UPDATE notes SET UserName = '$new_username' WHERE UserName = '$current_username'";
                if ($conn->query($sql_update_notes) === TRUE) {
                    // Delete the original user row in the user_accounts table
                    $sql_delete_old_user = "DELETE FROM user_accounts WHERE UserName = '$current_username'";
                    if ($conn->query($sql_delete_old_user) === TRUE) {
                        $_SESSION["UserName"] = $new_username;
                        header("Location: accounts.php?message=" . urlencode("Username changed successfully"));
                        exit();
                    } else {
                        header("Location: accounts.php?message=" . urlencode("Error Changing the username"));
                        exit();
                    }
                } else {
                    header("Location: accounts.php?message=" . urlencode("Error Changing the username"));
                    exit();
                }
            } else {
                header("Location: accounts.php?message=" . urlencode("Error Changing the username"));
                exit();
            }
        } else {
            header("Location: accounts.php?message=" . urlencode("Incorrect password"));
            exit();
        }
    } else {
        header("Location: accounts.php?message=" . urlencode("Current username not found"));
        exit();
    }

    // Close the connection
    $conn->close();
}
?>
