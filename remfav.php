<?php
try{
require ("connection.php");
$sql="DELETE FROM favourite where userid = ? AND fieldid= ?";
$stmt = $db->prepare($sql);
$stmt->execute(array($_GET['uid'],$_GET['fid']));
}
catch(PDOException $e)
{
    die($e->getMessage());
}
?>