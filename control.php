<?PHP 
session_start();
if(!isset($_SESSION['activeUser']))
header('location:login.php');
if($_SESSION['userType']!='admin')
die('unauthorized');
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
require ("nav.php");
?>


  <!-- End of header -->

  <!-- Begining of body -->

  <main>

  <main>
  <div class="container form-box">
      <div class="login-box-header">
        <h4 class="text-center login-box-header-first-text maintextcolor">Admin Control</h4>
        <p class="text-center login-box-header-second-text">For admin Access only</p>
      </div>
      <br>
      <form  method="POST" <?php if (isset($_POST['first'])) echo 'action="addingfield.php"' ?> enctype="multipart/form-data">
        <div class="form-group mycontactusform">
          <label>Category</label>
          <select class=" ml-1 admin-control-inputs" name="cat">
            <option <?php if (isset($_POST['first']) && $_POST['cat'] == 'Football') echo 'selected'; ?> >Football</option>
            <option <?php if (isset($_POST['first']) && $_POST['cat'] == 'Basketball') echo 'selected'; ?>>Basketball</option>
            <option <?php if (isset($_POST['first']) && $_POST['cat'] == 'Padel') echo 'selected'; ?>>Padel</option>
          </select>
          <br>


          <label for="fname" class="newline" class="newline">Field Name</label>
          <input type="text" class="form-control contactus-inputs" name="fname" id="fname" placeholder="Field Name" value="<?php if (isset($_POST['first'])) echo $_POST['fname']; ?>">
          <br>
          <label>Available Courts</label>
          <input type="number" class=" ml-1 admin-control-inputs" name="Avcourts" placeholder="2" value="<?php if (isset($_POST['first'])) echo $_POST['Avcourts']; ?>">
          <br>

          <label for="location" class="newline">Location</label>
          <input type="text" class="form-control contactus-inputs" name="location" id="location" placeholder="Isa Town" value="<?php if (isset($_POST['first'])) echo $_POST['location']; ?>">

          <label>Location Link</label><br>
          <input type="text" class="form-control contactus-inputs" name="loclink" placeholder="https://goo.gl/maps/T3eVnFna92XZCPw36" value="<?php if (isset($_POST['first'])) echo $_POST['loclink']; ?>">


          <label for="price" class="newline">Price</label>
          <input type="number" class="form-control contactus-inputs" name="price" id="price" placeholder="4 BD" value="<?php if (isset($_POST['first'])) echo $_POST['price']; ?>">
          <br>



          <label>Facilities :</label><br>
          <label for="first-facility" class="ml-2">Balls</label>
          <input type="checkbox" class="" name='facility[0]' id="first-facility" <?php if (isset($_POST['first']) && isset($_POST['facility'][0])) echo 'checked'; ?>>

          <label for="second-facility" class="ml-4">Shower</label>
          <input type="checkbox" class="" name='facility[1]' id="second-facility"  <?php if (isset($_POST['first']) && isset($_POST['facility'][1])) echo 'checked'; ?>>

          <label for="third-facility" class="ml-4">Water</label>
          <input type="checkbox" class="" name='facility[2]' id="third-facility" <?php if (isset($_POST['first']) && isset($_POST['facility'][2])) echo 'checked'; ?>>

          <label for="fourth-facility" class="ml-4">Toilet</label>
          <input type="checkbox" class="" name='facility[3]' id="fourth-facility"  <?php if (isset($_POST['first']) && isset($_POST['facility'][3])) echo 'checked'; ?>>
          <br>
          <br>



          <label>Opening time</label>
          <input type="text" name='start' placeholder="12:00" class=" ml-1 mr-4 admin-control-inputs" value="<?php if (isset($_POST['first'])) echo $_POST['start']; ?>">

          <label>Closing time</label>
          <input type="text" name='end' placeholder="24:00" class="ml-1 admin-control-inputs" value="<?php if (isset($_POST['first'])) echo $_POST['end']; ?>">
        <br/>
          <br><?php
if (!isset($_POST['first']))
{
    echo '<label>Number of pictures</label>';
    echo '<input type="number" name="numpic" min=1 max=10 placeholder="1" class="ml-1 admin-control-inputs admin-num-of-pic"><br/>';
    echo '<input type="submit" name="first" value="Update form" class="btn mycontactsubmit login-box-button">';
}
else
{
    echo "<label for='mainpic'/>Main Field Picture</label> <input type='file' name='mainpic' id='mainpic'><br/><h4>Extra Pictures</h4>";
    for ($i = 0;$i < $_POST['numpic'];$i++)
    {
        echo '<label for="fieldimg"/>Please upload a picture</label> <input type="file" name="fieldimg[]" id="fieldimg"><br/>';
    }
    echo '<input type="submit" name="addfield" value="Add" class="btn mycontactsubmit login-box-button">';
}
?>
        </div>
      </form>
    </div>
</main>
  </main>
  <!-- End of Body -->
  <!-- Begining of Footer -->
  <?php
include ("footer.php");
?>
  <!-- End of Footer -->
</body>

</html>
