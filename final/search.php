<html lang="en">
<head>
<script>
  window.onload = function() {
    const notification = document.getElementById('page_loaded_notification');
    notification.textContent = 'Page loaded successfully!';
    notification.classList.add('show');
    setTimeout(() => {
      notification.classList.remove('show');
    }, 6000);
  }
</script>
<div class="notification" id="welcome_notification"></div>
<script>
    function showNotification(message, cssClass) {
        const notification = document.getElementById(cssClass);
        notification.textContent = message;
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 6000);
    }
 // Check if the welcome notification has been shown before
 if (!localStorage.getItem('welcome_notification_shown')) {
        showNotification('If you face any difficulty pressing the Edit button, try clicking it again or press Enter. This should resolve the issue we are trying to fix it as soon as possible 👨‍💻', 'welcome_notification');
        localStorage.setItem('welcome_notification_shown', true);
    }


</script>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Search Notes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-AWEHfEhZnyv5KK5K5G5fCgg5B5yLxUzKoCVpWm+aAT7aeug1dKQ1CqU6hc9U9LkHZ6gHqlv7jK6W76Qg7Zwgyw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
      rel="stylesheet"
    />
    <script>
        function validateSearch() {
            var searchInput = document.getElementById("search").value.trim();
            if (searchInput == "") {
                alert("Please enter a search term");
                return false;
            }
            return true;
        }
    </script>
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
include("encryption.php");

?>
<div class="main-content">
    <h2>Search Notes</h2>
    <input type="hidden" id="hidden-username" value="<?php echo $_SESSION['UserName']; ?>">
    <form method="post" action="search.php" onsubmit="return validateSearch()">
        <input type="text" id="search" name="search" placeholder="Search for notes..." required>
        <input type="submit" value="Search" name="submit_search">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_search"])) {
        include("connection.php");
        $search = $_POST["search"];
        $UserName = $_SESSION['UserName'];
        $search_result = array();

        $sql = "SELECT * FROM notes WHERE (title LIKE '%$search%' OR note LIKE '%$search%') AND UserName='$UserName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $note_id = $row['note_id'];
                $title = decrypt($row['title'], $_SESSION['encryption_key']); // decrypt the title
                $note = decrypt($row['note'], $_SESSION['encryption_key']); // decrypt the note
                $search_result[] = array('note_id' => $note_id, 'title' => $title, 'note' => $note);
            }
        }
        $conn->close();
    }
    ?>
    <?php if (isset($search_result)): ?>
        <h3>Search Results:</h3>
        <ul class="notes-list">
            <?php foreach ($search_result as $note): ?>
                <li>
                    <h4><?= htmlspecialchars($note['title']); ?></h4>
                    <p><?= $note['note']; ?></p>
             
          


                      <button class="edit-btn retro-btn" data-id="<?= $note['note_id']; ?>"><i class="fas fa-edit"></i></button>
<button class="delete-btn retro-btn" data-id="<?= $note['note_id']; ?>"><i class="fas fa-trash"></i></button>
<button class="save-btn retro-btn" data-id="<?= $note['note_id']; ?>"><i class="fas fa-save"></i></button>
<button class="share-btn retro-btn" data-id="<?= $note['note_id']; ?>"><i class="fas fa-share"></i></button>
<div class="edit-note-div" style="display: none;">
        <textarea class="edit-note-textarea" id="note-<?= $note_id ?>"><?= $note ?></textarea>
        <button class="update-note-btn retro-btn" data-id="<?= $note_id ?>">Update</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <script>
  window.userName = "<?php echo $_SESSION['UserName']; ?>";
</script>

        <script src="searchjavascript.js"></script>
        <script>setupButtonListeners();</script>
    <?php endif; ?>
</div>
</body>
</html>