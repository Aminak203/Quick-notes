<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_send_otp"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate a random OTP
        $otp = rand(100000, 999999);

        // Store the OTP and user's email in the session
        $_SESSION["otp"] = $otp;
        $_SESSION["email"] = $email;

        // Set the email content
        $to = $email;
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
                    <p>Thank you for using Quick Notes. Your One-Time Password (OTP) for email verification is:</p>
                    <p class='otp'>" . $otp . "</p>
                    <p>Please enter the OTP in the verification box on the Quick Notes website to verify your email address.</p>
                    <p>If you did not request this OTP, please ignore this email.</p>
                    <p>Best regards,</p>
                    <p>Quick Notes Team</p>
                </div>
            </body>
            </html>
        ";

        // Set the email headers
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: quicknotes.team@outlook.com' . "\r\n" .
            'Reply-To: ' . $email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();        

        // Send the email
        if (mail($to, $subject, $message, $headers)) {
            echo "An OTP has been sent to your email address. Please enter the OTP to verify your account.";
        } else {
            echo "Error sending OTP. Please try again later.";
            error_log("Error sending OTP email to $to using mail() function.");
        }
    } else {
        echo "Invalid email address.";
    }
    

    // Close the connection
    $conn->close();
}
?>

