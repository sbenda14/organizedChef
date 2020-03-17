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
		echo "Problem connecting to database";
		echo print_r($e,1);
		return null;
    }
    return $connection;
  }

  public function addUser(){
	//add name, email, password to table userInfo
	
  }
  
  //login functions
  public function verifyUser($password, $email){	 
	$conn = $this->getConnection();
	if(is_null($conn)) {
      return false;
    }
    $checkQuery = "select * from userinfo where email = :email";
    $q = $conn->prepare($checkQuery);
	$q->execute(['email' => $email]); 
	$user = $q->fetch(PDO::FETCH_ASSOC);
	$result = false;
	if ($q->rowCount() > 0) { //assuming emails are unique here.
		if ($user['password'] == $password){
			$result = true;
		}
	}
	return $result;
  }
  
  public function updatePassword(){}//do i want this?
  public function updateEmail(){}//after successful login, ok
  
  //basic get/save/update/delete recipe functions	
  public function getRecipe() {
    $conn = $this->getConnection();
    try {
    return $conn->query("select comment_id, comment, date_entered  from comment order by date_entered desc", PDO::FETCH_ASSOC);
    } catch(Exception $e) {
      echo print_r($e,1);
      exit;
    }
  }

  public function saveRecipe($comment) {
    $conn = $this->getConnection();
    $saveQuery = "insert into comment (comment) values (:comment)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":comment", $comment);
    $q->execute();
  }
  
  public function saveIngredients($comment) {
  }
  
  public function saveCategories($comment) {
  }  
  
  public function updateRecipe(){
	  //ingredients categories separate, unless there is a way to add all at once?
  }
  
  public function updateIngredients(){
	  
  }
   
  public function updateCategories(){
	  
  }

  public function deleteRecipe($id) {
    $conn = $this->getConnection();
    $deleteQuery = "delete from comment where comment_id = :id";
	//will have to delete from recipe, ingredients and categories tables
    $q = $conn->prepare($deleteQuery);
    $q->bindParam(":id", $id);
    $q->execute();
  }
 
  //functions for sorted/filtered recipes
  public function getAllRecipes(){} //default for recipe table. order by title

  public function getRecipesWhere(){} //add in filters to search here. if none, report none. decide on filter order...
  
  public function sortRecipes(){} // for existing recipes, sort?
  
}