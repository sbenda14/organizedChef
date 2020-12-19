<?php 
  session_start();
  include_once("../components/banner.php");
  include_once("../components/leaveUs.php");
  include_once("../components/navBar.php");
  
  
  // check if user is authenticated
  if (!isset($_SESSION['auth']) || !$_SESSION['auth'])  {
    header("Location: https://theorganizedchef.herokuapp.com/pages/login/login.php");
    exit;
  }
  ?>
  	<div class="plaintext" id="addRecipe">
		<h1>Add Recipe</h1>
		<p>*fields are required</p>
		<?php
			if (isset($_SESSION['errors'])) {
			  foreach($_SESSION['errors'] as $error){
				echo "<div class='error'>{$error}<span class='close_error'>X</span></div>";
			  }
			  unset($_SESSION['errors']);
			}
			$title_preset = "";
			$author_preset = "";
			$category_preset = "";
			$prep_preset = "";
			$cook_preset = "";
			$source_preset = "";
			$link_preset = "";
			$ingredients_preset = "";
			$directions_preset = "";
			if (isset($_SESSION['addForm'])) {
				$title_preset = $_SESSION['addForm']['recipeTitle'];
				$author_preset = $_SESSION['addForm']['recipeAuthor'];
				if (isset($_SESSION['addForm']['category'])) {$category_preset = $_SESSION['addForm']['category'];}
				$prep_preset = $_SESSION['addForm']['prep'];
				$cook_preset = $_SESSION['addForm']['cook'];
				$source_preset = $_SESSION['addForm']['source'];
				$link_preset = $_SESSION['addForm']['recipeLink'];
				$ingredients_preset = $_SESSION['addForm']['ingredients'];
				$directions_preset = $_SESSION['addForm']['directions'];
			}
			?>
	<div class="addEditRecipe">
    <form action="addRecipe_handler.php" method="post">
        <div>
			<label for="recipeTitle" class="addEdit">Title*: </label>
			<input type="textbox" id="recipeTitle" name="recipeTitle" value = "<?php echo $title_preset; ?>" />
		</div>
		<div>
			<label for="recipeAuthor" class="addEdit">Author: </label>
			<input type="textbox" id="recipeAuthor" name="recipeAuthor" value = "<?php echo $author_preset; ?>"/>
		</div>
		<div class="category">
			<div>
				<p>Select a category:</p>
				<label for="Main Dish" class="addEdit">Main Dish </label>
				<input type="radio" id="Main Dish" name="category" value="Main Dish" <?php if($category_preset == "Main Dish") { echo "checked ='checked'";} ?>/>
				
				<label for="Side Dish" class="addEdit">Side Dish </label>
				<input type="radio" id="Side Dish" name="category" value="Side Dish" <?php if($category_preset == "Side Dish") { echo "checked ='checked'";} ?>/>
				
				<label for="Appetizer" class="addEdit">Appetizer </label>
				<input type="radio" id="Appetizer" name="category" value="Appetizer" <?php if($category_preset == "Appetizer") { echo "checked ='checked'";} ?>/>
			</div>
			<div>
				<label for="Soup/Salad" class="addEdit">Soup/Salad </label>
				<input type="radio" id="Soup/Salad" name="category" value="Soup/Salad" <?php if($category_preset == "Soup/Salad") { echo "checked ='checked'";} ?>/>
				
				<label for="Breads" class="addEdit">Bread</label>
				<input type="radio" id="Breads" name="category" value="Breads" <?php if($category_preset == "Breads") { echo "checked ='checked'";} ?>/>
				
				<label for="Dessert" class="addEdit">Dessert </label>
				<input type="radio" id="Dessert" name="category" value="Dessert" <?php if($category_preset == "Dessert") { echo "checked ='checked'";} ?>/>
			</div>
			<div>
				<label for="Misc." class="addEdit">Miscellaneous </label>
				<input type="radio" id="Misc." name="category" value="Misc." <?php if($category_preset == "Misc.") { echo "checked ='checked'";} ?>/>
			</div>
		</div>
        <div>
			<label for="prep" class="addEdit">Prep Time: </label>
			<input type="textbox" id="prep" name="prep" value = "<?php echo $prep_preset; ?>"/>
		</div>
		<div>
			<label for="cook" class="addEdit">Cook Time: </label>
			<input type="textbox" id="cook" name="cook" value = "<?php echo $cook_preset; ?>"/>
		</div>
		<div>
			<label for="source" class="addEdit">Source: </label>
			<input type="textbox" id="source" name="source" value = "<?php echo $source_preset; ?>"/>
		</div>
		<div>
			<label for="recipeLink" class="addEdit">Source Link: </label>
			<input type="textbox" id="recipeLink" name="recipeLink" value = "<?php echo $link_preset; ?>"/>
		</div>
		<div>
			<label for="ingredients" class="addEdit">Ingredients: </label>
			<textarea rows= "10" cols="40" id="ingredients" name="ingredients"> <?php echo $ingredients_preset; ?></textarea>
		</div>
		<div>
			<label for="directions" class="addEdit">Directions: </label>
			<textarea rows= "10" cols="40" id="directions" name="directions"> <?php echo $directions_preset; ?> </textarea>
		</div>
        <div class="submitButton"><input type="submit"/></div>
    </form>
	</div>
	</div>
<?php include_once("../components/footer.php"); ?>