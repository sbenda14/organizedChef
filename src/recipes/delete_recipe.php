<?php
session_start();
  
  require_once '../../server/Dao.php';
  $dao = new Dao();
  $dao->deleteRecipe($_GET['recipeid'], $_SESSION['user']);
  header("Location:  https://theorganizedchef.herokuapp.com/recipes.php");
  exit;