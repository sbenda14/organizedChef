<?php
class Dao {

  private $host = 'us-cdbr-iron-east-04.cleardb.net';
  private $dbname = 'heroku_a8613588709018f';
  private $username = 'be6e04cbad5ae8';
  private $password = 'dbc99fb0';

  public function __construct() {
  }

  public function getConnection() {
    try {
       $connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", "{$this->username}", "{$this->password}");
    } catch (Exception $e) {
		print("<pre>" . print_r($e,1). "</pre>");
		return null;
    }
    return $connection;
  }

  public function addUser($email, $password){
	$conn = $this->getConnection();
	if(is_null($conn)) {
      return;
    }
	$checkQuery = "select * from userinfo where email = :email";
    $q = $conn->prepare($checkQuery);
	$q->execute(['email' => $email]); 
	$result = 0;
	if ($q->rowCount() > 0) { //assuming emails are unique here.
		$result = 0;
	}else{
	  	$saveQuery = "insert into userinfo (email, password) values (:eml, :pswrd)";
		$q = $conn->prepare($saveQuery);
		$q->bindParam(":eml", $email);
		$q->bindParam(":pswrd", $password);
		$q->execute();
		//return user id...
		$checkQuery = "select * from userinfo where email = :email";
		$q2 = $conn->prepare($checkQuery);
		$q2->execute(['email' => $email]); 
		$user = $q2->fetch(PDO::FETCH_ASSOC);
		if ($q2->rowCount() > 0) {		
			$result = $user['user_id'];	
		}
	}
	
	return $result;	
  }
  
  //login functions
  public function verifyUser($password, $email){	 
	$conn = $this->getConnection();
	if(is_null($conn)) {
      return;
    }
    $checkQuery = "select * from userinfo where email = :email";
    $q = $conn->prepare($checkQuery);
	$q->execute(['email' => $email]); 
	$user = $q->fetch(PDO::FETCH_ASSOC);
	$result = 0;
	if ($q->rowCount() > 0) { //assuming emails are unique here.
		if ($user['password'] == $password){
			$result = $user['user_id'];
		}
	}
	return $result;
  }
  
  //basic get/save/update/delete recipe functions	
  public function getRecipe($recipeID, $userID) {
    $conn = $this->getConnection();
    try {
		$queryStmt = "select * from recipe where recipe_id = :recipe AND user_id = :user";
		$q = $conn->prepare($queryStmt);
		$q->bindParam(":recipe", $recipeID);
		$q->bindParam(":user", $userID);
		$q->execute();
	return $q->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
      echo print_r($e,1);
      exit;
    }
  }

  public function saveRecipe($title, $category, $prep, $cook, $author, $source, $link, $ingred, $directions, $userID) {
    $conn = $this->getConnection();
	if(is_null($conn)) {
      return;
    }
    $saveQuery = "insert into recipe (title, category, prep_time, cook_time, author, source, link, ingredients, directions, user_id) values (:title, :category, :prep_time, :cook_time, :author, :src, :link, :ingredients, :directions, :user_id)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":title", $title);
	$q->bindParam(":category", $category);
	$q->bindParam(":prep_time", $prep);
	$q->bindParam(":cook_time", $cook);
	$q->bindParam(":author", $author);
	$q->bindParam(":src", $source);
	$q->bindParam(":link", $link);
	$q->bindParam(":ingredients", $ingred);
	$q->bindParam(":directions", $directions);
	$q->bindParam(":user_id", $userID);
    $q->execute();
  }
  
  public function updateRecipe($title, $category, $prep, $cook, $author, $source, $link, $ingred, $directions, $recipeID) {
    $conn = $this->getConnection();
	if(is_null($conn)) {
      return;
    }
    $saveQuery = "update recipe set title = :title, category = :category, prep_time = :prep_time, cook_time = :cook_time, author= :author, source=:src, link = :link, ingredients = :ingredients, directions = :directions where recipe.recipe_id = :recipeID";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":title", $title);
	$q->bindParam(":category", $category);
	$q->bindParam(":prep_time", $prep);
	$q->bindParam(":cook_time", $cook);
	$q->bindParam(":author", $author);
	$q->bindParam(":src", $source);
	$q->bindParam(":link", $link);
	$q->bindParam(":ingredients", $ingred);
	$q->bindParam(":directions", $directions);
	$q->bindParam(":recipeID", $recipeID);
    $q->execute();
  }

  public function deleteRecipe($recipeID, $userID) {
    $conn = $this->getConnection();
    $deleteQuery = "delete from recipe where recipe_id = :id AND user_id = :user";
    $q = $conn->prepare($deleteQuery);
    $q->bindParam(":id", $recipeID);
	$q->bindParam(":user", $userID);
    $q->execute();
  }
 
  //functions for sorted/filtered recipes
  public function getAllRecipes($userID){
	$conn = $this->getConnection();
    try {
		$queryStmt ="select recipe_id, title, category, prep_time, cook_time, author, source, link  from recipe where user_id = :user order by title asc";
		$q = $conn->prepare($queryStmt);
		$q->bindParam(":user", $userID);
		$q->execute();
	return $q->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
      echo print_r($e,1);
      exit;
    }  
  } //default for recipe table. order by title

  public function getRecipesWhere($userID, $title, $ingredient, $category){
	$conn = $this->getConnection();
    try {
		$queryStmt = "select recipe_id, title, category, prep_time, cook_time, author, source, link  from recipe where user_id = :user
		AND title LIKE :title AND ingredients LIKE :ingred AND category LIKE :cat order by title asc";
		$q = $conn->prepare($queryStmt);
		$q->bindParam(":user", $userID);
		$q->bindParam(":title", $title);
		$q->bindParam(":ingred", $ingredient);
		$q->bindParam(":cat", $category);
		$q->execute();
	return $q->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
      echo print_r($e,1);
      exit;
    }  
  } //add in filters to search here. if none, report none. decide on filter order...
  
  public function addContact($contactName, $contactEmail, $subject, $contactText){
	$conn = $this->getConnection();
	if(is_null($conn)) {
      return 0;
    }
    $saveQuery = "insert into contactus (contactEmail, contactName, contactSubject, contactText) values (:email, :name, :sub, :words)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":email", $contactName);
	$q->bindParam(":name", $contactEmail);
	$q->bindParam(":sub", $subject);
	$q->bindParam(":words", $contactText);
    $q->execute();
	return 1;
  }
   
}