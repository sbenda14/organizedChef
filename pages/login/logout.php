<?php
  session_start();
  session_destroy();
  header("Location: https://theorganizedchef.herokuapp.com/src/home/index.php");
  exit;