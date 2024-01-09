<?php
session_start();
$numval="/^[0-9]+$/";
if(!isset($_POST['resid'])||!preg_match($numval,$_POST['resid'])){
    header("location:reservations.php");
}
try{
    require("connection.php");
    $sql=("SELECT * FROM reservation WHERE id = ?");
    $stmt=$db->prepare($sql);
    $stmt->execute(array($_POST['resid']));
}catch(PDOException $e) {
    die($e->getMessage());
}

if($resdata = $stmt->fetch(PDO::FETCH_ASSOC)){
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

    <main>

        <div class="container form-box">
            <div class="login-box-header">
                <h4 class="text-center login-box-header-first-text maintextcolor">Rate Your expreince</h4>
            </div>
            <form method="POST" action="addrating.php">
                <input type="hidden" name='resid' value="<?php echo $_POST['resid'];?>">
                <div class="form-group mycontactusform">
                    <?php if($resdata['rating']==NULL){?>
                        <div class="form-group">
                        <label for="formControlRange">Stars</label>
                        <div class="d-flex">
                            <input type="range" name='rating' class="form-control-range w-50" id="formControlRange" min="1" max="5" value="0" oninput="this.nextElementSibling.value = this.value">
                            <output class="ml-2 outputrange">0</output>
                        </div>
                    </div>
                    <?php
                    }else{?>
                        <div class="form-group">
                        <label for="formControlRange"> Previous Stars</label>
                        <div class="d-none d-md-flex">
                            <input type="range" class="form-control-range w-50" id="formControlRange" min="1" max="5" value="<?php echo $resdata['rating']?>" disabled>
                            <output class="ml-2"><?php echo $resdata['rating']?></output>
                        </div>
                    </div>
                    <?php
                }
                ?>
                    <label for="comment" class="newline">Comment</label>
                    <textarea name="comment" class="form-control contactus-inputs" id="comment" cols="100" rows="5" placeholder="Type your Comment here"></textarea>
                    <input type="submit" value="Send" class="btn mycontactsubmit login-box-button">
                </div>
            </form>
        </div>

    </main>

    <!-- End of Body -->
    <!-- Begining of Footer -->
    <?php
    }else{
        header("location:reservations.php");
    }
    include("footer.php");
    ?>
    <!-- End of Footer -->
</body>
</html>