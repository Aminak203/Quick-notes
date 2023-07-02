<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['note_id'])) {
    include("connection.php");

    $note_id = $_POST['note_id'];
    $username = $_SESSION['UserName'];

    // Check if note_id exists in the database
    $sql = "SELECT * FROM notes WHERE note_id='$note_id' AND UserName='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // note_id exists in the database
        // proceed with the DELETE query
        $sql = "DELETE FROM notes WHERE note_id='$note_id' AND UserName='$username'";

        if ($conn->query($sql) === TRUE) {
            echo "Note deleted successfully";
           return; /// to step goin to the else part
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    //     else {
    //     // note_id does not exist in the database
    //     // handle the error accordingly
    //     echo "Invalid note ID";
    // }
    
    }

    $conn->close();
}
?>
