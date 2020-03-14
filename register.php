<?php
  session_start();
  include_once("banner.php");
?>
	<div class="plaintext" id="register">
		<h1>Please register below</h1>
		<?php
		if (isset($_SESSION['error'])) {
		  echo "<div id='error'>{$_SESSION['error']}</div>";
		  unset($_SESSION['error']);
		}
		?>
		<form action="register_handler.php" method="post">
		  <div><label for="username">Email address:<input type="textbox" id="username" name="username" /></div>
			<div><label for="password">Password:<input type="password" id="password" name="password" /></div>
			<div><label for="cnfmpassword">Confirm Password:<input type="password" id="cnfmpassword" name="cnfmpassword" /></div>
			<div id="registerButton"><input type="submit"/></div>
		</form>
	</div>	
<?php include_once("footer.php"); ?>