<?php
session_start();

if (!isset($_SESSION['UserName']) || empty($_SESSION['UserName'])) {
    header("Location: details.html");
    exit;
}

$UserName = $_SESSION['UserName'];
$folder_name = $_POST['folder_name'];
$selected_note_ids = $_POST['selected_note_ids'];

if (empty($folder_name) || empty($selected_note_ids)) {
    header("Location: folder.php");
    exit;
}

include 'connection.php';

$sql = "INSERT INTO folders (UserName, folder_name) VALUES ('$UserName', '$folder_name')";
$result = $conn->query($sql);

if ($result) {
    $folder_id = $conn->insert_id;

    $note_ids = explode(",", $selected_note_ids);
    foreach ($note_ids as $note_id) {
        $sql = "UPDATE notes SET folder_id=$folder_id WHERE note_id=$note_id AND UserName='$UserName'";
        $conn->query($sql);
    }
}

$conn->close();
header("Location: folder.php");
?>
