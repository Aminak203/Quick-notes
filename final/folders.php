<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Folders</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-pgOvJFNkwxW4Ic4jKysgzV7v05OrlJWV7+oIwq3y7vL8JCOGquf9KRG1p/sUzK6U5LD6UzTkDPMSXTp97B5tlg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
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
?>

<div class="main-content">
    <h1>Folders</h1>
    <form class="create-folder-form" action="create_folder_and_assign_notes.php" method="POST">
        <label for="folder_name">Folder Name:</label>
        <input type="text" name="folder_name" id="folder_name" required>
        <input type="hidden" name="selected_note_ids" id="selected_note_ids" value="">
        <button type="submit">Create Folder</button>
    </form>

    <ul class="folders-list">
        <?php
        include("connection.php");

        $sql = "SELECT * FROM folders WHERE UserName='$UserName'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $folder_id = $row['folder_id'];
                $folder_name = htmlspecialchars($row['folder_name']);
        ?>
                <li>
                    <input type="checkbox" class="note-checkbox" data-id="<?= $folder_id ?>">
                    <h4><?= $folder_name ?></h4>
                    <button class="open-folder-btn retro-btn" data-id="<?= $folder_id ?>"><i class="fas fa-folder-open"></i></button>
                    <button class="delete-folder-btn retro-btn" data-id="<?= $folder_id ?>"><i class="fas fa-trash"></i></button>
                </li>
        <?php
            }
        } else {
            echo "<p>No folders found.</p>";
        }

        $conn->close();
        ?>
    </ul>

    <h1>Notes without a folder</h1>
    <ul class="notes-list">
        <?php
        include("connection.php");

        $sql = "SELECT * FROM notes WHERE UserName='$UserName' AND (folder_id IS NULL OR folder_id = 0)";

        $result = $conn->query($sql);

        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
            $note_id = $row['note_id'];
            $title = htmlspecialchars($row['title']);
            $note = $row['note'];
            ?>
            <li>
            <input type="checkbox" class="note-checkbox" data-id="<?= $note_id ?>">
            <h4><?= $title ?></h4>
            <p><?= $note ?></p>
            <button class="edit-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-edit"></i></button>
            <button class="delete-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-trash"></i></button>
            <button class="save-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-save"></i></button>
            <button class="share-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-share"></i></button>
            <div class="edit-note-div" style="display: none;">
            <textarea class="edit-note-textarea" id="note-<?= $note_id ?>"><?= $note ?></textarea>
            <button class="update-note-btn retro-btn" data-id="<?= $note_id ?>">Update</button>
            </div>
            </li>
            <?php
                     }
                 } else {
                     echo "<p>No notes found.</p>";
                 }
                 $conn->close();
                 ?>
            </ul>
            

            <script src="folderjavascript.js"></script>
            <script>setupFolderButtonListeners();</script>
            </div>
            <script src="mainjavascript.js"></script>
            </body>
            </html>
