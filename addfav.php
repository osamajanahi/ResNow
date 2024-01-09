<?php
try{
require ("connection.php");
if(isset($_GET['fid'])&&isset($_GET['uid'])){
    $sql="INSERT INTO favourite VALUES(?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($_GET['uid'],$_GET['fid']));
}else{
    header("location: index.php");
}
}
catch(PDOException $e)
{
    die($e->getMessage());
}
?>