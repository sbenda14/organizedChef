 <?php
  session_start();
  require_once '../../server/Dao.php';
  $dao = new Dao();
  
  $errors = array();
  // Title field must be entered
   if($_POST['recipeTitle'] == ""){
	$errors[] = "Title cannot be blank"; 
  }
  if(strlen($_POST['recipeTitle']) > 256){
	$errors[] = "Title must be less than 256 characters"; 
  }
  if(strlen($_POST['recipeAuthor']) > 256){
	$errors[] = "Author field must be less than 256 characters"; 
  }
  if(strlen($_POST['source']) > 256){
	$errors[] = "Recipe source must be less than 256 characters"; 
  }
  if(strlen($_POST['recipeLink']) > 256){
	$errors[] = "Recipe link must be less than 256 characters"; 
  }
  if(strlen($_POST['category']) > 64){
	$errors[] = "Category must be less than 64 characters"; 
	//these should always be correct...
  }
  if(strlen($_POST['prep']) > 64){
	$errors[] = "Prep time must be less than 64 characters"; 
  }
  if(strlen($_POST['cook']) > 64){
	$errors[] = "Cook time must be less than 64 characters"; 
  }
  
  
  
  if(0 < count($errors)){
	$_SESSION['addForm'] = $_POST;
	$_SESSION['errors'] = $errors;
    header("Location:  https://theorganizedchef.herokuapp.com/pages/recipes/add_recipe.php"); 
    exit;
 }

  //if valid entries, save to database
  //will need to handle db connection errors at some point
  $dao->saveRecipe($_POST['recipeTitle'], $_POST['category'], $_POST['prep'], $_POST['cook'], $_POST['recipeAuthor'],
			$_POST['source'], $_POST['recipeLink'], $_POST['ingredients'], $_POST['directions'], $_SESSION['user']);
  unset($_SESSION['addForm']);
  header("Location:  https://theorganizedchef.herokuapp.com/pages/recipes/recipes.php");
  exit;
  