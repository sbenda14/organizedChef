<?php
  session_start();
  session_destroy();
  header("Location: http://localhost/organizedchef/index.php");
  exit;