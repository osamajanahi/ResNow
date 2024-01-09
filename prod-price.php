<?php
session_start();
$inputDuration = $_GET['hour'];
$price = $_SESSION['price'];
if($inputDuration == 1)
    $totalAmount = $price;
elseif($inputDuration == 2)
    $totalAmount = $price * 2;
$_SESSION['totalPrice'] = $totalAmount;
echo "<h3>$totalAmount BD</h3>";
?>