<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include("connection.php");

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $username = $_SESSION['UserName'];

    // Check if note_id and username exist in the query string
    if (isset($_GET['note_id']) && isset($_GET['username'])) {
        $note_id = $_GET['note_id'];

        $stmt = $conn->prepare("SELECT * FROM notes WHERE note_id=? AND UserName=?");
        $stmt->bind_param("is", $note_id, $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $note_content = $row['note'];
            echo $note_content;
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "Invalid request";
        }
    } else {
        // If note_id and username do not exist, get all notes for the current user
        $stmt = $conn->prepare("SELECT * FROM notes WHERE UserName=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        $notes = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notes[] = $row;
            }
        }

        echo json_encode($notes);
    }

    $conn->close();
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "Invalid request";
}
