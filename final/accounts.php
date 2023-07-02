<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Account Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-AWEHfEhZnyv5KK5K5G5fCgg5B5yLxUzKoCVpWm+aAT7aeug1dKQ1CqU6hc9U9LkHZ6gHqlv7jK6W76Qg7Zwgyw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.getElementsByTagName("input");

            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].value.trim() === "") {
                    alert("Please fill in all the required fields");
                    return false;
                }
            }
            return true;
        }
        <script>
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.getElementsByTagName("input");

            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].value.trim() === "") {
                    alert("Please fill in all the required fields");
                    return false;
                }
            }
            return true;
        }
    </script>
</head>
<body>
<div class="notification" id="response_notification"></div>
<script>
    function showNotification(message, cssClass) {
        const notification = document.getElementById(cssClass);
        notification.textContent = message;
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000);
    }

    // check if message is present in URL and display notification if present
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        showNotification(message, 'response_notification');
    }
</script>
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
    <h2>Account Settings</h2>
    <div class="settings-options">
    <?php
?>
<input type="hidden" id="hidden-username" value="<?php echo $username; ?>">

        <button class="retro-btn" onclick="showOption('change-username')">Change Username</button>
        <button class="retro-btn" onclick="showOption('change-password')">Change Password</button>
        <button class="retro-btn" onclick="showOption('change-details')">Change Details</button>
        <button class="retro-btn" onclick="showOption('delete-account')">Delete Account</button>
    </div>

    <div id="change-username" class="settings-option" style="display:none;">
        <h3>Change Username</h3>
        <form method="post" action="change_username.php" onsubmit="return validateForm('change-username-form')">
            <input type="text" name="current_username" placeholder="Current Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="new_username" placeholder="New Username" required>
            <input type="submit" value="Change Username" name="submit_change_username">
        </form>
    </div>

    <div id="change-password" class="settings-option" style="display:none;">
    <h3 id="change-password-heading">Change Password</h3>
    <form id="change-password-form" method="post">
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="current_password" id="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" id="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" required>
        <button type="button" id="submit_send_otp">Send OTP</button>
        <input type="text" name="otp" id="otp" placeholder="Enter OTP" required style="display: none;">
        <input type="submit" value="Change Password" name="submit_change_password" id="submit_change_password" style="display: none;">
    </form>
</div>

<div id="change-details" class="settings-option" style="display:none;">
    <h3>Change Account Details</h3>
    <form method="post" action="change_details.php" onsubmit="return validateForm('change-details-form')">
        <input type="text" name="username" placeholder="Current Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="new_username" placeholder="New Username" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
        <input type="email" name="new_email" placeholder="New Email" required>
        <input type="tel" name="new_phone_number" placeholder="New Phone Number" required>
        <input type="submit" value="Change Details" name="submit_change_details">
    </form>
</div>


<div id="delete-account" class="settings-option" style="display:none;">
    <h3>Delete Account</h3>
    <form method="post" action="delete_account.php" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Delete Account" name="submit_delete_account">
    </form>
</div>

<script>

$(document).ready(function() {
    function showOption(option) {
    // Hide all options
    $('.settings-option').hide();

    // Show the selected option
    $('#' + option).show();

    if (option === 'change-password') {
        $("#change-password-heading").show();
        $("#reset-password-form").show();
        $("#otp-section").hide();
        $("#password-update-message").hide();
    }
}
    // Send OTP on button click
    $("#submit_send_otp").click(function() {
        $.ajax({
            url: 'passswordlink.php',
            method: 'POST',
            data: {
                UserName: $("#username").val(),
                submit_send_otp: true
            },
            success: function(response) {
                console.log(response); 
                $("#otp").show();
                $("#submit_change_password").show();
                toastr.success(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            toastr.error('Error sending OTP. Please try again later.');
            console.error("Error: " + textStatus + ", " + errorThrown);
        }
        });
    });


    $('#submit_verify_otp').click(function() {
    var otp = $('#otp').val();

    if (otp === '') {
        alert('Please enter the OTP.');
        return false;
    }

    $.ajax({
        url: 'verify_otp.php',
        type: 'POST',
        data: {
            otp: otp
        },
        success: function(response) {
            if (response.trim() === 'success') {
                // Hide the OTP input and Verify OTP button
                $('#otp').hide();
                $('#submit_verify_otp').hide();
                
                // Show the Change Password form
                $("#current_password").show();
                $("#new_password").show();
                $("#confirm_new_password").show();
                $("#submit_change_password").show();
            } else {
                toastr.error('Incorrect OTP. Please try again.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});

$("#change-password-form").submit(function(e) {
        e.preventDefault();

        if ($("#new_password").val() !== $("#confirm_new_password").val()) {
            toastr.error("New Password and Confirm New Password fields do not match.");
            return;
        }

        $.ajax({
            url: 'change_password.php',
            method: 'POST',
            data: {
                username: $("#username").val(),
                current_password: $("#current_password").val(),
                new_password: $("#new_password").val(),
                otp: $("#otp").val(),
                submit_change_password: true
            },
            success: function(response) {
                toastr.success("Password changed successfully.");
                // Hide form elements after a successful password change
               $("#change-password-form").hide(); // Hide the entire form
               $("#change-password-heading").hide(); // Hide the change password heading

            },
            error: function() {
                toastr.error('Error changing password. Please try again later.');
            }
    });
});


});
    function showOption(optionId) {
        const options = document.getElementsByClassName("settings-option");
        for (let i = 0; i < options.length; i++) {
            options[i].style.display = "none";
        }
        document.getElementById(optionId).style.display = "block";
    }
</script>
</div>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Account Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-AWEHfEhZnyv5KK5K5G5fCgg5B5yLxUzKoCVpWm+aAT7aeug1dKQ1CqU6hc9U9LkHZ6gHqlv7jK6W76Qg7Zwgyw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="stylecolumn.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" />
    <script>
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.getElementsByTagName("input");

            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].value.trim() === "") {
                    alert("Please fill in all the required fields");
                    return false;
                }
            }
            return true;
        }
    </script>
</head>
<body>
<div class="notification" id="response_notification"></div>
<script>
    function showNotification(message, cssClass) {
        const notification = document.getElementById(cssClass);
        notification.textContent = message;
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000);
    }

    // check if message is present in URL and display notification if present
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        showNotification(message, 'response_notification');
    }
</script>

<div class="main-content">
    <h2>Account Settings</h2>
    <div class="settings-options">
        <button class="retro-btn" onclick="showOption('change-username')">Change Username</button>
        <button class="retro-btn" onclick="showOption('change-password')">Change Password</button>
        <button class="retro-btn" onclick="showOption('Forget-password')">Forget Password</button>

        <button class="retro-btn" onclick="showOption('change-details')">Change Details</button>
        <button class="retro-btn" onclick="showOption('delete-account')">Delete Account</button>
    </div>

    <div id="change-username" class="settings-option" style="display:none;">
        <h3>Change Username</h3>
        <form method="post" action="change_username.php" onsubmit="return validateForm('change-username-form')" id="change-username-form">

            <input type="text" name="current_username" placeholder="Current Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="new_username" placeholder="New Username" required>
            <input type="submit" value="Change Username" name="submit_change_username">
        </form>
    </div>

    <div id="change-password" class="settings-option" style="display:none;">
        <h3>Change Password</h3>
        <form method="post" action="change_password.php" onsubmit="return validateForm('change-password-form')"id="change-password-form">>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password"name="new_password" placeholder="New Password" required>
<input type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
<input type="submit" value="Change Password" name="submit_change_password">
</form>
</div>
<style>
    #verify-otp-form {
        display: none;
    }
</style>

 <div id="Forget-password" class="settings-option" style="display:none;">
        <h3>Forget Password</h3>
        <form method="post" action="passswordlink.php" onsubmit="event.preventDefault(); showOtpVerificationForm(); return validateForm('reset-password-form');" id="reset-password-form">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter your email address" required>
            <input type="submit" value="Send OTP" name="submit_send_otp">
        </form>
        <form id="verify-otp-form" method="post" action="" onsubmit="event.preventDefault(); verifyOtp(); return validateForm('verify-otp-form');">
            <label for="otp">OTP:</label>
            <input type="text" name="otp" id="otp" placeholder="Enter the OTP" required>
            <input type="submit" value="Verify OTP" name="submit_verify_otp">
        </form>
    </div>


<div id="change-details" class="settings-option" style="display:none;">
    <h3>Change Account Details</h3>
    <form method="post" action="change_details.php" onsubmit="return validateForm('change-details-form')"id="change-details-form">
        <input type="text" name="username" placeholder="Current Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="new_username" placeholder="New Username" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
        <input type="email" name="new_email" placeholder="New Email" required>
        <input type="tel" name="new_phone_number" placeholder="New Phone Number" required>
        <input type="submit" value="Change Details" name="submit_change_details">
    </form>
</div>


<div id="delete-account" class="settings-option" style="display:none;">
    <h3>Delete Account</h3>
    <form method="post" action="delete_account.php" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')"id="delete-account-form">>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Delete Account" name="submit_delete_account">
    </form>
</div>
    <script>
   


        function showOtpVerificationForm() {
            document.getElementById('verify-otp-form').style.display = 'block';
        }

        function verifyOtp() {
            const otp = document.getElementById('otp').value;

            // Create an XMLHttpRequest object
            const xhttp = new XMLHttpRequest();

            // Configure the request
            xhttp.open('POST', 'verify_otp.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // Handle the response
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Update the page based on the response
                    if (this.responseText === 'success') {
                        alert('The OTP you entered is correct. Please reset your password.');
                    } else {
                        alert('The OTP you entered is incorrect. Please try again.');
                    }
                }
            };

            // Send the request
            xhttp.send('otp=' + otp);
        }
    
  
</script>

</div>
</body>
</html> -->
