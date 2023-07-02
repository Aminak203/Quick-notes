<?php
$models = [];
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://openai80.p.rapidapi.com/models",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: openai80.p.rapidapi.com",
        "X-RapidAPI-Key: f292077523mshb0b1d2d9e6c4ce6p16f9d0jsnbcc7da5612a5"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $models = json_decode($response, true);
}

?>

<div class="card">
  <div class="chat-header">Chat</div>
  <div class="chat-window">
    <ul class="message-list">
      <?php
      if (!empty($models)) {
        foreach ($models as $model) {
          echo '<li class="message">' . $model['id'] . '</li>';
        }
      } else {
        echo '<li class="message">No models found</li>';
      }
      ?>
    </ul>
  </div>
  <div class="chat-input">
    <input type="text" class="message-input" placeholder="Type your message here">
    <button class="send-button">Send</button>
  </div>
</div>

<style>
.card {
  width: 260px;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  -webkit-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
}

.chat-header {
  background-color: #333;
  color: #fff;
  padding: 10px;
  font-size: 18px;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.chat-window {
  height: 220px;
  overflow-y: scroll;
}

.message-list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.chat-input {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  padding: 10px;
  border-top: 1px solid #ccc;
}

.message-input {
  -webkit-box-flex: 1;
  -ms-flex: 1;
  flex: 1;
  border: none;
  outline: none;
  padding: 5px;
  font-size: 14px;
}

.send-button {
  border: none;
  outline: none;
  background-color: #333;
  color: #fff;
  font-size: 14px;
  padding: 5px 10px;
  cursor: pointer;
}

.send-button:hover {
  background-color: rgb(255, 255, 255);
  color: rgb(0, 0,)
}
</style>
</head>

<body>
  <div class="card">
    <div class="chat-header">Chat</div>
    <div class="chat-window">
      <ul class="message-list"></ul>
    </div>
    <div class="chat-input">
      <input type="text" class="message-input" placeholder="Type your message here">
      <button class="send-button">Send</button>
    </div>
  </div>

  <script>
    const messageList = document.querySelector('.message-list');
    const messageInput = document.querySelector('.message-input');
    const sendButton = document.querySelector('.send-button');

    function sendMessage() {
      const message = messageInput.value;

      if (message !== '') {
        const messageItem = document.createElement('li');
        messageItem.textContent = message;
        messageItem.classList.add('message');
        messageItem.classList.add('user');
        messageList.appendChild(messageItem);

        messageInput.value = '';

        fetch('send-message.php', {
            method: 'POST',
            body: JSON.stringify({
              message: message
            })
          })
          .then(response => response.json())
          .then(data => {
            const messageItem = document.createElement('li');
            messageItem.textContent = data.message;
            messageItem.classList.add('message');
            messageItem.classList.add('ai');
            messageList.appendChild(messageItem);
          });
      }
    }

    sendButton.addEventListener('click', () => {
      sendMessage();
    });

    messageInput.addEventListener('keyup', event => {
      if (event.keyCode === 13) {
        sendMessage();
      }
    });
  </script>

</body>

</html>

