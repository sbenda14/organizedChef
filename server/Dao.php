<?php
  require_once '../../vendor/autoload.php';
  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;
 
class Dao {
  private $log;
 
  public function __construct() {
	$this->log = new Logger('Database');
	 //use php://stderr to connect log to Heroku logs
	$this->log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
  }

  public function getConnection() {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$host = $url["host"];
	$dbname = substr($url["path"],1);
	$username = $url["user"];
	$password = $url["pass"];
	try {
       $connection = new PDO("mysql:host={$host};dbname={$dbname}", "{$username}", "{$password}");
    } catch (Exception $e) {
		print("<pre> Could not connect to the database </pre>");
		$this->log->alert('Could not connect to the database!', ['error'=> print_r($e,1)]);
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
		$salt = bin2hex(random_bytes(16));
		$token = $this->getToken($conn);
		$this->log->notice('New user, token', ['user'=>$email, 'token'=>$token]);
	  	$pw = hash('sha256', $password . $salt);
		
		$saveQuery = "insert into userinfo (email, password, salt, token) values (:eml, :pswrd, :slt, :tok)";
		$q = $conn->prepare($saveQuery);
		$q->bindParam(":eml", $email);
		$q->bindParam(":pswrd", $pw);
		$q->bindParam(":slt", $salt);
		$q->bindParam(":tok", $token);
		$q->execute();
		//return user token...
		$result = $token;	
		$this->log->notice('New user added', ['user'=>$email]);
	}
	
	return $result;	
  }
  
  //login functions
  public function verifyUser($password, $email){	 
	$conn = $this->getConnection();
	if(is_null($conn)) {
      return;
    }
	$this->log->notice('Verify user', ['user'=>$email]);
    $checkQuery = "select * from userinfo where email = :email";
    $q = $conn->prepare($checkQuery);
	$q->execute(['email' => $email]); 
	$user = $q->fetch(PDO::FETCH_ASSOC);
	$result = 0;
	if ($q->rowCount() > 0) { //assuming emails are unique here.
		$pw = hash('sha256', $password . $user['salt']);
		if ($user['password'] == $pw){
			$tok = $this->getToken($conn);
			$this->log->notice('New token', ['user'=>$email, 'token'=>$tok]);
			$this->updateToken($conn, $user['user_id'], $tok);
			$result = $tok;
		}
	}
	$this->log->debug('user token is', ['token'=>$result]);
	return $result;
  }
  
  	private function getToken($conn){
		$result = 0;
		while ($result == 0){
			$tok = bin2hex(random_bytes(16));
			$checkQuery = "select * from userinfo where token = :tkn";
			$q = $conn->prepare($checkQuery);
			$q->execute([':tkn' => $tok]); 
			if($q->rowCount() >0){
				$result = 0;
			}else{
				$result = 1;
			}
		}
		return $tok;
	}
	
	private function updateToken($conn, $userID, $tok){
	    $saveQuery = "update userinfo set token = :tkn where user_id = :user";
		$q = $conn->prepare($saveQuery);
		$q->bindParam(":tkn", $tok);
		$q->bindParam(":user", $userID);
		$q->execute();
	}
	
	private function getUserID($conn, $tok){
		$result = 0;
		$checkQuery = "select * from userinfo where token = :tkn";
		$q = $conn->prepare($checkQuery);
		$q->execute([':tkn' => $tok]); 
		$user = $q->fetch(PDO::FETCH_ASSOC);
		if($q->rowCount() >0){
			$result = $user['user_id'];
		}
		return $result;
	}
  
  //basic get/save/update/delete recipe functions	
  public function getRecipe($recipeID, $token) {
    $conn = $this->getConnection();
    try {
		$userID = $this->getUserID($conn, $token);
		$this->log->notice('Get recipe', ['userID'=>$userID, 'recipeID'=>$recipeID]);
		$queryStmt = "select * from recipe where recipe_id = :recipe AND user_id = :user";
		$q = $conn->prepare($queryStmt);
		$q->bindParam(":recipe", $recipeID);
		$q->bindParam(":user", $userID);
		$q->execute();
	return $q->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
      $this->log->error('Could not fetch recipe', ['userToken'=>$token, 'recipeID'=>$recipeID, 'error'=>print_r($e,1)]);
      exit;
    }
  }

  public function saveRecipe($title, $category, $prep, $cook, $author, $source, $link, $ingred, $directions, $token) {
    $conn = $this->getConnection();
	if(is_null($conn)) {
      return;
    }
	$userID = $this->getUserID($conn, $token);
	$this->log->notice('Save recipe', ['userID'=>$userID, 'title'=>$title]);
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
	$this->log->notice('Update recipe', ['recipeID'=>$recipeID]);
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

  public function deleteRecipe($recipeID, $token) {
    $conn = $this->getConnection();
	$userID = $this->getUserID($conn, $token);
	$this->log->notice('Delete recipe', ['userID'=>$userID, 'recipeID'=>$recipeID]);
    $deleteQuery = "delete from recipe where recipe_id = :id AND user_id = :user";
    $q = $conn->prepare($deleteQuery);
    $q->bindParam(":id", $recipeID);
	$q->bindParam(":user", $userID);
    $q->execute();
  }
 
  //functions for sorted/filtered recipes
  public function getAllRecipes($token){
	$conn = $this->getConnection();
    try {
		$this->log->debug('user token is', ['token'=>$token]);
		$userID = $this->getUserID($conn, $token);
		$this->log->notice('Get all recipes', ['userID'=>$userID]);
		$queryStmt ="select recipe_id, title, category, prep_time, cook_time, author, source, link  from recipe where user_id = :user order by title asc";
		$q = $conn->prepare($queryStmt);
		$q->bindParam(":user", $userID);
		$q->execute();
	return $q->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
      $this->log->error('Could not fetch recipes', ['userToken'=>$token, 'error'=>print_r($e,1)]);
      exit;
    }  
  } //default for recipe table. order by title

  public function getRecipesWhere($token, $title, $ingredient, $category){
	$conn = $this->getConnection();
	try {
		$userID = $this->getUserID($conn, $token);
		$this->log->notice('Get select recipes', ['userID'=>$userID]);
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
      $this->log->error('Filter recipes error', ['userToken'=>$token, 'error'=>print_r($e,1)]);
      exit;
    }  
  } //add in filters to search here. if none, report none. decide on filter order...
  
  public function addContact($contactName, $contactEmail, $subject, $contactText){
	$conn = $this->getConnection();
	if(is_null($conn)) {
      return 0;
    }
    $this->log->notice('New message added', ['sender'=>$contactEmail]);
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