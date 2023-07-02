<?php
// Connect to the database and handle form submission
session_start();
include("connection.php");
if (!isset($_SESSION['UserName'])) {
  header('Location: index.php');
  exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        $title = $_POST["title"];
        $note = $_POST["note"];
        $username = $_SESSION['UserName'];
        
        if (!empty(trim($title)) || !empty(trim($note))) {
            $stmt = $conn->prepare("INSERT INTO notes (title, note, UserName) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $note, $username);
            
            if ($stmt->execute() === TRUE) {
                $_SESSION['note_saved'] = true;
            } else {
                $_SESSION['error_saving'] = true;
                $_SESSION['error_message'] = 'Error while saving the note!';
                header('Location: main.php');
                exit();
            }
            
            $stmt->close();
        } else {
            $_SESSION['error_saving'] = true;
            $_SESSION['error_message'] = 'Please enter content in either the title or note before saving.';
            header('Location: main.php');
            exit();
        }

        $stmt->close();
        
    } elseif (isset($_POST["submit_search"])) {
        $search = $_POST["search"];
        $search_result = [];

        $sql = "SELECT * FROM notes WHERE title LIKE '%$search%' OR note LIKE '%$search%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $search_result[] = $row;
            }
        }
    }
}

$conn->close();

?>

<?php
session_start();

// Check if the user has set a new mode
if (isset($_POST['mode'])) {
    // Set the mode in the session variable
    $_SESSION['mode'] = $_POST['mode'];
    exit;
}

// Check if the mode is set in the session variable
if (isset($_SESSION['mode'])) {
    $mode = $_SESSION['mode'];
} else {
    $mode = 'light'; // Default mode
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <style>

/* Define light and dark mode colors */
:root {
  --trix-editor-text-color: #000;
  --trix-editor-background-color: #fff;
  --trix-toolbar-background-color: #f0f0f0;
}

.dark-mode {
  --trix-editor-text-color: #fff;
  --trix-editor-background-color: #222;
  --trix-toolbar-background-color: #333;
}

/* Set colors */
trix-editor {
  color: var(--trix-editor-text-color) !important;
}

/* Remove borders around toolbar items */
trix-toolbar .trix-button-group,
trix-toolbar .trix-button {
  border: none !important;
}

/* Change the color of the icons on the toolbar */
trix-toolbar .trix-button::before {
  color: #1a73e8; /* Change to your desired color */
}


/* Remove borders */
trix-editor, trix-toolbar {
  border: none !important;
}

/* Set font */
trix-editor {
  font-family: monospace, CustomSerif, Georgia, Cambria, "Times New Roman", serif !important;
}

/* Style toolbar items */
trix-toolbar .trix-button-group {
  margin-right: 2px !important;
}

trix-toolbar .trix-button {
  margin: 0 1px !important;
}


  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal-content {
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    min-height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}


  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  form input[type="text"],
form trix-editor {
    width: 100%;
    margin-bottom: 10px;
}

form input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #1a73e8;
    border: none;
    color: white;
    font-weight: bold;
    cursor: pointer;
    text-transform: uppercase;
}

form input[type="submit"]:hover {
    background-color: #0f57c7;
}
.app-wrapper {
  display: flex;
}

.container {
  width: 250px;
}

.main-content {
  flex: 1;
}


</style>
</head>


 <body class="<?php echo $mode; ?>">
    <?php include 'leftcolumn2.php';?>
    <button onclick="location.href='main.php'">Main Page</button>
    <div id="noteModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form method="post" action="main.php">
            <input type="text" id="title" name="title" placeholder="Title">
            <input id="x" type="hidden" name="note"> <!-- Change 'content' to 'note' -->
            <trix-editor input="x" placeholder="Your note"></trix-editor>
            <input type="submit" value="Save Note" name="submit">
        </form>
    </div>
    <div class="notification" id="note_saved_notification"></div>
    <div class="notification" id="error_saving_notification"></div>


<script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelector('trix-editor').addEventListener('trix-attachment-add', function(event) {
    var attachment = event.attachment;
    if (attachment.file) {
      // Upload the file and set the attachment's URL attribute upon completion
      // See the attachment example for detailed information
    }
  });

  document.querySelector('trix-editor').addEventListener('trix-file-accept', function(event) {
    // Prevent Trix from accepting dropped or pasted files
    event.preventDefault();
  });
});
</script>
<script>
    // Get the modal, button, and close elements
    var modal = document.getElementById("noteModal");
    var btn = document.getElementById("newNoteBtn");
    var closeBtn = document.getElementsByClassName("close")[0];

    // Open the modal when the button is clicked
    btn.onclick = function () {
        modal.style.display = "block";
    };

    closeBtn.onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal when the user clicks outside of the modal content
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // AJAX request to set the mode in the session variable
    function setMode(mode) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.reload(); // Refresh the page to apply the new mode
            }
        };
        xhttp.open("POST", "main.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("mode=" + mode);
    }
</script>
</body>
</html>