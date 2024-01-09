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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.0/css/all.css">
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
require ("nav.php");
?>


    <!-- End of header -->

    <!-- Begining of body -->

    <div class="full-category-options-container page-top-header-catPage page-top-header-category ">
        <form method="GET">
            <input type="hidden" name="cat" value="Football">
            <button type="submit" class="btn filter-button">
                <i class="fa-regular fa-futbol "></i>
            </button>
        </form>
        <form method="GET">
            <input type="hidden" name="cat" value="Basketball">
            <button type="submit" class="btn filter-button">
                <i class="fa-solid fa-basketball  "></i>
            </button>
        </form>
        <form method="GET">
            <input type="hidden" name="cat" value="Padel">
            <button type="submit" class="btn  filter-button">
                <i class="fa-solid fa-table-tennis-paddle-ball "></i>
            </button>
        </form>

    </div>


    <?php
$choosen = NULL;
$categorytitle = NULL;
if (isset($_GET["cat"]))
{
    if ($_GET["cat"] == 'Football')
    {
        $choosen = "Football";
        $categorytitle = "<i class=\"fa-regular fa-futbol mr-3\"></i>Football Field";
    }
    else if ($_GET["cat"] == 'Basketball')
    {
        $choosen = "Basketball";
        $categorytitle = "<i class=\"fa-solid fa-basketball mr-3\"></i>Basket Ball Court";
    }
    else if ($_GET["cat"] == 'Padel')
    {
        $choosen = "Padel";
        $categorytitle = "<i class=\"fa-solid fa-table-tennis-paddle-ball mr-3\"></i>Padel Court";
    }
}

?>
    <?php
if ($choosen != NULL)
{
    $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY NAME ASC");
    if (!isset($_GET['sortby'])) $_GET['sortby'] = 'Name';
    if (isset($_GET['sortby']))
    {
        switch ($_GET['sortby'])
        {
            case "name1":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY name ASC");
            break;
            case "name2":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY name DESC");
            break;
            case "price1":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY price ASC");
            break;
            case "price2":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY price DESC");
            break;
            case "loc1":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY location ASC");
            break;
            case "loc2":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY location DESC");
            break;
            case "rat1":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY rating ASC");
            break;
            case "rat2":
                $sql = ("SELECT * FROM fields WHERE category = ? ORDER BY rating DESC");
            break;
        }
    }
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        $choosen
    ));
?>
        <section id="fields" class="sectiondownpadding">
            <main>
                <div class="cat-title-row">
                    <div class="category-title1">
                        <h1 class="cardcat ml-5 mb-5 "><?php echo $categorytitle; ?></h1>
                    </div>

                    <form class="sort-div1" method="get">
                        <div class=" mycontactusform  sort-div">
                            <label for="sort" class="sort-label">Sort by</label>

                            <select class="sort-select" style=" font-family: sans-serif,'FontAwesome'; font-size:18px" name="sortby" id="sort">
                            <option value='name1' <?php if ($_GET['sortby'] == 'name1') echo " selected"; ?>>Name <span>&#xf062;</span></option>
                            <option value='name2' <?php if ($_GET['sortby'] == 'name2') echo " selected"; ?>>Name <span>&#xf063;</span></option>
                            <option value='rat1' <?php if ($_GET['sortby'] == 'rat1') echo " selected"; ?>>Rating <span>&#xf062;</span></option>
                            <option value='rat2' <?php if ($_GET['sortby'] == 'rat2') echo " selected"; ?>>Rating <span>&#xf063;</span></option>
                            <option value='price1' <?php if ($_GET['sortby'] == 'price1') echo " selected"; ?>>Price <span>&#xf062;</span></option>
                            <option value='price2' <?php if ($_GET['sortby'] == 'price2') echo " selected"; ?>>Price <span>&#xf063;</span></option>
                            <option value='loc1'<?php if ($_GET['sortby'] == 'loc1') echo " selected"; ?>>Location <span>&#xf062;</span></option>
                                <option value='loc2'<?php if ($_GET['sortby'] == 'loc2') echo " selected"; ?>>Location <span>&#xf063;</span></option>
                               
                                
                            </select>
                            <input type="hidden" name="cat" value="<?php if (isset($_GET['cat'])) echo $_GET['cat']; ?>">
                            <button type="submit" class="sort-button">Sort</button>
                        </div>
                    </form>
                </div>
                <div class="container-fluid ">
                    <div class="row justify-content-center cardgap mr-lg-5 ml-lg-5">

                        <?php
    while ($card = $stmt->fetch(PDO::FETCH_ASSOC))
    {
?>
                            <div class="card mycard border-10 cardcont" align="center">
                            <div class="rating">
                                    <?php
                    if ($card['rating'] == NULL)echo "<p class='stars'>UNRATED<p>"; else for ($i = 0;$i < round($card['rating']);$i++)
                    {
                        echo "<i class=\"fa-solid fa-star stars\"></i>";
                    }
?>
                                </div>
                                <div class="card-img-top mycardcont">
                                    <img src="fieldspic\<?php echo $card['mainpic']; ?>" class="card-img-top mycardimg" alt="" />
                                    <?php if(isset($_SESSION['activeUser'])){
                                    $sql = ("SELECT * from favourite where userid=? and fieldid =?");
                                    $favsql = $db->prepare($sql);
                                    $favsql->execute(array($_SESSION['activeUser'],$card['id']));
                                    if ($exist=$favsql->fetch()){
                                   ?>
                                     <button id='favcontainer<?php echo $card['id']; ?>' class="fav-button backmered" onclick="addfavorite(<?php echo $_SESSION['activeUser'].",".$card['id']; ?>)">
                                        <i id='favicon<?php echo $card['id']; ?>' class="fa-solid fa-heart-circle-check makemered"></i>
                                    </button>
                                <?php }else{?>
                                    <button id='favcontainer<?php echo $card['id']; ?>' class="fav-button" onclick="addfavorite(<?php echo $_SESSION['activeUser'].",".$card['id']; ?>)">
                                        <i id='favicon<?php echo $card['id']; ?>' class="fa-solid fa-heart-circle-plus"></i>
                                    </button>
                                <?php }
                                }
                                   ?>
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
                                        Starting from: <b style="font-weight: 550"><?php echo $card['price']; ?> BD</b>
                                    </p>
                                    <form action="reservepage.php" method="POST">
                                    <input type="hidden" name="card" value="<?php echo $card['id'];?>">
                                    <button type="submit" name="subCard" class="btn mycardbutton">
                                    Reserve Now
                                    </button>
                                    </form>
                                </div>
                            </div>
                        <?php
    }
?>
                    </div>
                </div>
            </main>
        </section>
    <?php
}
else
{
    echo " <div class=\"lonpaddingbottom\"></div>";
}
?>
    <!-- End of Body -->

    <!-- Begining of Footer -->
    <?php
include ("footer.php");
?>
    <!-- End of Footer -->

</body>
<script>
    function addfavorite(uid,fid){
    const xhttp = new XMLHttpRequest();
    if (document.getElementById("favicon"+fid).className =="fa-solid fa-heart-circle-plus"){
        xhttp.onload = function() {
        document.getElementById("favicon"+fid).className ="fa-solid fa-heart-circle-check makemered";
        document.getElementById("favcontainer"+fid).className ="fav-button backmered";
        }
        xhttp.open("GET", "addfav.php?fid="+fid+"&uid="+uid);
        xhttp.send();
        } else{
        xhttp.onload = function() {
        document.getElementById("favicon"+fid).className ="fa-solid fa-heart-circle-plus";
        document.getElementById("favcontainer"+fid).className ="fav-button";
        }
        xhttp.open("GET", "remfav.php?fid="+fid+"&uid="+uid);
        xhttp.send();
        }
    }
    </script>

</html>
