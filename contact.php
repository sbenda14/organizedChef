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
		<div class="content">
			<div class="plainText" id="contact">
				<h1>Contact Us</h1>
				<p> Have questions, comments or requests? Send us an email by filling out the form below!</p>
			</div>
			<div class="contactForm plainText">
				<!-- contact form will go here. -->
				form will go here
			</div>
		</div>
<?php include_once("footer.php"); ?>