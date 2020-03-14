<?php 
  session_start();
  //include_once("header.php");
  include_once("banner.php");
  include_once("leaveUs.php");
  include_once("navBar.php");
  
  
  // check if user is authenticated
  if (!isset($_SESSION['auth']) || !$_SESSION['auth'])  {
    header("Location: https://theorganizedchef.herokuapp.com/login.php");//http://localhost/organizedchef/login.php");
    exit;
  }
  ?>
		<div class="content">
			<div class="sideBar">
				<!--These will have forms underneath them: check boxes, dropdowns, etc.
					these are placeholders-->
				<p> Add a Recipe </p>
				<hr></hr>
				<div class="filters">
					Search by Title:
				</div>
				<div class="filters">
					Filter by Category:
				</div>
				<div class="filters">
					Filter by Ingredient:
				</div>
				<div class="filters">
					Filter by Cook Time:
				</div>
			</div>
			<div class="recipes">
				query results will go here
			</div>
		</div>
<?php include_once("footer.php"); ?>