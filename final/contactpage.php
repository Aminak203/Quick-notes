<!DOCTYPE html>
<html>
    <style>
/* Update the font */
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
	border-radius: 6px;
	font-family: 'Poppins', sans-serif; /* Change the font family to Poppins */
}

/* Update the body background color */
body{
	background-image: url("https://selene.hud.ac.uk/quicknotes/final/images/logo-black.png");
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
    height: 100vh;
    width: 100%;
    background-color: rgb(87, 108, 117); /* Add the background color */
}

/* Update the text color */
h2, p, button {
    color: white; /* Add the text color */
}
input{
	color: #c4c3ca;
}

body{
	height: 100vh;
	width: 100%;
}

.container{
	position: relative;
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 20px 100px;
	flex-direction: column;
}

.container:after{
	content: '';
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	background : radial-gradient(
    rgb(87, 108, 117) 0%,
    rgb(37, 50, 55) 100.2%);
	background-size: cover;
	z-index: -1;
}
.contact-box{
	max-width: 850px;
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	justify-content: center;
	align-items: center;
	text-align: center;
	background-color: #000;
	box-shadow: 0px 0px 19px 5px rgba(0,0,0,0.19);
}

.left{
	background: url("contact.jpg");
	background-size: cover;
	height: 100%;
}

.right{
	padding: 25px 40px;
}

h2{
	position: relative;
	padding: 0 0 10px;
	margin-bottom: 10px;
}

h2:after{
	content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    height: 4px;
    width: 50px;
    border-radius: 2px;
    background-color: #2971fe;
}

.field{
	width: 100%;
	border: 2px solid rgba(0, 0, 0, 0);
	outline: none;
	background-color: #1f2029;
	padding: 0.5rem 1rem;
	font-size: 1.1rem;
	margin-bottom: 22px;
	transition: .3s;
}

.field:hover{
	background-color: lightgray;
}

textarea{
	min-height: 150px;
	color: #c4c3ca;
}

.btn1{
	width: 100%;
	padding: 0.5rem 1rem;
	background-color: #2971fe;
	color: #fff;
	font-size: 1.4rem;
	border: none;
	outline: none;
	cursor: pointer;
	transition: .3s;
}

.btn1:hover{
    background-color: rgba(255, 0, 0, 0.59);
}
/* .btn2{
	width: 300%;
	padding: 0.5 rem 1rem;
	background-color: rgb(255, 0, 0);
	color: #fff;
	position: auto ;
	font-size: 1.4rem;
	border: none;
	outline: none;
	cursor: pointer;
	transition: .3s;
}
.homebtn{
	max-width: 150%;
	padding: 1rem 1rem;
	display: block;
	position: auto ;
} */
.field:focus{
    border: 2px solid #2971fe ;
    background-color: #1f2029;
}

@media screen and (max-width: 880px){
	.contact-box{
		grid-template-columns: 1fr;
	}
	.left{
		height: 200px;
	}
}</style>
<head>
	<title>Contact us</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<meta property="og:image" content="https://selene.hud.ac.uk/quicknotes/final/images/logo-black.png">

	<link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
</head>
<body>
	<div class="container">
		<div class="contact-box">
			<div class="left"></div>
			<div class="right">
				<h2>Contact Us</h2>
				<input type="text" class="field" placeholder="Your Name" name="name">>
				<input type="text" class="field" placeholder="Your Email" email="email">">
				<input type="text" class="field" placeholder="Phone" phone="phone">>
				<textarea placeholder="Message" class="field"></textarea>
				<button class="btn1">SEND</button>
				<?php

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	   $name = $_POST['name'];
	   $email = $_POST['email'];
	   $phone = $_POST['phone'];
	   $message = $_POST['message'];
   
	   // Send the message to your email address
	   $to = 'quicknotes.team@outlook.com';
	   $subject = 'New message from Contact Us form';
	   $body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";
	   $headers = "From: $email\r\n";
	   $headers .= "Reply-To: $email\r\n";
	   $success = mail($to, $subject, $body, $headers);
   
	   // Send a reply to the user
	   if ($success) {
		   $reply_subject = 'Thank you for contacting us';
		   $reply_body = "Dear $name,\n\nThank you for your message. We will get back to you as soon as possible.\n\nBest regards,\nYour Name";
		   $reply_headers = "From: quicknotes.team@outlook.com\r\n";
		   $reply_headers .= "Reply-To: $email\r\n";
		   mail($email, $reply_subject, $reply_body, $reply_headers);
   
		   echo "<script>toastr.success('Thank you for your message. We will get back to you as soon as possible.')</script>";
	   } else {
		   echo "<script>toastr.error('Sorry, there was an error sending your message. Please try again later.')</script>";
	   }
   }
   ?>
   
			</div>
		</div>
		<!-- <div class = "homebtn"><button class="btn2"><a href="loginx.php" style="color: white; text-decoration: none;" > </a>HOME</button> </div> -->
	</div>
	<script>
    const form = document.querySelector('.contact-box');
    const sendButton = form.querySelector('.btn1');

    sendButton.addEventListener('click', function() {
        // Get the form fields
        const name = form.querySelector('input[name="name"]').value;
        const email = form.querySelector('input[name="email"]').value;
        const phone = form.querySelector('input[name="phone"]').value;
        const message = form.querySelector('textarea[name="message"]').value;

        // Send the form data to the server
        fetch('contactpage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `name=${name}&email=${email}&phone=${phone}&message=${message}`
        })
        .then(response => response.json())
        .then(data => {
            // Show a success message
            toastr.success(data.message);
            // Clear the form fields
            form.reset();
        })
        .catch(error => {
            // Show an error message
            toastr.error(error.message);
        });
    });
</script>

</body>
</html>