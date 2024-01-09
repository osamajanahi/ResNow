<?php
session_start(); 
if(!isset($_SESSION['activeUser']))
header('location:login.php');
if(isset($_POST['booked']))
{
    extract($_POST);
    $date = $dateRadio;
    $inputDuration = $duration;
    $court = $courtNo."<br>";
    $startBook = $time;
    $explodeTime = explode(':',$startBook);
    $firstPart= $explodeTime[0]+$inputDuration;
    $totalAmount = $_SESSION['totalPrice'];
    $endBook = $firstPart.":".$explodeTime[1];
    $useridfromsession = $_SESSION['activeUser'];
    $fieldId = $_SESSION['fieldNum'];
    $useridfromsession = $_SESSION['activeUser'];
    $totalAmount = $_SESSION['totalPrice'];
    try{
    require('connection.php');
    $sqlExec = "insert INTO reservation values(null,:useridfromsession,:field,:court,:inputDuration,:dateres,:startbook,:endbook,:price,null)";
    $stmtExec = $db->prepare($sqlExec);
    $stmtExec ->bindParam(':useridfromsession',$useridfromsession);
    $stmtExec ->bindParam(':field',$fieldId);
    $stmtExec ->bindParam(':court',$court);
    $stmtExec ->bindParam(':inputDuration',$inputDuration);
    $stmtExec ->bindParam(':dateres',$date);
    $stmtExec ->bindParam(':startbook',$startBook);
    $stmtExec ->bindParam(':endbook',$endBook);
    $stmtExec ->bindParam(':price',$totalAmount); // add :price to the above sql
    $stmtExec->execute();
}
catch(PDOException $e)
{
    die($e->getMessage());
}
header('location:reservations.php');
}
?>