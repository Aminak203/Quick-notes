<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include("connection.php");

  if (isset($_POST['UserName'])) {
    $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);

    $sql = "SELECT * FROM user_accounts WHERE UserName='$UserName'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
      echo 'Error: ' . mysqli_error($conn);
      exit();
    }

    if (mysqli_num_rows($result) > 0) {
      echo 'exists';
      exit();
    } else {
      echo 'not_exists';
    }
  }

  // Close the connection
  mysqli_close($conn);
}

?>
