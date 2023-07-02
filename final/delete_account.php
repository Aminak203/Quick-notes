<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_delete_account"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Verify the current username and password
    $sql = "SELECT * FROM user_accounts WHERE UserName = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            // Delete user notes
            $sql = "DELETE FROM notes WHERE UserName = '$username'";
            if ($conn->query($sql) === TRUE) {
                echo "User notes deleted successfully<br>";
            } else {
                echo "Error deleting user notes: " . $conn->error . "<br>";
            }

            // Delete user account
            $sql = "DELETE FROM user_accounts WHERE UserName = '$username'";
            if ($conn->query($sql) === TRUE) {
                echo "User account deleted successfully<br>";
                header("Location: index.php?message=" . urlencode("Account deleted successfully"));
            } else {
                echo "Error deleting user account: " . $conn->error . "<br>";
                header("Location: accounts.php?message=" . urlencode("Error deleting user account"));
            }
        } else {
            echo "Incorrect password<br>";
            header("Location: accounts.php?message=" . urlencode("Incorrect password"));
        }
    } else {
        echo "Username not found<br>";
        header("Location: accounts.php?message=" . urlencode("Username not found"));
    }

    // Close the connection
    $conn->close();
}
?>
