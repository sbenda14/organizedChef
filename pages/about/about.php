<?php 
  session_start();
  include_once("/pages/components/banner.php");
  if(!isset($_SESSION['auth']) || !$_SESSION['auth']){
    include_once("/pages/components/joinUs.php");
  }else	{
	include_once("/pages/components/leaveUs.php");
   }
  include_once("/pages/components/navBar.php");

 ?>
		<div class="content">
			<div class="plainText" id="about">
				<h1 id="aboutHeader">
					About
				</h1>
				<p >Hi! The creator of this page lives in Boise, Idaho with her
				husband and two monsters, Hera & Luna. When not busy studying or working,
				she enjoys cooking, hiking, gardening, and quality time with her family.
				</p>
				<div class="aboutPics">
					<img class="pups" src="/images/Hera.png" id="Hera">
					<img class="pups" src="/images/Luna.png" id="Luna">
				</div>
			</div>
		</div>		
<?php include_once("/pages/components/footer.php"); ?>
