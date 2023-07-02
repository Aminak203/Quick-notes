<?php
session_start();
header('Content-Type: application/json');

// Include the connection file
include("connection.php");

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Find the user in the database
    $sql = "SELECT password, encryption_key FROM user_accounts WHERE UserName='$UserName'";
    $result = $conn->query($sql);
    
    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                // Password is correct, log the user in
                $_SESSION['UserName'] = $UserName;

                // Store the user's encryption key in the session data
                $_SESSION['encryption_key'] = $row['encryption_key'];
                
                $response['success'] = true;
            } else {
                // Password is incorrect
                $response['message'] = "Incorrect password";
            }
        } else {
            // No user found
            $response['message'] = "User not found";
        }
    } else {
        // Query failed
        $response['message'] = "Query failed: " . $conn->error;
    }
}

// Close the connection
$conn->close();

echo json_encode($response);
?>
