<?php 
  session_start();
  include_once("components/banner.php");
  if(!isset($_SESSION['auth']) || !$_SESSION['auth']){
    include_once("components/joinUs.php");
  }else	{
	include_once("components/leaveUs.php");
   }
  include_once("components/navBar.php");
 ?>
	<div class="content plainText" id="home">
		<h1 class="welcome">Welcome to The Organized Chef!</h1>
		<ul class="welcome">
			<li>Can't remember how long to bake that potato?</li>
			<li>Is your famous pumpkin pie recipe written on a napkin?</li>
			<li>Have a favorite chicken recipe online...around here somewhere?</li>
		</ul>
		<p> 
			This webpage is dedicated to reducing the time you
			spend searching for your favorite recipes. With everything in one place,you can get down to the main event---cooking!
			We provide easy to use filters to search for your favorites, or browse by ingredient if you're undecided. 
			Get started today by <a href="login/register.php">joining</a> or <a href="login/login.php">signing in</a>!
		</p>
		<p>With the Organized Chef, you can:</p>
		<div class="display">
			<div class="screenshot"><p>Add a recipe or filter by title, ingredient or category:</p> <img class="demo" src="../images/sidebar.png"></div>
			<div  class="screenshot"><p>View all recipes, or a filtered selection:</p><img class="demo" src="/images/recipeList.png"></div>
			<div  class="screenshot"><p>View recipe on page, or follow link to original page:</p><img class="demo" src="../images/recipeView.png"></div>
		</div>
		<div id="signUp" class="plainText">
				Interested? <a href="login/register.php">Join</a> today!
		</div>
	</div>
<?php include_once("components/footer.php"); ?>