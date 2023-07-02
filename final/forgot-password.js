document.getElementById('forgot-password-form').addEventListener('submit', function (event) {
    event.preventDefault();
    let phoneNumber = document.getElementById('phone').value;
  
    // Verify the phone number is associated with a registered user
    // If the user is found, generate a unique token and store it temporarily in the database
  
    sendMessage(phoneNumber, 'Your unique password reset token is: TOKEN');
  });
  
  function sendMessage(phoneNumber, message) {
    var xhr = new XMLHttpRequest(),
      body = JSON.stringify(
        {
          "messages": [
            {
              "channel": "whatsapp",
              "to": phoneNumber,
              "content": message
            },
            {
              "channel": "sms",
              "to": phoneNumber,
              "content": message
            }
          ]
        }
      );
    xhr.open('POST', 'https://platform.clickatell.com/v1/message', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', 'XhyyYtGkTDK--7vQExzdkw==');
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        console.log('success');
      }
    };
  
    xhr.send(body);
  }
  