 <?php 
  session_start();
  include_once("banner.php");
  include_once("leaveUs.php");
  include_once("navBar.php");
  
  require_once 'Dao.php';
  $dao = new Dao();
  
  // check if user is authenticated
  if (!isset($_SESSION['auth']) || !$_SESSION['auth'])  {
    header("Location: https://theorganizedchef.herokuapp.com/login.php");
    exit;
  }
  ?>
		<div class="plaintext" id="recipePage">
			<h1>Recipes</h1>
			<div class="sideBar">
				<p><a href='add_recipe.php'>Add a Recipe</a></p>
				<hr></hr>
				<p><a href='clear_filters.php'>Clear Filters</a> </p>
				<hr></hr>
				<div class="filters">
					<p>
						Filter Options: 
					<form action="filter_handler.php" method="post">
						<label for="filterTitle" class="filterLab">Title:</label>
						<input type="textbox" id="filterTitle" name="filterTitle" />
					</p>
					<p>
						<label for="filterIngredient" class="filterLab">Ingredient:</label>
						<input type="textbox" id="filterIngredient" name="filterIngredient" />
					</p>	
						<p>Category:
						<label for="filterMainDish" class="filterLab">Main Dish</label>
						<input type="radio" id="filterMainDish" name="filterCategory" value="Main Dish"/>
						
						<label for="filterVeg" class="filterLab">Side Dish </label>
						<input type="radio" id="filterVeg" name="filterCategory" value="Side Dish"/>
						
						<label for="filterAppetizers" class="filterLab">Appetizer </label>
						<input type="radio" id="filterAppetizers" name="filterCategory" value="Appetizer"/>
						
						<label for="filterSoupSalad" class="filterLab">Soup/Salad </label>
						<input type="radio" id="filterSoupSalad" name="filterCategory" value="Soup/Salad"/>
						
						<label for="filterBreads" class="filterLab">Bread </label>
						<input type="radio" id="filterBreads" name="filterCategory" value="Breads"/>	
						
						<label for="filterDessert" class="filterLab">Dessert</label>
						<input type="radio" id="filterDessert" name="filterCategory" value="Dessert"/>
						
						<label for="filterMisc" class="filterLab">Misc.</label>
						<input type="radio" id="filterMisc" name="filterCategory" value="Misc."/>
						
						<div><input type="Submit" value="Search"/></div>
						</p>
				</form>
				</div>
			</div>
			<div class="recipes">
				    <table>
						<thead>
							<tr>
							  <th>Edit Recipe</th>
							  <th>Title (click to view)</th>
							  <th>Author</th>
							  <th>Category</th>
							  <th>Prep Time</th>
							  <th>Cook Time</th>
							  <th>Source</th>
							  <th>Source Link</th>
							  <th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							if(isset($_SESSION['filter']) && $_SESSION['filter'])  {
							   $recipes = $dao->getRecipesWhere($_SESSION['user'], $_SESSION['filterTitle'], $_SESSION['filterIngredient'], $_SESSION['filterCategory']);
							}else{
								$recipes = $dao->getAllRecipes($_SESSION['user']);
							}
							if(is_null($recipes)){
								echo "Error message";
							}else {
								foreach($recipes as $recipe){
								  echo "<tr><td><a href='edit_recipe.php?editid={$recipe['recipe_id']}'>Edit</a></td>
								        <td class='view'><a href='view_recipe.php?id={$recipe['recipe_id']}'>" . htmlspecialchars($recipe['title']) . "</a></td>
										<td>" .   htmlspecialchars($recipe['author']) ."</td>
										<td>" .  htmlspecialchars($recipe['category']) ."</td>
										<td>" .  htmlspecialchars($recipe['prep_time'])."</td>
										<td>" .  htmlspecialchars($recipe['cook_time']) ."</td>
										<td>" .  htmlspecialchars($recipe['source']) ."</td>
										<td>"; 
										if($recipe['link']==""){echo "N/A";}else{ echo "<a href='" . $recipe['link'] . "'> Visit Source</a>";}
										echo "</td>
										<td class='delete'><a href='delete_recipe.php?recipeid={$recipe['recipe_id']}'>X</a></td></tr>";
								}
							}
						?>		
						</tbody>
					</table>
			</div>
		</div>
<?php include_once("footer.php"); ?>