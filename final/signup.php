<?php
session_start();
header('Content-Type: application/json');

// Include the connection file
include ("connection.php");

function generate_encryption_key() {
    return bin2hex(random_bytes(32));
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the values from the form
  $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);
  $PhoneNumber = mysqli_real_escape_string($conn, $_POST['PhoneNumber']);
  $Email = mysqli_real_escape_string($conn, $_POST['Email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Hash the password for security
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Generate an encryption key and hash it for storage
  $encryption_key = generate_encryption_key();
  $hashed_key = password_hash($encryption_key, PASSWORD_DEFAULT);

  // Insert the new user into the database
  $sql = "INSERT INTO user_accounts (UserName, PhoneNumber, Email, password, encryption_key) VALUES ('$UserName', '$PhoneNumber', '$Email', '$hashed_password', '$hashed_key')";

  if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id; // Get the unique value assigned to user_id
    $_SESSION['UserName'] = $UserName;
    $_SESSION['encryption_key'] = $encryption_key;
    
    echo json_encode(["success" => true, "redirect_url" => "/quicknotes/Testing/main.php"]);
    exit;
  } else {
    // Display error message
    echo json_encode(["success" => false, "error_message" => "Error creating user account: " . $conn->error]);
  }

  // Close the connection
  $conn->close();
} else {
  // Form not submitted, display error message
  echo json_encode(["success" => false, "error_message" => "Form not submitted"]);
}
?>
