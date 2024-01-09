<?php
if(!isset($_REQUEST['card'])){
    header('location:fullcategory.php');
}
date_default_timezone_set("Asia/Bahrain");
session_start();
$_SESSION['fieldNum'] = $_REQUEST['card'];
$cardid = $_SESSION['fieldNum'];
try{
require('connection.php');
$sql1 = "select * from fields where id = $cardid";
$stmt1=$db->query($sql1);

if ($details = $stmt1->fetch(PDO::FETCH_ASSOC)){
$name = $details['name'];
$loclink = $details['loclink'];
$price = $details['price'];
$rating = $details['rating'];
$facilities = $details['facilities'];
$courtnum = $details['courtnum'];
$starttime = $details['starttime'];
$endtime = $details['endtime'];
$mainpic = $details['mainpic'];
$_SESSION['start'] = $starttime;
$_SESSION['end'] = $endtime;
$_SESSION['price'] = $price;
}
}
catch(PDOException $e)
{
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


<body onload="loadFunction()">

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
        <div class="container prod-container mt-5">
            <div class="prod-booking">
                <div class="prod-left">
                    <div class="prod-top">
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                                    <?php
                                    try{
                                    require('connection.php');
                                    $sql2 = "select pic from fieldpic where fid = ?";
                                    $stmt2 = $db->prepare($sql2);
                                    $stmt2->execute(array($cardid));
                                   
                                    }
                                    catch(PDOException $e)
                                    {
                                        die($e->getMessage());
                                    }
                                    echo "<div class='carousel-item active prod-picm'>";
                                    echo "<img src='fieldspic/".$mainpic."' class='d-block w-100 prod-pic' alt='...'>
                                    </div>";
                                    foreach($stmt2 as $row){
                                        echo "<div class='carousel-item prod-picm'>";
                                        echo "<img src='fieldspic/".$row['pic']."' class='d-block w-100 prod-pic' alt='...'>
                                        </div>";
                                    }
                                    

                                    ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-target="#carouselExampleFade" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-target="#carouselExampleFade" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="prod-bottom">
                        <div class="prod-map">
                            <iframe class="prod-maps" src="<?php echo $loclink?>" frameborder="0" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
                <div class="prod-right">
                    <div class="row prod-info justify-content-center">
                        <div class="col-12">
                            <h3><?php echo $name;?></h3>
                        </div>
                        <div class="rating prod-rating">
                            <?php
                    if ($rating == NULL)echo "<p class='stars'>UNRATED<p>"; else for ($i = 0;$i < round($rating);$i++)
                    {
                        echo "<i class=\"fa-solid fa-star stars\"></i>";
                    }
?>
                        </div>
                    </div>
                    <hr class="prod-hr">
                    <div class="prod-reservation">
                        <p class="prod-names">Facilities: </p>
                        <div class="prod-facilities">
                        <?php
                            $fac = explode('#',$facilities);
                            foreach($fac as $value){
                                if($value=="B"){
                                    echo " <div class='prod-facilities-cards'><i class='fa-solid fa-futbol'></i><br>
                                        <p>Ball</p>
                                    </div>";
                                }
                                if($value=="S"){
                                    echo "  <div class='prod-facilities-cards'><i class='fa-solid fa-shower'></i><br>
                                    <p>Shower</p>
                                </div>";
                                }
                                if($value=="W"){
                                    echo " <div class='prod-facilities-cards'><i class='fa-solid fa-bottle-water'></i><br>
                                    <p>Water</p>
                                </div>";
                                }
                                if($value=="T"){
                                    echo "<div class='prod-facilities-cards'><i class='fa-solid fa-restroom'></i><br>
                                    <p>Toilet</p>
                                </div>";
                                }
                            }
                        ?>
                        </div><br>
                        <form action="reserved.php" method="post" class="prod-reserve">
                        <label class="prod-names">Date: </label><br>
                            
                                <?php 
                                //The user can only reserve for the next 7 days
                                for($i=0;$i<8;$i++){
                                    $date=mktime(0,0,0,date('m'),date('d')+$i,date('Y')+1);        
                                    // $date = mktime(0, 0, 0, date('m'), date('d') + $i, date('Y') + 1);                                                                
                                    ?> 
                                    
                                    <input type="radio" id="<?php echo date("d",$date);?>" name="dateRadio" onclick="fromDate(this.value)" value="<?php echo date("Y-h-d",$date);?>"<?php if($i == 0) echo "checked";?>>
                                    <label class="prod-select" for="<?php echo date("d",$date);?>"><?php echo date("D, d M",$date)?></label>
                                
                                <?php }?>
                            
                            <br>
                            <label class="prod-names">Duration: </label><br>
                            <input type="radio" id="1 Hour" onclick="fromDur(this.value)" name="duration" value="1" checked>
                            <label class="prod-select" for="1 Hour" >1 Hour</label>
                            <input type="radio" id="2 Hours" onclick="fromDur(this.value)" name="duration" value="2">
                            <label class="prod-select" for="2 Hours">2 Hours</label>
                    <br>
                            <label class="prod-names">Court: </label><br>
                            <?php 
                            //display the court numbers
                            for($i=1;$i<=$courtnum;$i++){?>
                            <input type="radio" id="court<?php echo $i?>" onclick="fromCourt(this.value)" name="courtNo" value="<?php echo $i?>" <?php if($i == 1) echo"checked"; ?>>
                            <label class="prod-select" for="court<?php echo $i?>">Court <?php echo $i?></label>
                            <?php }?>
                                <br>
                            <label class="prod-names">Time: </label><br>
                            <!-- To display the time -->
                            <div class="prod-marginbottom" id='timePlace'>
                            </div>

                            <br>
                    </div>
                    <div class="prod-payment">
                        <div class="prod-pay">
                            <p>Price: </p><br>
                            <?php
                            echo "<span id='priceId'>";
                            ?>
                            
                        </div>
                        <div class="prod-pay">
                            <input type="submit" name="booked" value="Book">
                        </form>
                        </div>

                    </div>
                    
                </div>
            </div>
            <div class="prod-reviews">
            <?php
                try{
                    require('connection.php');
                    $sql4 = "select fname, lname, comment, r.rating from user u, comments c, fields f, reservation r where u.id = c.userid and f.id = c.fieldid and r.id = c.reservationid  and c.fieldid = ?";
                    $stmt4 = $db->prepare($sql4);
                    $stmt4->execute(array($cardid));
                    $sql5 = "select count(c.fieldid) from user u, comments c, fields f, reservation r where u.id = c.userid and f.id = c.fieldid and r.id = c.reservationid  and c.fieldid = ?";
                    $stmt5 = $db->prepare($sql5);
                    $stmt5->execute(array($cardid));
                    if($row = $stmt5->fetch())
                    $countRows = $row[0];
                    
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }
                $lastItem = 0;
                foreach($stmt4 as $row){
                    $lastItem++;
            ?>
                <div class="row">
                    <div class="col-lg-12">

                    <?php 
                    if($countRows != $lastItem)
                    echo "<div class='prod-box'>";
                    else
                    echo "<div class='prod-box prod-box-noborder'>"
                    ?> 
                        <!-- <div class="prod-box"> -->
                            <div class="row">
                                <div class="col-lg-11"><b>
                                        <p class="prod-user-name"><?php echo $row['fname']." ".$row['lname']?></p>
                                    </b>
                                    <div class="rating">
                                        <?php
                                        for($i=0; $i<$row['rating'];$i++)
                                        echo " <i class='fa-solid fa-star stars'></i>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="prod-comment"><?php echo $row['comment']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }
                if($lastItem == 0)
                echo "<h4 style= 'text-align: center; margin-top: 30px;'>There are no comments</h4>";
                ?>
            </div>
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


                                <script>
                                    //To modify the time after clicking on any date
                                    function fromDate(val){
                                    const xhttp = new XMLHttpRequest();
                                    xhttp.onload = timeFunction;
                                    c = document.querySelector('input[name="courtNo"]:checked').value;
                                    h = document.querySelector('input[name="duration"]:checked').value;
                                    xhttp.open("GET", "prod-time.php?c="+c+"&d="+val+"&h="+h);
                                    xhttp.send();
                                    }
                                    //To modify the time after clicking on any duration and modify the price
                                    function fromDur(val){
                                    const xhttp = new XMLHttpRequest();
                                    const http = new XMLHttpRequest();
                                    xhttp.onload = timeFunction;
                                    d = document.querySelector('input[name="dateRadio"]:checked').value;
                                    c = document.querySelector('input[name="courtNo"]:checked').value
                                    xhttp.open("GET", "prod-time.php?c="+c+"&d="+d+"&h="+val);
                                    xhttp.send();
                                    http.onload = priceFunction;
                                    http.open("GET", "prod-price.php?hour="+val);
                                    http.send();
                                    }
                                    //To modify the time after clicking on any court
                                    function fromCourt(val){
                                    const xhttp = new XMLHttpRequest();
                                    xhttp.onload = timeFunction;
                                    d = document.querySelector('input[name="dateRadio"]:checked').value;
                                    h = document.querySelector('input[name="duration"]:checked').value;
                                    xhttp.open("GET", "prod-time.php?c="+val+"&d="+d+"&h="+h);
                                    xhttp.send();
                                    }
                                    //To display the time and price at the loading time of the page
                                    function loadFunction(){
                                    const xhttp = new XMLHttpRequest();
                                    const http = new XMLHttpRequest();
                                    xhttp.onload = timeFunction;
                                    d = document.querySelector('input[name="dateRadio"]:checked').value;
                                    h = document.querySelector('input[name="duration"]:checked').value;
                                    c = document.querySelector('input[name="courtNo"]:checked').value;
                                    xhttp.open("GET", "prod-time.php?c="+c+"&d="+d+"&h="+h);
                                    xhttp.send();
                                    http.onload = priceFunction;
                                    http.open("GET", "prod-price.php?hour="+h);
                                    http.send();
                                    }
                                    //The place where the price will be displayed
                                    function priceFunction(){
                                    document.getElementById("priceId").innerHTML =
                                    this.responseText;
                                    }
                                    //The place where the time will be displayed
                                    function timeFunction(){
                                    document.getElementById("timePlace").innerHTML =
                                    this.responseText;
                                    }

                                    
                                </script>