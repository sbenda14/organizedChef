<?php 
  session_start();
  include_once("banner.php");
  if(!isset($_SESSION['auth']) || !$_SESSION['auth']){
    include_once("joinUs.php");
  }else	{
	include_once("leaveUs.php");
   }
  include_once("navBar.php");
 ?>
		<div class="content plaintext" id="contact">
			<h1>Contact Us</h1>
			<p> Have questions, comments or requests? Send us an email by filling out the form below!</p>
			<p>* fields are required </p>
		
			<?php
			if (isset($_SESSION['errors'])) {
			  foreach($_SESSION['errors'] as $error){
				echo "<div class='error'>{$error}<span class='close_error'>X</span></div>";
			  }
			  unset($_SESSION['errors']);
			}
			$name_preset = "";
			$email_preset = "";
			$sub_preset = "";
			$words_preset = "";
			if (isset($_SESSION['contactForm'])) {
				$name_preset = $_SESSION['contactForm']['contactName'];
				$email_preset = $_SESSION['contactForm']['contactEmail'];
				$sub_preset = $_SESSION['contactForm']['subject'];
				$words_preset = $_SESSION['contactForm']['contactText'];
			}
			if (isset($_SESSION['submitted']) && $_SESSION['submitted']) {
				echo "<p id='contactSuccess'>Your submission was successful. We will be in touch!</p>";
			}
			unset($_SESSION['submitted']);
			?>		
			<div class="plainText" id="contactForm">
			<form action="contact_handler.php" method="post">
				<div class="contactIn">
					<label for="contactName">Name*: </label>
					<input type="textbox" id="contactName" name="contactName" value = "<?php echo $name_preset; ?>" />
				</div>
				<div class="contactIn">
					<label for="contactEmail">Email*: </label>
					<input type="textbox" id="contactEmail" name="contactEmail"value = "<?php echo $email_preset; ?>" />
				</div>
				<div class="contactIn">
					<label for="subject">Subject: </label>
					<input type="textbox" id="subject" name="subject" value = "<?php echo $sub_preset; ?>"/>
				</div>
				<div class="contactIn">
					<label for="contactText">Text*: </label>
					<input type="textbox" id="contactText" name="contactText" value = "<?php echo $words_preset; ?>"/>
				</div>
				<div class="contactIn submitButton" ><input type="submit"/></div>
			</form>
			</div>
		</div>
<?php include_once("footer.php"); ?>