<?php
  session_start();
  include_once("banner.php");
  include_once("leaveUs.php");
  include_once("navBar.php");
  
  // check if user is authenticated
  if (!isset($_SESSION['auth']) || !$_SESSION['auth'])  {
    header("Location: https://theorganizedchef.herokuapp.com/login.php");
    exit;
  }
  
  require_once 'Dao.php';
  $dao = new Dao();
?>
    <div class="plaintext" id="editRecipe">
		<?php
			if (isset($_SESSION['errors'])) {
			  foreach($_SESSION['errors'] as $error){
				echo "<div class='error'>{$error}</div>";
			  }
			  unset($_SESSION['errors']);
			}else{		
				$recipe = $dao->getRecipe($_GET['editid'], $_SESSION['user']);			
				
				$title_preset = htmlspecialchars($recipe['title']);
				$author_preset = htmlspecialchars($recipe['author']);
				$category_preset = htmlspecialchars($recipe['category']);
				$prep_preset = htmlspecialchars($recipe['prep_time']);
				$cook_preset = htmlspecialchars($recipe['cook_time']);
				$source_preset = htmlspecialchars($recipe['source']);
				$link_preset = $recipe['link'];
				$ingredients_preset = htmlspecialchars($recipe['ingredients']);
				$directions_preset = htmlspecialchars($recipe['directions']);
				$recipe_preset = htmlspecialchars($recipe['recipe_id']);
			}
			if (isset($_SESSION['editForm'])) {
					$title_preset = $_SESSION['editForm']['editTitle'];
					$author_preset = $_SESSION['editForm']['editAuthor'];
					if (isset($_SESSION['editForm']['editcategory'])){$category_preset = $_SESSION['editForm']['editcategory'];}
					$prep_preset = $_SESSION['editForm']['editprep'];
					$cook_preset = $_SESSION['editForm']['editcook'];
					$source_preset = $_SESSION['editForm']['editSource'];
					$link_preset = $_SESSION['editForm']['editLink'];
					$ingredients_preset = $_SESSION['editForm']['editingredients'];
					$directions_preset = $_SESSION['editForm']['editdirections'];
					$recipe_preset = $_SESSION['editForm']['editid'];
			}	
		?>	
	<div class="addEditRecipe">
		<h1> Edit Recipe: <?php echo $title_preset; ?></h1> 
		<p>*fields are required</p>
		<form action="editRecipe_handler.php" method="post">
        <div>
			<label for="editTitle" class="addEdit">Title*: </label>
			<input type="textbox" id="editTitle" name="editTitle" value = "<?php echo $title_preset; ?>"/>
			</div>
		<div>
			<label for="editAuthor" class="addEdit">Author: </label>
			<input type="textbox" id="editAuthor" name="editAuthor" value = "<?php echo $author_preset; ?>"/>
		</div>
		<div class="category">
		<div>
			<p>Select a category:</p>
			<label for="editMain Dish" class="addEdit">Main Dish </label>
			<input type="radio" id="editMain Dish" name="editcategory" value="Main Dish" <?php if($category_preset == "Main Dish") { echo "checked ='checked'";} ?>/>
			
			<label for="editSide Dish" class="addEdit">Side Dish </label>
			<input type="radio" id="editSide Dish" name="editcategory" value="Side Dish" <?php if($category_preset == "Side Dish") { echo "checked ='checked'";} ?>/>
			
			<label for="editAppetizer" class="addEdit">Appetizer </label>
			<input type="radio" id="editAppetizer" name="editcategory" value="Appetizer" <?php if($category_preset == "Appetizer") { echo "checked ='checked'";} ?>/>
		</div>
		<div>
			<label for="editSoup/Salad" class="addEdit">Soup/Salad </label>
			<input type="radio" id="editSoup/Salad" name="editcategory" value="Soup/Salad" <?php if($category_preset == "Soup/Salad") { echo "checked ='checked'";} ?>/>
			
			<label for="editBreads" class="addEdit">Bread </label>
			<input type="radio" id="editBreads" name="editcategory" value="Breads" <?php if($category_preset == "Breads") { echo "checked ='checked'";} ?>/>
			
			<label for="editDessert" class="addEdit">Dessert </label>
			<input type="radio" id="editDessert" name="editcategory" value="Dessert" <?php if($category_preset == "Dessert") { echo "checked ='checked'";} ?>/>
		</div>
		<div>
			<label for="editMisc." class="addEdit">Miscellaneous </label>
			<input type="radio" id="editMisc." name="editcategory" value="Misc." <?php if($category_preset == "Misc.") { echo "checked ='checked'";} ?>/>
		</div>
		</div>
        <div>
			<label for="editprep" class="addEdit">Prep Time: </label>
			<input type="textbox" id="editprep" name="editprep" value = "<?php echo $prep_preset; ?>"/>
		</div>
		<div>
			<label for="editcook" class="addEdit">Cook Time: </label>
			<input type="textbox" id="editcook" name="editcook" value = "<?php echo $cook_preset; ?>"/>
		</div>
		<div>
			<label for="editSource" class="addEdit">Source: </label>
			<input type="textbox" id="editSource" name="editSource" value = "<?php echo $source_preset; ?>"/>
		</div>
		<div>
			<label for="editLink" class="addEdit">Source Link: </label>
			<input type="textbox" id="editLink" name="editLink" value = "<?php echo $link_preset; ?>"/>
		</div>
		<div>
			<label for="editingredients" class="addEdit">Ingredients:</label>
			<textarea rows= "10" cols="40" id="editingredients" name="editingredients"><?php  echo $ingredients_preset; ?> </textarea>
		</div>
		<div>
			<label for="editdirections" class="addEdit">Directions: </label>
			<textarea rows= "10" cols="40" id="editdirections" name="editdirections"><?php echo $directions_preset; ?> </textarea>
		</div>
		<input type="hidden" id="editid" name="editid" value="<?php echo $recipe_preset; ?>">
        <div class="submitButton"><input type="submit" value="Update"/></div>
		</form>
	</div>
	</div>
<?php include_once("footer.php"); ?>