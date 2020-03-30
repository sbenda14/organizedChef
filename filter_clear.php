<?php
  session_start();
  require_once 'Dao.php';
  $dao = new Dao();

  $_SESSION['filter'] = FALSE;
  header("Location: https://theorganizedchef.herokuapp.com/recipes.php");//send to recipe page
  exit;