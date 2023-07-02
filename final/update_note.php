<?php
session_start();
include("connection.php");
include("encryption.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['UserName'];

    // Check if title, note, and note_id are set in the POST request
    if (isset($_POST['title']) && isset($_POST['note']) && isset($_POST['note_id'])) {
        $title = $_POST['title'];
        $note = $_POST['note'];
        $note_id = $_POST['note_id'];
        
        // Encrypt the title and note before saving to the database
        $title_encrypted = encrypt($title, $_SESSION['encryption_key']);
        $note_encrypted = encrypt($note, $_SESSION['encryption_key']);

        $stmt = $conn->prepare("UPDATE notes SET title=?, note=? WHERE note_id=? AND UserName=?");
        $stmt->bind_param("ssis", $title_encrypted, $note_encrypted, $note_id, $username);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Note updated successfully";
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "Error updating note";
        }
    } else {
        header("HTTP/1.0 400 Bad Request");
        echo "Invalid request";
    }

    $conn->close();
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "Invalid request";
}
?>
