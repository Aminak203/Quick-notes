<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include("connection.php");

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $username = $_SESSION['UserName'];

    $sql = "SELECT * FROM notes WHERE UserName='$username'";
    $result = $conn->query($sql);

    $notes = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notes[] = $row;
        }
    }

    echo json_encode($notes);

    $conn->close();
} else {
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(['error' => 'Invalid request']);
}
