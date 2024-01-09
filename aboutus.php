<?php 
session_start();
try
{
    require ("connection.php");
}
catch(PDOException $e)
{
    die($e->getMessage());
}?>
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

        <section class="page-top-header">

            <img class="section-image-first" src="Images/all.png" alt="">
            <div class="page-top-header-firstT">About US</div>
        </section>
        <div class="container form-box">
            <p class="mynamestext abouttext mb-5"> We are a group of IT students at the Universty of Bahrain taking the course ITCS333</p>

            <p class="mynamestext">
                Student #1: Osama Khatam , ID: 20194179<br />
                Student #2: Sayed Younis A.khaliq , ID: 20194114<br />
                Student #3: Osama Abdulrahim Janahi, ID: 20194364<br />
                Student #4: Natheer Hasan Ali, ID: 20194848<br />
                Student #5: Ali A.Redha Ali, ID: 20194438<br />
                Student #6: Mohammed Abdulhameed ID: 20180867<br />
                Student #7: Ahmed Tariq Mahmood, ID: 20192732<br />
            </p>

        </div>
    </main>


    <!-- End of Body -->

    <!-- Begining of Footer -->
    <?php
    include("footer.php");
    ?>
    <!-- End of Footer -->
</body>

</html>