<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("connection.php");

function mask_email($email) {
    $email_parts = explode("@", $email);
    $email_username = substr($email_parts[0], 0, 3); // Change 3 to the number of characters you want to display
    $masked_email = $email_username . str_repeat('*', strlen($email_parts[0]) - 3) . '@' . $email_parts[1];
    return $masked_email;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["UserName"]) && isset($_POST["submit_send_otp"])) {
    $UserName = isset($_POST['UserName']) ? $_POST['UserName'] : null;

    if (empty($UserName)) {
        echo "The UserName field is required.";
        exit();
    }

    // Generate a random OTP
    $otp = rand(100000, 999999);

    // Store the OTP in the session
    $_SESSION["otp"] = $otp;

    // Get the Email associated with the UserName
    $stmt = $conn->prepare("SELECT Email FROM user_accounts WHERE UserName = ?");
    $stmt->bind_param("s", $UserName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Email = $row['Email'];
    } else {
        header("HTTP/1.0 400 Bad Request");
        echo "Invalid UserName";
        exit();
    }
    
      // Set the Email content
        $to = $Email;
        $subject = "One-Time Password (OTP) Verification";
        $message = "
            <html>
            <head>
                <title>One-Time Password (OTP) Verification</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f6f6f6;
                        color: #333;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        font-size: 24px;
                        font-weight: bold;
                        margin-bottom: 20px;
                    }
                    p {
                        font-size: 16px;
                        line-height: 1.5;
                        margin-bottom: 20px;
                    }
                    .otp {
                        font-size: 24px;
                        font-weight: bold;
                        color: #f44336;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Your OTP for Quick Notes</h1>
                    <p>Hello,</p>
                    <p>Thank you for using Quick Notes. Your One-Time Password (OTP) for Email verification is:</p>
                    <p class='otp'>" . $otp . "</p>
                    <p>Please enter the OTP in the verification box on the Quick Notes website to verify your Email address.</p>
                    <p>If you did not request this OTP, please ignore this Email.</p>
                    <p>Best regards,</p>
                    <p>Quick Notes Team</p>
                </div>
            </body>
            </html>
        ";

        // Set the Email headers
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: quicknotes.team@outlook.com' . "\r\n" .
            'Reply-To: ' . $Email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();        

        // Send the Email
        if (mail($to, $subject, $message, $headers)) {
            $masked_email = mask_email($Email);
            echo "An OTP has been sent to " . $masked_email . ". Please enter the OTP to verify your account.";
        } else {
            echo "Error sending OTP. Please try again later.";
            error_log("Error sending OTP Email to $to using mail() function.");
        }
        
    }

    // Close the connection
    $conn->close();

?>

