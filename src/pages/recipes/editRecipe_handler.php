<?php
  session_start();
  require_once '../../server/Dao.php';
  $dao = new Dao();
  
  $errors = array();
  // Title field must be entered
  if($_POST['editTitle'] == ""){
	$errors[] = "Title cannot be blank"; 
  }
  if(strlen($_POST['editTitle']) > 256){
	$errors[] = "Title must be less than 256 characters"; 
  }
  if(strlen($_POST['editAuthor']) > 256){
	$errors[] = "Author field must be less than 256 characters"; 
  }
  if(strlen($_POST['editSource']) > 256){
	$errors[] = "Recipe source must be less than 256 characters"; 
  }
  if(strlen($_POST['editLink']) > 256){
	$errors[] = "Recipe link must be less than 256 characters"; 
  }
  if(strlen($_POST['editcategory']) > 64){
	$errors[] = "Category must be less than 64 characters"; 
	//these should always be correct...
  }
  if(strlen($_POST['editprep']) > 64){
	$errors[] = "Prep time must be less than 64 characters"; 
  }
  if(strlen($_POST['editcook']) > 64){
	$errors[] = "Cook time must be less than 64 characters"; 
  }
  
  
  if(0 < count($errors)){
	$_SESSION['editForm'] = $_POST;
	$_SESSION['errors'] = $errors;
    header("Location: https://theorganizedchef.herokuapp.com/src/recipes/edit_recipe.php"); 
    exit;
 }

  $dao->updateRecipe($_POST['editTitle'], $_POST['editcategory'], $_POST['editprep'], $_POST['editcook'], $_POST['editAuthor'],
			$_POST['editSource'], $_POST['editLink'], $_POST['editingredients'], $_POST['editdirections'], $_POST['editid']);
 
  unset($_SESSION['editForm']);
  header("Location: https://theorganizedchef.herokuapp.com/src/recipes/recipes.php");//send to recipe page
  exit;