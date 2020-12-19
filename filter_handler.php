<?php
  session_start();

  $_SESSION['filter'] = TRUE;
  if(empty($_POST['filterTitle'])){
	$_SESSION['filterTitle']= "%";
  }else{
	$_SESSION['filterTitle']= "%" . $_POST['filterTitle'] . "%";
  }
  if(empty($_POST['filterCategory'])){
	$_SESSION['filterCategory']= "%";
  }else{
	$_SESSION['filterCategory']= $_POST['filterCategory'];
  }
  if(empty($_POST['filterIngredient'])){
	$_SESSION['filterIngredient']= "%";
  }else{
	$_SESSION['filterIngredient']= "%". $_POST['filterIngredient'] . "%";
  }

  header("Location: https://theorganizedchef.herokuapp.com/recipes.php");//send to recipe page
  exit;
  
  