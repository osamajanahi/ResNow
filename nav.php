<header>
    <nav>


        <div class="bg-accent" role="navigation">
            <div class="container-fluid">
                <!------------- First row of the upper navbar -------------->
                <div class="row align-items-center">

                    <!----------- First col of the upper navbar ------------>
                    <!-- Original : col-lg-3 for first and col-lg-5 for second col -->
                    <div class="col-lg-2 col-md-4 col-xs-12  pr-0">
                        <div class="row align-items-center justify-content-evenly mx-0 my-2 logo-div">
                            <div class="col-8 ">
                                <div class="py-3 logo-div">
                                    <a class="navbar-brand logo-font" href="index.php">
                                        <img src="Images/logo.png" alt="" style="height: 48px" />
                                        ResNOW</a>
                                </div>
                            </div>
                            <div class="col-4 d-md-none  d-flex justify-content-end pr-0 ">
                            <?php
                            if(isset($_SESSION['activeUser'])){
                                $sql="SELECT fname,lname,picture FROM user WHERE id=?";
                                $stmt=$db->prepare($sql);
                                $stmt->execute(array($_SESSION['activeUser']));
                                if($info=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                                <div class="py-3 px-5"> <a class=" d-flex flex-column align-items-center login-link " style="text-decoration: none;" href="editacc.php"><?php if($info['picture']!=null) { ?> <img src="pfp\<?php echo $info['picture']?>" class="login-image" alt="Profile image"><?php } else { ?><i class="fa-solid fa-circle-user login-icon"></i><?php } echo "<p class='username'>".$info['fname']." ".$info['lname']."</p>"; ?></a></div>
                            <?php }} else { ?>
                            <div class="py-3 px-5"> <a class=" d-flex flex-column align-items-center login-link " style="text-decoration: none;" href="login.php"><i class="fa-solid fa-circle-user login-icon username"></i><p class="username">Log in</p></a></div>
                            <?php } ?>
                        </div>
                        </div>
                    </div>




                    <!----------- Second col of the upper navbar ------------>
                    <div class="col-lg-6 col-md-4 col-xs-12  search-bar-col ">

                        <form class="input-group " role="search" action='search.php' method="POST">
                            <input name='search' class="form-control search-bar" type="search" placeholder="Type Somthing to Search ..." aria-label="Search" aria-describedby="basic-addon1" />
                            <button class="input-group-text search-bar-button " type="submit" name='sbsearch'>
                                <i class="fas fa-search text-primary  search-bar-icon"></i>
                            </button>
                        </form>
                    </div>
                    <!----------- Third col of the upper navbar ------------>
                    <div class="col-lg-4 col-md-4  col-xs-12 right-nav-items ">
                        <div class="row text-white ">
                            <div class="col-3 col-md-4 col-lg-3">
                                <div class="py-3 Rogin-info">
                                    <a class="d-flex flex-column  align-items-center text-center nav-link" href="showfav.php" style="text-decoration: none; margin-left: 20px;"><i class="fa-regular fa-heart login-icon"></i>Fields</a>

                                </div>
                            </div>
                            <div class="col-3 col-md-4 col-lg-3">
                                <div class="py-3 Rogin-info">
                                    <a class="d-flex flex-column align-items-center text-center nav-link  " href="reservations.php" style="text-decoration: none ; margin-right: auto; "> <i class="fa-solid fa-receipt login-icon"></i>Reservations</a>
                                    <!-- <i class="fa-solid fa-circle-user nav-upper-icons"></i> -->
                                </div>

                            </div>
                            <div class="col-6 col-md-4 col-lg-6">
                                <div class="py-3 Rogin-info ml-3">
                                <?php
                            if(isset($_SESSION['activeUser'])){

                                $stmt->execute(array($_SESSION['activeUser']));
                                if($info=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                                <div class="py-3 px-5"> <a class=" d-flex flex-column align-items-center login-link " style="text-decoration: none;" href="editacc.php"><?php if($info['picture']!=null) { ?> <img src="pfp\<?php echo $info['picture']?>" class="login-image" alt="Profile image"><?php } else { ?><i class="fa-solid fa-circle-user login-icon"></i><?php } echo "<p class='username'>".$info['fname']." ".$info['lname']."</p>"; ?></a></div>
                            <?php }} else { ?>
                            <div class="py-3 px-5"> <a class=" d-flex flex-column align-items-center login-link " style="text-decoration: none;" href="login.php"><i class="fa-solid fa-circle-user login-icon username"></i><p class='username'>Log in</p></a></div>
                            <?php } ?>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------- End of the Upper navbar ---------------->
            </div>

            <!----------------- Strat of Second Navbar  ---------------------->



            <div id="secondNav" class="navbar d-flex justify-content-center  navbar-light second-nav ">
                <div class="row">
                    <div class="container-fluid">
                        <div class="row text-center">

                            <div class="col">
                                <!---------------- collapsed menu header ----------->
                                <div class="d-inline-block d-md-none " data-bs-toggle="collapse" data-bs-target="#sideDrawer">
                                    <a class="nav-link mx-4 text-uppercase " href="#"><i class="fa-solid fa-bars nav-menu-icon"></i>Menu</a>
                                </div>
                                <!--------------- End of collapsed menu header ----------->

                                <!-- Original : the mx value is mx-2 -->
                                <div class="d-none d-md-block d-lg-block d-xl-block ">
                                    <div class="d-inline-block section-line ">
                                        <a class="nav-link mx-4 text-uppercase  " href="index.php"><i class="fa-solid fa-house nav-bottom-icons "></i> Home</a>
                                    </div>
                                    <div class="d-inline-block section-line">
                                        <a class="nav-link mx-4 text-uppercase  " href="fullcategory.php#fields"><i class="fa-solid fa-tags nav-bottom-icons"></i> Find all
                                        </a>
                                    </div>
                                    <div class="d-inline-block section-line">
                                        <a class="nav-link mx-4 text-uppercase " href="aboutus.php"><i class="fa-solid fa-users nav-bottom-icons"></i> About Us
                                        </a>
                                    </div>
                                    <div class="d-inline-block section-line">
                                        <a class="nav-link mx-4 text-uppercase " href="contactus.php"><i class="fa-solid fa-envelope-open-text nav-bottom-icons"></i>Contact
                                            Us</a>
                                    </div>
                                    <?php if(isset($_SESSION['activeUser'])){?>
                                    <div class="d-inline-block nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-uppercase mx-4" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-user nav-bottom-icons"></i> Account
                                        </a>
                                        
                                        <ul class="dropdown-menu  " style="background-color: #e3f2fd;">
                                            <li class="mb-3" style="margin-top:7px; ">
                                                <a class="dropdown-item " href="editacc.php"><i class="fa-solid fa-user-pen "></i> Edit Account</a>
                                            </li>
                                            <li class="mb-3">
                                                <a class="dropdown-item" href="reservations.php"><i class="fa-solid fa-calendar-check"></i> My
                                                    Reservations</a>
                                            </li>
                                            <?php if($_SESSION['userType']=='admin'){?>
                                            <li class="mb-3">
                                                <a class="dropdown-item" href="control.php"><i class="fa-solid fa-gear"></i> Admin Control</a>
                                            </li>
                                            <?php }?>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="signout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!------------------------ End of second navbar ---------------->
            </div>


            <!-- ------------Hidden Menu Dropdown  --------------->


            <div class=" hidden-nav-menu d-md-none collapse text-center  " id="sideDrawer">
                <ul class="navbar-nav me-auto py-3 text-uppercase">


                    <li class="nav-item ">
                        <a class="nav-link " aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="fullcategory.php#fields">Find now</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactus.php">Contact Us</a>
                    </li>
                    <?php if(isset($_SESSION['activeUser'])){?>
                    <li class="nav-item dropdown   ">
                        <a class="nav-link dropdown-toggle d-inline-block  " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="editacc.php"><i class="fa-solid fa-user-pen "></i> Edit Account</a></li>
                            <li><a class="dropdown-item" href="Reservations.php"><i class="fa-solid fa-calendar-check"></i> My Reservations</a></li>
                            <?php if($_SESSION['userType']=='admin'){?><li><a class="dropdown-item" href="control.php"><i class="fa-solid fa-gear"></i> Admin Control</a></li><?php }?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="signout.php">Sign Out</a></li>
                        </ul>
                    </li>
                    <?php }?>

                </ul>

            </div>

    </nav>
</header>
