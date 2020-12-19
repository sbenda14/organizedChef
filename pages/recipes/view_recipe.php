<?php
  session_start();
  include_once("/pages/components/banner.php");
  include_once("/pages/components/leaveUs.php");
  include_once("/pages/components/navBar.php");
  
  // check if user is authenticated
  if (!isset($_SESSION['auth']) || !$_SESSION['auth'])  {
    header("Location: https://theorganizedchef.herokuapp.com/pages/login/login.php");
    exit;
  }
  
  require_once '/server/Dao.php';
  $dao = new Dao();
 
?>
    <div class="plaintext" id="viewRecipe">
		<?php
			if (isset($_SESSION['error'])) {
			  echo "<div id='error'>{$_SESSION['error']}</div>";
			  unset($_SESSION['error']);
			}			
			$recipe = $dao->getRecipe($_GET['id'], $_SESSION['user']);
		?>	
		<h1> <?php echo htmlspecialchars($recipe['title']); ?></h1>
		<div class="recipeInfo">
			<div class="infoSection"> <span class="inlineHeader">Author:	</span> <?php echo htmlspecialchars($recipe['author']); ?></div>
			<div class="infoSection"><span class="inlineHeader">Category: </span> <?php echo htmlspecialchars($recipe['category']); ?></div>
			<div class="infoSection"><span class="inlineHeader">Prep Time: </span> <?php echo htmlspecialchars($recipe['prep_time']); ?></div>
			<div class="infoSection"><span class="inlineHeader">Cook Time:</span> <?php echo htmlspecialchars($recipe['cook_time']); ?></div>
			<div class="infoSection"><span class="inlineHeader">Source:</span>  <?php  echo htmlspecialchars($recipe['source']);?></div>
			<div class="infoSection"><span class="inlineHeader">Source Link:</span>  <?php echo "<a href='" . $recipe['link'] . "'>original source</a>"; ?></div>
			<div class="infoSection"><span class="inlineHeader">Ingredients: </span> <div class="ingredDirect"><?php  echo str_replace("<br /><br />", "</li><li>", nl2br(htmlspecialchars($recipe['ingredients'])));?></div></div> 
			<div class="infoSection"><span class="inlineHeader">Directions: </span>  <div class="ingredDirect"><?php echo str_replace("<br /><br />", "</li><li>", nl2br(htmlspecialchars($recipe['directions']))); ?></div></div> 
		</div>
	</div>
<?php include_once("/pages/components/footer.php"); ?>