<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_change_details"])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $new_email = mysqli_real_escape_string($conn, $_POST["new_email"]);
    $new_phone_number = mysqli_real_escape_string($conn, $_POST["new_phone_number"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    echo "Username: $username<br>";
    echo "New Email: $new_email<br>";
    echo "New Phone Number: $new_phone_number<br>";
    echo "Password: $password<br>";

    // Verify the current username and password
    $sql = "SELECT * FROM user_accounts WHERE UserName = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "User found<br>";
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            echo "Password verified<br>";

            // Update the email and phone number in the user_accounts table
            $sql = "UPDATE user_accounts SET Email = '$new_email', PhoneNumber = '$new_phone_number' WHERE UserName = '$username'";
            if ($conn->query($sql) === TRUE) {
                echo "Details updated successfully<br>";
                header("Location: accounts.php?message=" . urlencode("Details updated successfully"));
            } else {
                echo "Error updating details: " . $conn->error . "<br>";
                header("Location: accounts.php?message=" . urlencode("Error updating details"));
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
