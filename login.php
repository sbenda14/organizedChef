<?php
  session_start();
  include_once("banner.php");
?>
	<div class="plaintext" id="login">
		<h1>Please log in</h1>
		<?php
			if (isset($_SESSION['error'])) {
			  echo "<div id='error'>{$_SESSION['error']}</div>";
			  unset($_SESSION['error']);
			}
			?>
    <form action="login_handler.php" method="post">
        <div><label for="email">Email:<input type="textbox" id="email" name="email" /></div>
        <div><label for="password">Password:<input type="password" id="password" name="password" /></div>
        <div id="loginButton"><input type="submit"/></div>
    </form>
	</div>
<?php include_once("footer.php"); ?>