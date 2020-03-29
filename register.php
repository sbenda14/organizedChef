<?php
  session_start();
  include_once("banner.php");
?>
	<div class="plaintext" id="register">
		<h1>Please register below</h1>
		<?php
		if (isset($_SESSION['errors'])) {
		  foreach($_SESSION['errors'] as $error){
			echo "<div class='error'>{$error}</div>";
		  }
		  unset($_SESSION['errors']);
		}
		$email_preset = "";
		$pw_preset = "";
		if (isset($_SESSION['regForm'])) {
			$email_preset = $_SESSION['regForm']['username'];
			$pw_preset = $_SESSION['regForm']['password'];
		}
		?>
		<form action="register_handler.php" method="post">
		  <div>
			<label for="username" class="regLabel">Email address:</label>
			<input type="textbox" id="username" name="username" value="<?php echo $email_preset; ?>"/>
		  </div>
		  <div>
			<label for="password" class="regLabel">Password:</label>
			<input type="password" id="password" name="password" value="<?php echo $pw_preset; ?>" />
		  </div>
		  <div>
			<label for="cnfmpassword" class="regLabel">Confirm Password:</label>
			<input type="password" id="cnfmpassword" name="cnfmpassword" />
		  </div>
		  <div id="registerButton"><input type="submit"/></div>
		</form>
	</div>	
<?php include_once("footer.php"); ?>