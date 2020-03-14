<?php
session_start();
  
  require_once 'Dao.php';
  $dao = new Dao();
  
  // validate
  $dao->checkEmail($_POST['email']);
  if(//check email) {
    $error = "Error, email does not exist. Check spelling";
    $_SESSION['error'] = $error;
    header("Location: https://theorganizedchef.herokuapp.com/index.php"); //home page or login in page if different
    exit;
  }
  
  $dao->checkPassword($_POST['email']);
  if (//check password) {
    $error = "Error, invalid password";
    $_SESSION['error'] = $error;
    header("Location: https://theorganizedchef.herokuapp.com/index.php"); //home page or login in page if different
    exit;
  }

  //if passed, then getAllRecipes() and go to recipe page
  header("Location: https://theorganizedchef.herokuapp.com/recipes.php");//send to recipe page?
  exit;