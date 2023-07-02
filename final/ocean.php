<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ChatBot</title>
    
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="wait.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" />
    <style>
        /* CSS Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Body Styles */
        body {
            background-color: #f2f2f2;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container Styles */
        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            gap: 20px;
        }

        .left-column {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main-column {
            flex: 2;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Chat Box Styles */
        .chat-header {
    font-size: 24px;
    font-weight: bold;
    padding: 10px;
    background-color: var(--bg-clr);
    color: var(--dark-text-clr);
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    font-family: monospace,CustomSerif,Georgia,Cambria,Times New Roman,serif,'Arial', 'Georgia', 'Impact', 'Tahoma', 'Verdana';
}

        .chat-window {
            height: 350px;
            overflow-y: auto;
            padding: 10px;
        }

        .message-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .message.user {
            background-color: #e6f2ff;
            color: #333;
        }

        .message.ai {
            background-color: #f5f5f5;
            color: #333;
        }

        .chat-input {
    align-items: stretch;
}

.message-input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    flex: 1;
    font-size: 20px; /* Increase the font size */
}

.send-button {
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #23262b;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 10px; /* Add margin top */
    width: 100px; /* Set width */
    height: 40px; /* Set height */
}

.send-button:hover {
    background-color: #3e8e41;
}



        /* Loading Spinner Styles */
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin: auto;
            margin-top: 50px;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #loading-animation {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
  z-index: 999;
  justify-content: center;
  align-items: center;
}

.pl {
  margin: auto;
}


    </style>
</head>
<body>
<?php

include("connection.php");
session_start();
$_SESSION['chat_history'] = array();
if (!isset($_SESSION['UserName']) || !isset($_SESSION['chat_history']))  {
  header('Location: index.php');
  exit();
}


// Initialize $user_message to an empty string
$user_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_message = $_POST['user_message'];
    array_push($_SESSION['chat_history'], array('user', $user_message));

    // Send the user message to the AI chatbot and get a response
    $curl = curl_init();

    curl_setopt_array($curl,
    [
        CURLOPT_URL => "https://openai80.p.rapidapi.com/chat/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"model\":\"gpt-3.5-turbo\",\"messages\":[{\"role\":\"user\",\"content\":\"" . $user_message . "\"}]}",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: openai80.p.rapidapi.com",
            "X-RapidAPI-Key: f292077523mshb0b1d2d9e6c4ce6p16f9d0jsnbcc7da5612a5",
            "content-type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);

    curl_close($curl);

    if ($http_code !== 200) {
        $ai_response = "HTTP Error: " . $http_code . "\n";
    }

    if ($err) {
        $ai_response = "cURL Error #:" . $err;
    } else {
        $response_data = json_decode($response, true);
        if (isset($response_data['choices'][0]['message']['content'])) {
            $ai_response = $response_data['choices'][0]['message']['content'];
        } else {
            $ai_response = "An error occurred while fetching the AI response.";
        }
    }

    // Add the AI response to the chat history
    array_push($_SESSION['chat_history'], array('ai', $ai_response));
}


include 'leftcolumn2.php';
?>

       <div id="loading-animation">
        <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
            <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
        </svg>
    </div>

    <div class="main-content">
        <div class="chat-header">Chat</div>
        <div class="chat-window">
    <ul class="message-list">
        <?php foreach ($_SESSION['chat_history'] as $message) { ?>
            <?php if ($message[0] === 'user') { ?>
                <li class="message user"><?php echo htmlspecialchars($message[1]); ?></li>
            <?php } else { ?>
                <li class="message ai"><?php echo htmlspecialchars($message[1]); ?></li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>

        <div class="chat-input">
            <form action="" method="POST">
            <input type="text" class="message-input" name="user_message" placeholder="Type your message here" required>
                <button type="submit" class="send-button">Send</button>
            </form>
        </div>
        </div>
        <script>
document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting
  const messageInput = document.querySelector('.message-input');
  const messageList = document.querySelector('.message-list');
  const formData = new FormData(event.target);
  const userMessage = formData.get('user_message');

  messageInput.value = ''; // Clear the input field

  // Add the waiting animation to the message list
  messageList.insertAdjacentHTML('beforeend', `
    <li class="message ai">
      <div class="loader"></div>
    </li>
  `);

  // Show the loading animation
  document.getElementById('loading-animation').style.display = 'flex';

  // Make the request to the API
  fetch('https://openai80.p.rapidapi.com/chat/completions', {
    method: 'POST',
    body: JSON.stringify({ model: 'gpt-3.5-turbo', messages: [{ role: 'user', content: userMessage }] }),
    headers: {
      'X-RapidAPI-Host': 'openai80.p.rapidapi.com',
      'X-RapidAPI-Key': 'f292077523mshb0b1d2d9e6c4ce6p16f9d0jsnbcc7da5612a5',
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    // Remove the waiting animation from the message list
    const waitingAnimation = messageList.querySelector('.loader');
    if (waitingAnimation) {
      waitingAnimation.parentNode.parentNode.removeChild(waitingAnimation.parentNode);
    }
    //adds usermessage in the history
    messageList.insertAdjacentHTML('beforeend', `
    <li class="message user">
      ${userMessage}
    </li>
  `);

    // Add the AI response to the message list
    messageList.insertAdjacentHTML('beforeend', `
  <li class="message ai">${data.choices[0].message.content}</li>
`);


  })
  .catch(error => console.error(error))
  .finally(() => {
    // Hide the loading animation when the API call is finished
    document.getElementById('loading-animation').style.display = 'none';
  });
});


            </script>
    </body>