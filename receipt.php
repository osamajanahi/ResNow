<?php
session_start();
if(!isset($_POST['print']))
header('location:reservations.php');
try {
require("connection.php");
$sql = ("SELECT * FROM reservation WHERE id = ?");
$stmt1 = $db->prepare($sql);
$stmt1->execute(array($_POST['id']));
$sql = ("SELECT name,location FROM fields WHERE id = ?");
$fieldstmt = $db->prepare($sql);
$sql = ("SELECT fname,lname,email FROM user WHERE id = ?");
$userstmt = $db->prepare($sql);
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />

    <!-- Our css -->
    <link rel="stylesheet" href="style.css" />
    <!-- Website fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">

    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/4ca1fa4868.js" crossorigin="anonymous"></script>

    <title>Res On</title>


</head>


<body>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- end of links -->
    <!-- Begining of header -->


    <?php
    require("nav.php");
    ?>

    <!-- End of header -->
    <!-- Begining of body -->
    <?php     
    if($resinfo=$stmt1->fetch(PDO::FETCH_ASSOC)){
         $fieldstmt->execute(array($resinfo['fieldid']));
         $userstmt->execute(array($resinfo['userid']));
        if($fieldinfo =  $fieldstmt->fetch(PDO::FETCH_ASSOC)){
            if($userinfo = $userstmt->fetch(PDO::FETCH_ASSOC))
     ?>

    <main class="receipt-main">
        <div class="receipt-container">
            <div class="receipt-box1">
                <p class="receipt-p1-box1">Customer Bill</p>
                <div class="receipt-div-box1">
                    <p class="receipt-p2-box1">Invoice Number</p>
                    <p class="invoice-num"># <span class="invoice-id"><?php echo $resinfo['id']; ?></span></p>
                </div>
            </div>
            <div class="receipt-box2">
                <i class="fa-solid fa-user receipt-info-icon"></i>
                <p class="receipt-p1-box2">Clients information</p>
            </div>
            <div class="receipt-box3">
                <small class='receiptsmall'>Full Name</small>
                <p class="receipt-p1-box3"><?php echo $userinfo['fname']." ".$userinfo['lname']; ?></p>

                <img src="Images/logo.png" class="receipt-logo" alt="logo" />

                 <small class='receiptsmall'>Email</small>
                <p class="receipt-p1-box3"><?php echo $userinfo['email']; ?></p>
            </div>
            <!-- Section 2  -->
            <div class="receipt-box4">
                <i class="fa-solid fa-user receipt-info-icon"></i>

                <p class="">Reservation information</p>
            </div>

            <div class="receipt-box6">
                 <small class='receiptsmall'>Field Name</small>
                <p class="receipt-p1-box3"><?php echo $fieldinfo['name']; ?></p>

                 <small class='receiptsmall'>Location</small>
                <p class="receipt-p1-box3"><?php echo $fieldinfo['location']; ?></p>

                <div class="receipt-time-date">
                    <div>
                         <small class='receiptsmall'>Date</small>
                        <p class="receipt-p1-box3"><?php echo $resinfo['date'];?></p>
                    </div>
                    <div>
                         <small class='receiptsmall'>Time</small>
                        <p class="receipt-p1-box3"><?php echo $resinfo['starttime']. " - ".$resinfo['endtime'] ; ?></p>
                    </div>
                </div>

                 <small class='receiptsmall'>Court</small>
                <p class="receipt-p1-box3"><?php echo $resinfo['court'];?></p>
            </div>

            <div class="receipt-box5">
                <p class="receipt-price-title">Total Price</p>
                <p class="receipt-price"><?php echo $resinfo['price'];?></p>
            </div>
        </div>
        <button class="receipt-button" id="receipt-button" onclick="window.print()">
            <i class="fa-solid fa-print receipt-print-icon"></i>Print
        </button>
    </main>
<?php   }} ?>
    <!-- End of Body -->

    <!-- Begining of Footer -->
    <?php
    include("footer.php");
    ?>
    <!-- End of Footer -->
</body>

</html>