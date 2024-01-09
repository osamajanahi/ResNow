<?php
date_default_timezone_set("Asia/Bahrain");
session_start();
if (!isset($_SESSION['activeUser']))
    header('location:login.php');
try {
    require("connection.php");
} catch (PDOException $e) {
    die($e->getMessage());
} ?>
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
    <main>
        <h1 class="cardcat ml-5">Upcoming</h1>
        <div class="container-fluid cardback">
            <div class="row justify-content-center mr-lg-5 ml-lg-5">
                <?php
                $upempty = true; // field to check later if it is empty
                // get all upcoming reservations
                $sql = ("SELECT id,fieldid,date,starttime,endtime,price FROM reservation WHERE userid = ? AND (date > CURDATE() or (date = CURDATE() AND endtime> TIME(NOW()))) ORDER BY date ASC");
                $stmt1 = $db->prepare($sql);
                $stmt1->execute(array($_SESSION['activeUser']));
                while ($upcoming = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $upempty = false;
                    $sql = ("SELECT * FROM fields WHERE id = ?");
                    $stmt = $db->prepare($sql);
                    $stmt->execute(array(
                        $upcoming['fieldid']
                    ));
                    if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <div class="card mycard border-10 cardcont" align="center">
                            <div class="rating">
                                <?php
                                if ($card['rating'] == NULL) echo "<p class='stars'>UNRATED<p>";
                                else for ($i = 0; $i < round($card['rating']); $i++) {
                                    echo "<i class=\"fa-solid fa-star stars\"></i>";
                                }
                                ?>
                            </div>

                            <div class="card-img-top mycardcont">
                                <img src="fieldspic\<?php echo $card['mainpic']; ?>" class="card-img-top mycardimg" alt="" />
                            </div>
                            <div class="card-body mycardbody">
                                <h5 class="card-title mycardtext mycardtitle"><?php echo $card['name']; ?></h5>

                                <hr />
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                    <?php echo $card['location']; ?>
                                </p>
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                    Price: <b style="font-weight: 550"><?php echo $upcoming['price']; ?> BD</b>
                                </p>
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-calendar-days card-indfo-icons" style="font-size: 1.3rem"></i>
                                    Date: <b style="font-weight: 550"><?php echo $upcoming['date']; ?></b>
                                </p>
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-clock" style="font-size: 1.3rem"></i>
                                    Time: <b style="font-weight: 550"><?php echo $upcoming['starttime'] . "-" . $upcoming['endtime']; ?></b>
                                </p>
                                <form action="receipt.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $upcoming['id']; ?>">
                                    <button type="submit" name="print" class="btn mycardbutton">
                                        Print recipt
                                    </button>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                }
                if ($upempty) {
                    echo '<p class="cardcat">No Upcoming Reservations, <a href="fullcategory.php#fields">Order Now</a></p>';
                }
                ?>
            </div>
        </div>

        <h1 class="cardcat ml-5">History</h1>
        <div class="container-fluid cardback">
            <div class="row justify-content-center mr-lg-5 ml-lg-5">
                <?php
                $hisempty = true; // field to check later if it is empty
                // get all previous reservations
                $sql = ("SELECT id,fieldid,date,starttime,endtime,price FROM reservation WHERE userid = ? AND (date < CURDATE() or (date = CURDATE() AND endtime< TIME(NOW()))) ORDER BY date DESC");
                $stmt1 = $db->prepare($sql);
                $stmt1->execute(array($_SESSION['activeUser']));
                while ($history = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    echo $_SESSION['activeUser'];
                    // print_r($history);
                    $hisempty = false;
                    $sql = ("SELECT * FROM fields WHERE id = ?");
                    $stmt = $db->prepare($sql);
                    $stmt->execute(array(
                        $history['fieldid']
                    ));
                    if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // print_r($card);
                ?>
                        <div class="card mycard border-10 cardcont" align="center">
                            <div class="rating">
                                <?php
                                if ($card['rating'] == NULL) echo "<p class='stars'>UNRATED<p>";
                                else for ($i = 0; $i < round($card['rating']); $i++) {
                                    echo "<i class=\"fa-solid fa-star stars\"></i>";
                                }
                                ?>
                            </div>

                            <div class="card-img-top mycardcont">
                                <img src="fieldspic\<?php echo $card['mainpic']; ?>" class="card-img-top mycardimg" alt="" />
                            </div>
                            <div class="card-body mycardbody">
                                <h5 class="card-title mycardtext mycardtitle"><?php echo $card['name']; ?></h5>

                                <hr />
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                    <?php echo $card['location']; ?>
                                </p>
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                    Price: <b style="font-weight: 550"><?php echo $history['price']; ?> BD</b>
                                </p>
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-calendar-days card-indfo-icons" style="font-size: 1.3rem"></i>
                                    Date: <b style="font-weight: 550"><?php echo $history['date']; ?></b>
                                </p>
                                <p class="card-text mycardtext">
                                    <i class="fa-solid fa-clock" style="font-size: 1.3rem"></i>
                                    Time: <b style="font-weight: 550"><?php echo $history['starttime'] . "-" . $history['endtime']; ?></b>
                                </p>
                                <form action="rate.php" method="POST">
                                    <input type="hidden" name="resid" value="<?php echo $history['id']; ?>">
                                    <button type="submit" class="btn mycardbutton rate-me-button">
                                        Rate me
                                    </button>
                                </form>
                                <form action="receipt.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $history['id']; ?>">
                                    <button type="submit" name="print" class="btn mycardbutton">
                                        <i class="fa-solid fa-print receipt-print-icon"></i> Print recipt
                                    </button>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                }
                if ($hisempty) {
                    echo '<p class="cardcat">No History <a href="fullcategory.php#fields">Make new memories with us now</a></p>';
                }
                ?>
            </div>
        </div>
    </main>

    <!-- End of Body -->

    <!-- Begining of Footer -->
    <?php
    include("footer.php");
    if (isset($_GET['error'])) {
        $msg = $_GET['error'];
        echo "<script>alert('$msg')</script>";
    }
    ?>
    <!-- End of Footer -->
</body>

</html>