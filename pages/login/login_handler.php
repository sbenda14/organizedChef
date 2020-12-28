<?php
  session_start(); 
  require_once '../../vendor/autoload.php';
  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;
  $log = new Logger('login');
  //use php://stderr to connect log to Heroku logs
  $log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
  
  require_once '../../server/Dao.php';
  $dao = new Dao();
  
  $errors = array();
 //validate email is an email and password is not blank
 if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$_POST['email'])){
	$errors[] = "Please enter a valid email address, e.g. name@gmail.com";
	$log->info('invalid email format');
 }
 if($_POST['password'] == ""){
	$errors[] = "Password cannot be blank"; 
	$log->info('no password entered');
 }
 
 if(0 < count($errors)){
	$_SESSION['logForm'] = $_POST;
	$_SESSION['errors'] = $errors;
	$_SESSION['auth']=false;
    header("Location: https://theorganizedchef.herokuapp.com/pages/login/login.php"); 
    exit;
 }
 
  //If valid entries, check against users in database:
  $matchUser = $dao->verifyUser($_POST['password'], $_POST['email']);

  if($matchUser == 0) {
    $_SESSION['logForm'] = $_POST;
	$errors[] = "Error, email or password do not match";
	$log->warning('Email or password did not match', ['email' => $_POST['email']]);
    $_SESSION['errors'] = $errors;
	$_SESSION['auth']=false;
    header("Location: https://theorganizedchef.herokuapp.com/pages/login/login.php"); 
    exit;
  }
  
  //If user exists and password valid, then go to recipe page
  unset($_SESSION['logForm']);
  $_SESSION['user']= $matchUser; //I know this isn't secure. will need to adjust
  $log->info('user is logged in', ['email' => $_POST['email']]);
  $_SESSION['auth']=true;
  header("Location: https://theorganizedchef.herokuapp.com/pages/recipes/recipes.php");
  exit;