<?php
  session_start();

  $_SESSION['filter'] = FALSE;
  header("Location: https://theorganizedchef.herokuapp.com/src/recipes/recipes.php");//send to recipe page
  exit;