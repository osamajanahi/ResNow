<?php
try {
  require('connection.php');
  $sql = "select * from user where email = '".$_GET['q']."'";
  $rs = $db->query($sql);
  if ($r=$rs->fetch())
      echo "taken";
  else
      echo "free";
  $db=null;
}
catch(PDOException $ex){
  die($ex->getMessage());
}
?>
