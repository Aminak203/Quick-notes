<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rephrase and Grammar Correction</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <style>
        #editor {
            height: 500px;
        }
    </style>
</head>
<body>
<?php
include 'leftcolumn2.php';
?>
<div class="main-content">
    <h1>Rephrase and Grammar Correction</h1>
    <form method="post">
        <div id="editor"></div>
        <textarea name="text" id="hiddenText" style="display:none;"></textarea>
        <button type="submit" name="submit">Rephrase</button>
    </form>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        const form = document.querySelector('form');
        form.addEventListener('submit', (event) => {
            const hiddenText = document.querySelector('#hiddenText');
            hiddenText.value = quill.root.innerHTML;
        });
    </script>
    <?php
    if (isset($_POST['submit'])) {
        $inputText = $_POST['text'];
        $outputText = "";
        $command = "python3 paraphrase.py " . escapeshellarg($inputText);
        $outputText = shell_exec($command);
        echo '<h2>Paraphrased Text</h2>';
        echo '<div>' . $outputText . '</div>';
    }
    ?>
</div>
</body>
</html>
