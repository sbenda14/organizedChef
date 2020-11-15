<?php
session_start();
  
  require_once '../../server/Dao.php';
  $dao = new Dao();
  
   $errors = array();
  //validate email is an email, password is not blank and passwords match
  if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$_POST['username'])){
	$errors[] = "Please enter a valid email address, e.g. name@gmail.com"; 
  }
  if($_POST['password'] == ""){
	$errors[] = "Password cannot be blank"; 
  }
  if(strlen($_POST['password'])< 6 || !ctype_alnum($_POST['password']) ){
	$errors[] = "Password must contain at least 6 alphanumeric characters"; 
  }
  if($_POST['password'] != $_POST['cnfmpassword']){
	$errors[] = "Password is not confirmed"; 
  }
 
  if(0 < count($errors)){
	$_SESSION['regForm'] = $_POST;
	$_SESSION['errors'] = $errors;
	$_SESSION['auth']=false;
    header("Location: https://theorganizedchef.herokuapp.com/src/login/register.php"); 
    exit;
 }
  
  //if valid entries, try to add to database:
  $salt = 'aksjdfiowegnkgjnckjadsghiekbngj';
  $pw = hash('sha256', $_POST['password'] . $salt);
  $newUser = $dao->addUser($_POST['username'], $pw);

  if($newUser == 0){
    $errors[] = "Error, could not register"; 
	$_SESSION['regForm'] = $_POST;
    $_SESSION['errors'] = $errors; 
	header("Location: https://theorganizedchef.herokuapp.com/src/login/register.php");
	exit;
  }
  
  //otherwise, confirm session and send to recipe page
  unset($_SESSION['regForm']);
  $_SESSION['user']= $newUser;
  $_SESSION['auth']=true;
  header("Location: https://theorganizedchef.herokuapp.com/src/recipes/recipes.php");
  exit;