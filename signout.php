<?php
session_start();
if(isset($_SESSION['activeUser'])){
  unset($_SESSION['activeUser']);
  unset($_SESSION["userType"]);
  header('Location: login.php');
} else
  header('Location: index.php');
?>
