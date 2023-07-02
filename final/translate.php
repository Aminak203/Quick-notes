<?php

//deepL api we can use this later
// header('Content-Type: text/html; charset=UTF-8');
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $sourceText = $_POST["sourceText"];
//     $language = $_POST["language"];

//     $curl = curl_init();

//     curl_setopt_array($curl, [
//         CURLOPT_URL => "https://api-free.deepl.com/v2/translate",
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_FOLLOWLOCATION => true,
//         CURLOPT_ENCODING => "",
//         CURLOPT_MAXREDIRS => 10,
//         CURLOPT_TIMEOUT => 30,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         CURLOPT_CUSTOMREQUEST => "POST",
//         CURLOPT_POSTFIELDS => "text=" . urlencode($sourceText) . "&target_lang=" . $language . "&source_lang=en&auth_key=967cd751-4267-6811-bd5a-c654087494ad:fx",
//         CURLOPT_HTTPHEADER => [
//             "content-type: application/x-www-form-urlencoded",
//             "Authorization: DeepL-Auth-Key 967cd751-4267-6811-bd5a-c654087494ad:fx"
//         ],
//     ]);

//     $response = curl_exec($curl);
//     $err = curl_error($curl);

//     curl_close($curl);

//     if ($err) {
//         echo json_encode(['error' => 'cURL Error: ' . $err]);
//     } else {
//         $responseArray = json_decode($response, true);
//         $translatedText = $responseArray['translations'][0]['text'];
        
//         // If the target language is Urdu, convert the Unicode characters to HTML entities
//         if ($language == 'ur') {
//             $translatedText = mb_convert_encoding($translatedText, 'HTML-ENTITIES', 'UTF-8');
//         }
        
//         echo json_encode(['translatedText' => $translatedText]);
//     }

//     exit;
// }

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sourceText = $_POST["sourceText"];
    $language = $_POST["language"];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://nlp-translation.p.rapidapi.com/v1/translate",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "text=" . urlencode($sourceText) . "&to=" . $language . "&from=en",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: nlp-translation.p.rapidapi.com",
            "X-RapidAPI-Key: f292077523mshb0b1d2d9e6c4ce6p16f9d0jsnbcc7da5612a5",
            "content-type: application/x-www-form-urlencoded"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo json_encode(['error' => 'cURL Error: ' . $err]);
    } else {
        $responseArray = json_decode($response, true);
        $translatedText = $responseArray['translated_text'][$language];

        // If the target language is Urdu, convert the Unicode characters to HTML entities
        if ($language == 'ur') {
            $translatedText = mb_convert_encoding($translatedText, 'HTML-ENTITIES', 'UTF-8');
        }

        echo json_encode(['translatedText' => $translatedText]);
    }

    exit;
}


?>

<script>
    let userStartedWriting = false; // Add this line

editor.on('text-change', function () {
    var note = document.querySelector('#note');
    note.value = editor.root.innerHTML;
    userStartedWriting = true; // Set the flag to true when the user starts writing
});

document.getElementById('translate').addEventListener('click', function () {
    const language = document.getElementById('language').value;
    const sourceText = editor.root.innerHTML.trim();

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'translate.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Replace the original text with the translated text
            const translatedText = JSON.parse(this.responseText).translatedText;
            editor.setContents(editor.clipboard.convert(translatedText));
        }
    };

    xhr.send(`sourceText=${encodeURIComponent(sourceText)}&language=${language}`);
});





    </script>