<?php
session_start();
try {
    require "connection.php";
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


<body onload="typeWriter() ;typeWriter2()">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- end of links -->
    <!-- Begining of header -->


    <?php require "nav.php"; ?>


    <!-- End of header -->

    <!-- Begining of body -->
    <main>

        <section class="page-top-header">

            <img class="section-image-first" src="Images/all.png" alt="">
            <div class="page-top-header-firstT" id="main-page-text"></div>

            <div class="page-top-header-secondT" id="secondry-page-text"></div>



        </section>

        <div class="category-title-container">
            <?php
            $sql = "SELECT * FROM fields WHERE category =?";
            $stmt = $db->prepare($sql);
            $stmt->execute(["Football"]);
            ?>
            <form method="GET" action="fullcategory.php#fields" class="category-title-container">
                <label for="Football"><i class="fa-regular fa-futbol mr-3 category-title-icon"></i></label>
                <input type="hidden" name='cat' value="Football">
                <input type="submit" class="category-title" value="Football Fields" name="football" />
            </form>

        </div>

        <div id="carouselExampleIndicators" class="carousel slide cardback" data-ride="carousel">
            <!-- start of view more button -->
            <div class="view-more-div">
                <a class="view-more-link" href="fullcategory.php?cat=Football#fields">View more >></a>
            </div>
            <!-- End of view more button -->
            <ol class="carousel-indicators sliderdots">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>
        </div>
        <div class="category-title-container">
            <?php
            $sql = "SELECT * FROM fields WHERE category =?";
            $stmt = $db->prepare($sql);
            $stmt->execute(["Basketball"]);
            ?>
            <form method="GET" action="fullcategory.php#fields" class="category-title-container">
                <label for="Basketball"><i class="fa-regular fa-futbol mr-3 category-title-icon"></i></label>
                <input type="hidden" name='cat' value="Basketball">
                <input type="submit" class="category-title" value="Basketball Courts" name="Basketball" />
            </form>

        </div>
        <!-- <a href="fullcategory.php#fields" class="catlink badge">
            <h1 class="cardcat ml-5 mb-5 "><i class="fa-solid fa-basketball mr-3"></i> Basketball Court</h1>
        </a> -->
        <div id="secondcarouselExampleIndicators" class="carousel slide cardback" data-ride="carousel">
            <!-- start of view more button -->
            <div class="view-more-div">
                <a class="view-more-link" href="fullcategory.php?cat=Basketball#fields">View more >></a>
            </div>
            <!-- End of view more button -->
            <ol class="carousel-indicators">
                <li data-target="#secondcarouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#secondcarouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#secondcarouselExampleIndicators" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#secondcarouselExampleIndicators" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>
        <div class="category-title-container">
            <?php
            $sql = "SELECT * FROM fields WHERE category =?";
            $stmt = $db->prepare($sql);
            $stmt->execute(["Padel"]);
            ?>
            <form method="GET" action="fullcategory.php#fields" class="category-title-container">
                <label for="Padel"><i class="fa-regular fa-futbol mr-3 category-title-icon"></i></label>
                <input type="hidden" name='cat' value="Padel">
                <input type="submit" class="category-title" value="Padel Courts" name="Padel" />
            </form>

        </div>
        <!-- <a href="fullcategory.php#fields" class="catlink badge">
            <h1 class="cardcat ml-5 mb-5 "><i class="fa-solid fa-table-tennis-paddle-ball mr-3"></i> Padel Court</h1>
        </a> -->
        <div id="thirdcarouselExampleIndicators" class="carousel slide cardback" data-ride="carousel">
            <!-- start of view more button -->
            <div class="view-more-div">
                <a class="view-more-link" href="fullcategory.php?cat=Padel#fields">View more >></a>
            </div>
            <!-- End of view more button -->
            <ol class="carousel-indicators">
                <li data-target="#thirdcarouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#thirdcarouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#thirdcarouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="cardcontainer">
                        <div class="card mycard border-10">
                            <?php if (
                                $card = $stmt->fetch(PDO::FETCH_ASSOC)
                            ) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-md-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-lg-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card mycard border-10 d-none d-xl-block">
                            <?php if ($card = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <div class="rating">
                                    <?php if ($card["rating"] == null) {
                                        echo "<p class='stars'>UNRATED<p>";
                                    } else {
                                        for ($i = 0; $i < round($card["rating"]); $i++) {
                                            echo "<i class=\"fa-solid fa-star stars\"></i>";
                                        };
                                    } ?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card["mainpic"]; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if (isset($_SESSION["activeUser"])) {
                                        $sql =
                                            "SELECT * from favourite where userid=? and fieldid =?";
                                        $favsql = $db->prepare($sql);
                                        $favsql->execute([
                                            $_SESSION["activeUser"],
                                            $card["id"],
                                        ]);
                                        if ($exist = $favsql->fetch()) { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                                    "," .
                                                                                                    $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button id='favcontainer<?php echo $card["id"]; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION["activeUser"] .
                                                                                        "," .
                                                                                        $card["id"]; ?>)">
                                                <i id='favicon<?php echo $card["id"]; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                            </button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="card-body mycardbody">
                                    <h5 class="card-title mycardtext mycardtitle">
                                        <?php echo $card["name"]; ?>
                                    </h5>

                                    <hr />
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-location-dot card-indfo-icons"></i> Location:
                                        <?php echo $card["location"]; ?>
                                    </p>
                                    <p class="card-text mycardtext">
                                        <i class="fa-solid fa-dollar-sign card-indfo-icons" style="font-size: 1.3rem"></i>
                                        Starting from: <b style="font-weight: 550"><?php echo $card["price"]; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                        <input type="hidden" name="card" value="<?php echo $card["id"]; ?>">
                                        <button type="submit" name="subCard" class="btn mycardbutton">
                                            Reserve Now
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#thirdcarouselExampleIndicators" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#thirdcarouselExampleIndicators" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>
    </main>

    <!-- End of Body -->

    <!-- Begining of Footer -->
    <?php include "footer.php"; ?>
    <!-- End of Footer -->
</body>
<script>
    function addfavorite(uid, fid) {
        const xhttp = new XMLHttpRequest();
        if (document.getElementById("favicon" + fid).className == "fa-solid fa-heart-circle-plus") {
            xhttp.onload = function() {
                document.getElementById("favicon" + fid).className = "fa-solid fa-heart-circle-check makemered";
                document.getElementById("favcontainer" + fid).className = "fav-button backmered";
            }
            xhttp.open("GET", "addfav.php?fid=" + fid + "&uid=" + uid);
            xhttp.send();
        } else {
            xhttp.onload = function() {
                document.getElementById("favicon" + fid).className = "fa-solid fa-heart-circle-plus";
                document.getElementById("favcontainer" + fid).className = "fav-button";
            }
            xhttp.open("GET", "remfav.php?fid=" + fid + "&uid=" + uid);
            xhttp.send();
        }
    }

    var i = 0;
    var txt = 'EVERY DAY BRINGS NEW CHOICES';

    var j = 0;
    var txt1 = 'Explore Now';

    var speed = 40;

    function typeWriter() {
        // document.getElementById("main-page-text").innerHTML = "";
        if (i < txt.length) {
            document.getElementById("main-page-text").innerHTML += txt.charAt(i);
            i++;
            setTimeout(typeWriter, speed);
        }
    }

    function typeWriter2() {

        // document.getElementById("main-page-text").innerHTML = "";
        if (j < txt1.length) {
            document.getElementById("secondry-page-text").innerHTML += txt1.charAt(j);
            j++;
            setTimeout(typeWriter2, speed);
        }
    }
</script>

</html>