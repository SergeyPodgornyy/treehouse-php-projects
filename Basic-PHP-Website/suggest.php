<?php 

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
	$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
	$details = trim(filter_input(INPUT_POST, 'details', FILTER_SANITIZE_SPECIAL_CHARS));

	if($name == "" || $email == "" || $details == ""){
		echo "Please fill in the required fields: Name, Email and Details!";
		exit;
	}
	if ($_POST["address"] != ""){
		echo "Bad form input!";
		exit;
	}

	$email_body = "<html>
		<body>
			<div style='font­-size:16px;
						font-family:Tahoma,Arial,Helvetica,Verdana,sans-serif;
						color:#333;'>
				<div>
					<img src='http://www.download-free-wallpaper.com/img85/cimqpfjpnwftuuvgyyqt.jpg' alt='Logo' width='105px' height='100px'>
					<h2 style='display:inline­-block;vertical-align:top;margin­-left:30px;'>
						Personal Media Library <br> Library
					</h2>
				</div>
				<div style='font­-size:16px;
							font-family:Tahoma,Arial,Helvetica,Verdana,sans­-serif;
							color:#333;
							border­-left:5px solid #B30606;
							padding:0 0 0 20px;'>
				<p>
					<b style='color:#B30606;'>Name</b>: ".$name."
				</p>
				<p>
					<b style='color:#B30606;'>Email</b>: ".$email."
				</p>
				<p>
					<b style='color:#B30606;'>Message</b>:<br> ".$details."
				</p>
				</div>
			</div>
		</body>
		</html>";

	require("inc/phpmailer/class.phpmailer.php");

	$mail = new PHPMailer;

	// if(!$mail->ValidateAddress($mail)){
	// 	echo "Invalide Email Address!";
	// 	exit;
	// }

	$mail->setFrom($email, $name);
	$mail->addAddress('sergey@localhost', 'Sergey');     // Add a recipient

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Personal Media Library Suggestion from ' . $name;
	$mail->Body    = $email_body;

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	    exit;
	}

	header("location:suggest.php?status=thanks");
}

$pageTitle = "Suggest a Media Item";
$section = "suggest";

include("inc/header.php"); ?>

<div class="section page">
	<div class="wrapper">
		<?php if(isset($_GET["status"])&&$_GET["status"]=="thanks"){
			echo "<h1>Thank you!</h1>\n<p>Thanks for the email! I&rsquo;ll check out your suggestion shortly!</p>";
			} else { 
		?>
		<h1>Suggest a Media Item</h1>
		<p>If you think there is something I&rsquo;m missing, let me know! Complete the form to send me an email.</p>
		<form action="suggest.php" method="POST">
			<table>
				<tr>
					<th><label for="name">Name</label></th>
					<td><input type="text" id="name" name="name"></td>
				</tr>
				<tr>
					<th><label for="email">Email</label></th>
					<td><input type="text" id="email" name="email"></td>
				</tr>
				<tr>
					<th><label for="details">Suggest Item details</label></th>
					<td><textarea name="details" id="details"></textarea></td>
				</tr>
				<tr style="display:none">
					<th><label for="address">Address</label></th>
					<td><input type="text" id="address" name="address">
					<p>Please leave this field blank.</p></td>
				</tr>
			</table>
			<input type="submit" value="Send">
		</form>
		<?php } ?>
	</div>
</div>

<?php include("inc/footer.php"); ?>