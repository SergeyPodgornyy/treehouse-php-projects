<?php 
include("inc/data.php");
include("inc/functions.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
	$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
	$category = trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING));
	$title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
	$format = trim(filter_input(INPUT_POST, 'format', FILTER_SANITIZE_STRING));
	$genre = trim(filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_STRING));
	$year = trim(filter_input(INPUT_POST, 'year', FILTER_SANITIZE_STRING));
	$details = trim(filter_input(INPUT_POST, 'details', FILTER_SANITIZE_SPECIAL_CHARS));

	if($name == "" || $email == "" || $category == "" || $title == ""){
		$error_message = "Please fill in the required fields: Name, Email, Category and Title!";
	}
	if (!isset($error_message) && $_POST["address"] != ""){
		$error_message = "Bad form input!";
	}

	require("inc/phpmailer/class.phpmailer.php");

	$mail = new PHPMailer;

	if(!isset($error_message) && !$mail->ValidateAddress($email)){
		$error_message = "Invalide Email Address!";
	}

	if(!isset($error_message)){
		send_email($mail,$name,$email,$category,$title,$format,$genre,$year,$details);

		$error_message = 'Message could not be sent.';
		$error_message = 'Mailer Error: ' . $mail->ErrorInfo;
	}
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
		<?php
			if(isset($error_message)){
				echo "<p class='message'>".$error_message."</p>";
			}else{
				echo "<p>If you think there is something I&rsquo;m missing, let me know! Complete the form to send me an email.</p>";
			}
		?>
		<form action="suggest.php" method="POST">
			<table>
				<tr>
					<th><label for="name">Name <span class="required">(required)</span></label></th>
					<td><input type="text" id="name" name="name" <?php echo isset($name)?"value='".$name."'":""; ?>></td>
				</tr>
				<tr>
					<th><label for="email">Email <span class="required">(required)</span></label></th>
					<td><input type="text" id="email" name="email" <?php echo isset($email)?"value='".$email."'":""; ?>></td>
				</tr>
				<tr>
					<th><label for="category">Category <span class="required">(required)</span></label></th>
					<td><select id="category" name="category" <?php echo isset($name)?"value='".$name."'":""; ?>>
							<option value="">Select One</option>
							<option value="Books" <?php if(isset($category) && $category=="Books"){ echo "selected";}?>>Book</option>
							<option value="Movies" <?php if(isset($category) && $category=="Movies"){ echo "selected";}?>>Movie</option>
							<option value="Music" <?php if(isset($category) && $category=="Music"){ echo "selected";}?>>Music</option>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="title">Title <span class="required">(required)</span></label></th>
					<td><input type="text" id="title" name="title" <?php echo isset($title)?"value='".$title."'":""; ?>></td>
				</tr>
				<tr>
	                <th>
	                    <label for="format">Format</label>
	                </th>
	                <td>
	                    <select name="format" id="format">
	                        <option value="">Select One</option>
	                        <?php
								get_options_list($formats,$format);
							?>
	                    </select>
	                </td>
	            </tr>
				<tr>
	                <th>
	                    <label for="genre">Genre</label>
	                </th>
	                <td>
	                    <select name="genre" id="genre">
	                        <option value="">Select One</option>
	                        <?php
								get_options_list($genres,$genre);
							?>
	                    </select>
	                </td>
	            </tr>
				<tr>
					<th><label for="year">Year</label></th>
					<td><input type="text" id="year" name="year" <?php echo isset($year)?"value='".$year."'":""; ?>></td>
				</tr>
				<tr>
					<th><label for="details">Additional details</label></th>
					<td><textarea name="details" id="details"> <?php echo isset($details)?$details:""; ?> </textarea></td>
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