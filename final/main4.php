
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
    <?php
        $background_color = $_COOKIE['background_color'] ?? 'white'; // Default to white
        echo "<style>
    .ql-toolbar {
      border: none !important;
      color: grey;
    }
    .ql-container,
    .ql-editor {
      border: none !important;
      outline: none !important;
      box-shadow: none !important;
      font-size: 15px;
    }
    .ql-editor {
      background-color: {$background_color};
      color: blacktext;
      cursor: text
    }
    body.dark-mode .ql-editor {
      background-color: #1c1c1c;
      color: #fff;
    }
    
    /* Light mode */
    body.light-mode .ql-snow .ql-placeholder {
        color: #999 !important;
    }
    
    /* Dark mode */
    body.dark-mode .ql-snow .ql-placeholder {
        color: #bbb !important;
    }
    
    
      
    
  </style>";
    ?>

    <link href='https://cdn.quilljs.com/1.3.7/quill.snow.css' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="transanim.css">
    <link rel="stylesheet" href="stylecolumn.css" />
</head>
<body class="<?php echo $mode; ?>">
    <div class="notification" id="note_saved_notification"></div>
<div class="notification" id="error_saving_notification"></div>
<div class="page-container">
<?php include 'leftcolumn2.php';?>

    </div>

    <script
    
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
    <!-- <script src="scriptcolumn.js"></script> -->
    <div class="main-content">
        <h2>Quick-Notes</h2>
        <form method="post" action="main.php">
            <!--<label for="title">Title:</label>-->
            <input type="text" id="title" name="title" placeholder="Title">

            <div id="editor"></div>
<input type="hidden" name="note" id="note" value="">
<input type="submit" value="Save Note" name="submit">
<!-- Add this inside your form -->
<div id="translate-wrapper">
    <span id="translate-icon"><ion-icon name="globe-outline"></ion-icon></span>
    <div id="language-select-wrapper" style="display: none;">
        <select id="language" name="language">
            <option value="ur">Urdu</option>
            <option value="es">Spanish</option>
            <!-- <option value="fr">French</option> -->
            <option value="de">German</option>
            <option value="ko">Korean</option>
            <option value="ar">Arabic</option>
            <option value="zh">Chinese</option>
            <option value="hi">Hindi</option>
            <option value="ja">Japanese</option>
            <option value="pt">Portuguese</option>
            <option value="ru">Russian</option>
        </select>
        <button id="translate-button" type="button">Translate</button>
    </div>
</div>

<script>
    const translateWrapper = document.getElementById('translate-wrapper');
    const languageSelectWrapper = document.getElementById('language-select-wrapper');
    const translateButton = document.getElementById('translate-button');

    translateWrapper.addEventListener('click', function() {
        languageSelectWrapper.style.display = 'inline';
    });

    translateButton.addEventListener('click', function() {
    const language = document.getElementById('language').value;
    const sourceText = editor.root.innerHTML;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'translate.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Replace the original text with the translated text
            const translatedText = JSON.parse(this.responseText).translatedText;
            editor.clipboard.dangerouslyPasteHTML(translatedText);
            loadingSpinner.style.display = 'none'; // Stop the animation
        }
    };
    loadingSpinner.style.display = 'block'; // Start the animation
    xhr.send(`sourceText=${encodeURIComponent(sourceText)}&language=${language}`);
});
</script>

<div id="loading-spinner" style="display: none;">
<div class="spinner">
        <circle class="back" cx="43" cy="43" r="40"></circle>
        <circle class="front" cx="43" cy="43" r="40"></circle>
        <circle class="new" cx="43" cy="43" r="40"></circle>
    </svg>
    <svg class="circle-middle wait">
        <circle class="back" cx="30" cy="30" r="27"></circle>
        <circle class="front" cx="30" cy="30" r="27"></circle>
    </svg>
    <svg class="circle-inner wait">
        <circle class="back" cx="17" cy="17" r="14"></circle>
        <circle class="front" cx="17" cy="17" r="14"></circle>
    </svg>
    <div class="text wait" data-text="Translating"></div>
</div>

<script>
    const loadingSpinner = document.getElementById('loading-spinner');

    document.getElementById('translate').addEventListener('click', function() {
        loadingSpinner.style.display = 'inline';
        const language = document.getElementById('language').value;
        const sourceText = editor.root.innerHTML;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'translate.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                // Replace the original text with the translated text
                const translatedText = JSON.parse(this.responseText).translatedText;
                editor.clipboard.dangerouslyPasteHTML(translatedText);
                loadingSpinner.style.display = 'none';
            }
        };

        xhr.send(`sourceText=${encodeURIComponent(sourceText)}&language=${language}`);
    });
</script>

        </form>

        <?php if (isset($search_result)): ?>
            <h3>Search Results:</h3>
            <ul class="notes-list">
                <?php foreach ($search_result as $note): ?>
                    <li>
                        <h4><?= htmlspecialchars($note['title']); ?></h4>
                        <p><?= htmlspecialchars(substr(strip_tags($note['note']), 0, 100)) . '...'; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
   
<script>
  var editor = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Your note',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['link', 'image', 'video'],
            ['blockquote', 'code-block'],
            [{ 'align': [] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            ['clean'],
        ],
    },
});

editor.on('text-change', function() {
    var note = document.querySelector('#note');
    note.value = editor.root.innerHTML;
});
document.getElementById('translate').addEventListener('click', function () {
    const language = document.getElementById('language').value;
    const sourceText = editor.root.innerHTML;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'translate.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Replace the original text with the translated text
            const translatedText = JSON.parse(this.responseText).translatedText;
            editor.clipboard.dangerouslyPasteHTML(translatedText);
        }
    };

    xhr.send(`sourceText=${encodeURIComponent(sourceText)}&language=${language}`);
});


</script>


    <script>
       function showNotification(message, notificationId) {
    const notification = document.getElementById(notificationId);
    notification.textContent = message;
    notification.classList.add('show');
    setTimeout(() => {
        notification.classList.remove('show');
    }, 4000);
}


        const editorElement = document.querySelector('#editor');
        editorElement.addEventListener('click', () => {
            const background_color = getComputedStyle(document.body).getPropertyValue('--primary-background-color');
            editorElement.querySelector('.ql-editor').style.backgroundColor = background_color;
        });
    </script>
<!-- ... -->

<?php if (isset($_SESSION['note_saved']) && $_SESSION['note_saved']): ?>
    <script>
        showNotification('Note saved successfully 😊', 'note_saved_notification');
    </script>
    <?php unset($_SESSION['note_saved']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_saving']) && $_SESSION['error_saving']): ?>
    <script>
        showNotification('Error while saving the note 😣', 'error_saving_notification');
    </script>
    <?php unset($_SESSION['error_saving']); ?>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
<script>
    function showNotification(message, cssClass) {
        const notification = document.getElementById(cssClass);
        notification.textContent = message;
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000);
    }
//     document.getElementById('save-button').addEventListener('click', function(event) {
//     event.preventDefault();

//     const formData = new FormData(document.querySelector('form'));

//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', 'main.php', true);
//     xhr.onreadystatechange = function() {
//         if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
//             if (this.responseText === 'success') {
//                 showNotification('Note saved successfully 😊', 'note_saved_notification');
//             } else {
//                 showNotification('Error while saving the note 😣', 'error_saving_notification');
//             }
//         }
//     };
//     xhr.send(formData);
// });


</script>

</body>
</html>
