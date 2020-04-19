<?php
  session_start();
  include_once("banner.php");
  include_once("joinUs.php");
  include_once("navBar.php");
?>
	<div class="plaintext" id="login">
		<h1>Please log in</h1>
		<?php
			if (isset($_SESSION['errors'])) {
			  foreach($_SESSION['errors'] as $error){
				echo "<div class='error'>{$error}<span class='close_error'>X</span></div>";
			  }
			  unset($_SESSION['errors']);
			}
			$email_preset = "";
			$pw_preset = "";
			if (isset($_SESSION['logForm'])) {
				$email_preset = $_SESSION['logForm']['email'];
				$pw_preset = $_SESSION['logForm']['password'];
			}
			?>
    <form action="login_handler.php" method="post">
        <div>
			<label for="email">Email:</label>
			<input type="textbox" id="email" name="email" value="<?php echo $email_preset; ?>"/>
		</div>
        <div>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" value="<?php echo $pw_preset; ?>" />
		</div>
        <div id="loginButton"><input type="submit"/></div>
    </form>
	</div>
<?php include_once("footer.php"); ?>