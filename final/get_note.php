<?php
session_start();
include("encryption.php");
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $username = $_SESSION['UserName'];

    // Check if note_id exists in the query string
    if (isset($_GET['note_id'])) {
        $note_id = $_GET['note_id'];

        $stmt = $conn->prepare("SELECT * FROM notes WHERE note_id=? AND UserName=?");
        $stmt->bind_param("is", $note_id, $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $note_content_encrypted = $row['note'];
            $note_content = decrypt($note_content_encrypted, $_SESSION['encryption_key']);
            echo $note_content;
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "Invalid request";
        }
    } else {
        // If note_id does not exist in the query string, get all notes for the current user
        $stmt = $conn->prepare("SELECT * FROM notes WHERE UserName=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        $notes = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['note'] = decrypt($row['note'], $_SESSION['encryption_key']);
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
