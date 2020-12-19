<?php
  session_start(); 
  require_once '/server/Dao.php';
  $dao = new Dao();
  
  $errors = array();
 //validate email is an email and password is not blank
 if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$_POST['email'])){
	$errors[] = "Please enter a valid email address, e.g. name@gmail.com"; 
 }
 if($_POST['password'] == ""){
	$errors[] = "Password cannot be blank"; 
 }
 
 if(0 < count($errors)){
	$_SESSION['logForm'] = $_POST;
	$_SESSION['errors'] = $errors;
	$_SESSION['auth']=false;
    header("Location: https://theorganizedchef.herokuapp.com/pages/login/login.php"); 
    exit;
 }
 
 //If valid entries, check against users in database:
  $salt = 'aksjdfiowegnkgjnckjadsghiekbngj';
  $pw = hash('sha256', $_POST['password'] . $salt);
  $matchUser = $dao->verifyUser($pw, $_POST['email']);

  if($matchUser == 0) {
    $_SESSION['logForm'] = $_POST;
	$errors[] = "Error, email or password do not match";
    $_SESSION['errors'] = $errors;
	$_SESSION['auth']=false;
    header("Location: https://theorganizedchef.herokuapp.com/pages/login/login.php"); 
    exit;
  }
  
  //If user exists and password valid, then go to recipe page
  unset($_SESSION['logForm']);
  $_SESSION['user']= $matchUser; //I know this isn't secure. will need to adjust
  $_SESSION['auth']=true;
  header("Location: https://theorganizedchef.herokuapp.com/pages/recipes/recipes.php");
  exit;