<?php
  session_start(); 
  require_once 'Dao.php';
  $dao = new Dao();
  
 //validate
  $matchUser = $dao->verifyUser($_POST['password'], $_POST['email']);
  if(!$matchUser) {
    $error = "Error, email or password do not match";
    $_SESSION['error'] = $error;
	$_SESSION['auth']=false;
    header("Location: https://theorganizedchef.herokuapp.com/login.php"); // http://localhost/organizedchef/login.php"); //home page or login in page if different
    exit;
  }
  
  //if passed, then getAllRecipes() and go to recipe page
  $_SESSION['auth']=true;
  header("Location: https://theorganizedchef.herokuapp.com/recipes.php"); //http://localhost/organizedchef/recipes.php");
  exit;
  
  // $username = "sbenda14@gmail.com";
  // $password = "abc123";

  // if ($username == $_POST['username'] && $password == $_POST['password']) {
    // $_SESSION['auth'] = true;
    // header("Location: http://localhost/organizedchef/recipes.php");
    // exit;
  // } else {
    // $_SESSION['auth'] = false;
    // $_SESSION['error'] = "Invalid username or password";
    // header("Location: http://localhost/organizedchef/login.php");
  // }