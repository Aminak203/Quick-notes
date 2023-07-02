<!DOCTYPE html>
<html lang="en">
<head>
<!-- <script>
  window.onload = function() {
    const notification = document.getElementById('page_loaded_notification');
    notification.textContent = 'Page loaded successfully!';
    notification.classList.add('show');
    setTimeout(() => {
      notification.classList.remove('show');
    }, );
  }
</script> -->
<div class="notification" id="welcome_notification"></div>
<script>
    function decrypt_note($encrypted_note, $key, $cipher = 'AES-128-CBC') {
    $iv_len = openssl_cipher_iv_length($cipher);
    $iv = substr($encrypted_note, 0, $iv_len);
    $encrypted_note = substr($encrypted_note, $iv_len);
    $decrypted_note = openssl_decrypt($encrypted_note, $cipher, $key, 0, $iv);
    return $decrypted_note;
}

    function showNotification(message, cssClass) {
        const notification = document.getElementById(cssClass);
        notification.textContent = message;
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000);
    }
    // Check if the welcome notification has been shown before
    if (!localStorage.getItem('welcome_notification_shown')) {
        showNotification('If you face any difficulty pressing the Edit button, try clicking it again or press Enter. This should resolve the issue we are trying to fix it as soon as possible 👨‍💻', 'welcome_notification');
        localStorage.setItem('welcome_notification_shown', true);
    }

    //showNotification('If you face any difficulty pressing the Edit button, try clicking it again or press Enter. This should resolve the issue', 'welcome_notification');
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>All Notes</title>
     <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-pgOvJFNkwxW4Ic4jKysgzV7v05OrlJWV7+oIwq3y7vL8JCOGquf9KRG1p/sUzK6U5LD6UzTkDPMSXTp97B5tlg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body><?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['UserName']) && !empty($_SESSION['UserName'])) {
    $UserName = $_SESSION['UserName'];
} else {
    header("Location: details.html");
}

    include 'leftcolumn2.php';
    include("encryption.php");

?>
<div class="main-content">
    <h1>All Notes</h1>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <ul class="notes-list">
    <input type="hidden" id="hidden-username" value="<?php echo $_SESSION['UserName']; ?>">
        <?php
        include("connection.php");

        $sql = "SELECT * FROM notes WHERE UserName='$UserName'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $note_id = $row['note_id'];
                $title = decrypt($row['title'], $_SESSION['encryption_key']); // decrypt the title
                $note = decrypt($row['note'], $_SESSION['encryption_key']); // decrypt the note
        ?>
                <li>
                    <h4><?= $title ?></h4>
                    <p><?= $note ?></p>
          
                    <button class="edit-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-edit"></i></button>
                    <button class="delete-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-trash"></i></button>
                    <button class="save-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-save"></i></button>
                    <button class="share-btn retro-btn" data-id="<?= $note_id ?>"><i class="fas fa-share"></i></button> 
                    <div class="edit-note-div" style="display: none;">
        <textarea class="edit-note-textarea" id="note-<?= $note_id ?>"><?= $note ?></textarea>
        <button class="update-note-btn retro-btn" data-id="<?= $note_id ?>">Update</button>
                </li>
        <?php
            }
        } else {
            echo "<p>No notes found.</p>";
        }
        $conn->close();
        ?>
    </ul>
    <script>
  window.userName = "<?php echo $_SESSION['UserName']; ?>";
</script>


    <script src="searchjavascript.js"></script>
    <script>setupButtonListeners();</script>
</div>


</div>
</body>
</html> 
