<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['UserName']) && !empty($_SESSION['UserName'])) {
    $UserName = $_SESSION['UserName'];
} else {
    header("Location: details.html");
}

include 'leftcolumn2.php';

include("connection.php");

// Retrieve list of folders for current user
$sql = "SELECT * FROM folders WHERE UserName='$UserName'";
$result = $conn->query($sql);

echo '<div class="main-content">';
echo '<h1>Folder Notes</h1>';

// Display list of folders
echo '<ul class="folder-list">';
while ($row = $result->fetch_assoc()) {
    $folder_id = $row['folder_id'];
    $folder_name = htmlspecialchars($row['folder_name']);
    echo "<li><a href='folder_notes.php?folder_id=$folder_id'>$folder_name</a></li>";
}
echo '</ul>';

// Retrieve notes for selected folder
$folder_id = isset($_GET['folder_id']) ? intval($_GET['folder_id']) : 0;
$sql = "SELECT * FROM notes WHERE UserName='$UserName' AND folder_id='$folder_id'";
$notes_result = $conn->query($sql);

if ($notes_result->num_rows > 0) {
    echo '<ul class="notes-list">';
    while ($row = $notes_result->fetch_assoc()) {
        $note_id = $row['note_id'];
        $title = htmlspecialchars($row['title']);
        $note = $row['note'];
        echo "<li><input type='checkbox' class='note-checkbox' data-id='$note_id'>";
        echo "<h4>$title</h4>";
        echo "<p>$note</p></li>";
    }
    echo '</ul>';
} else {
    echo "<p>No notes found.</p>";
}

// Add dropdown to allow user to select a different folder
echo '<div class="folder-dropdown">';
echo '<select onchange="location = this.value;">';
echo '<option value="">Select a folder</option>';
$result->data_seek(0);
while ($row = $result->fetch_assoc()) {
    $folder_id = $row['folder_id'];
    $folder_name = htmlspecialchars($row['folder_name']);
    $selected = $folder_id == $folder_id ? 'selected' : '';
    echo "<option value='folder_notes.php?folder_id=$folder_id' $selected>$folder_name</option>";
}
echo '</select></div>';

$conn->close();
echo '</div>';

?>
