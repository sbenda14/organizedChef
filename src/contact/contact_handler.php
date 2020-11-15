<?php
  session_start(); 
  require_once '../../server/Dao.php';
  $dao = new Dao();
  
  $errors = array();
 //validate email is an email and password is not blank
 if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$_POST['contactEmail'])){
	$errors[] = "Please enter a valid email address, e.g. name@gmail.com"; 
 }
 if($_POST['contactName'] == "" || $_POST['contactText'] == "" || $_POST['contactEmail'] == ""){
	$errors[] = "Email, Name and Text fields cannot be blank"; 
 }
 if(strlen($_POST['contactName']) > 256 || strlen($_POST['contactText']) >256  || strlen($_POST['contactEmail']) >256){
	$errors[] = "Email, Name and Text fields must be less than 256 characters"; 
 }
 //need to sanitize html/sql injection
 
 if(0 < count($errors)){
	$_SESSION['contactForm'] = $_POST;
	$_SESSION['errors'] = $errors;
	$_SESSION['auth']=false;
    header("Location: https://theorganizedchef.herokuapp.com/contact.php"); 
    exit;
 }
 
 //If valid entries, check against users in database:
 
  $submitContact = $dao->addContact($_POST['contactName'], $_POST['contactEmail'], $_POST['subject'], $_POST['contactText']);

  if($submitContact == 0) {
    $_SESSION['contactForm'] = $_POST;
	$errors[] = "Error with database connection";
    $_SESSION['errors'] = $errors;
    header("Location:  https://theorganizedchef.herokuapp.com/contact.php"); 
    exit;
  }else{
	$_SESSION['submitted'] = true;  
  }
  
  unset($_SESSION['contactForm']);
  header("Location: https://theorganizedchef.herokuapp.com/contact.php");
  