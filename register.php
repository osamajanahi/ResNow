<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION["activeUser"])) {
  header("location: index.php");
}

if (isset($_POST['register'])) {

  // Define variables and initialize with empty values
  $Fname = $Lname = $gender = $email = $promotion = $password = $cpassword = "";
  $Fname_err = $Lname_err = $gender_err = $email_err = $password_err = $cpassword_err = "";

  // Validate Values
  if (!empty($_POST["Fname"])) {
    $value = validate($_POST["Fname"]);
    $expression = "/^[A-Za-z]{3,25}$/";
    if (preg_match($expression, $value))
      $Fname = $value;
    else
      $Fname_err = "The first name must be consists of 3 to 25 English letters only";
  } else
    $Fname_err = "Write your first name please";

  if (!empty($_POST["Lname"])) {
    $value = validate($_POST["Lname"]);
    $expression = "/^[A-Za-z]{3,25}$/";
    if (preg_match($expression, $value))
      $Lname = $value;
    else
      $Lname_err = "The last name must be consists of 3 to 25 English letters only";
  } else
    $Lname_err = "Write your last name please";

  if (isset($_POST["gender"]))
    $gender = $_POST["gender"];
  else
    $gender_err = "Please choose your gender";

  if (!empty($_POST["email"])) {
    $value = validate($_POST["email"]);
    if (filter_var($value, FILTER_VALIDATE_EMAIL))
      $email = $value;
    else
      $email_err = "Please re-check your email";
  } else
    $email_err = "Write your email please";

  if (isset($_POST["promotion"]))
    $promotion = $_POST["promotion"];
  else
    $promotion = null;

  if (!empty($_POST["password"])) {
    $value = validate($_POST["password"]);
    $expression = "/^[A-Za-z0-9?@.]{8,25}$/";
    if (preg_match($expression, $value))
      $password = $value;
    else
      $password_err = "The password must be consists of 8 to 25 letters - numbers - (?, @, .)";
  } else
    $password_err = "Write your password please";

  if (!empty($password)) {
    if (!empty($_POST["cpassword"])) {
      $value = validate($_POST["cpassword"]);
      if ($value == $password)
        $cpassword = password_hash($password, PASSWORD_DEFAULT);
      else
        $cpassword_err = "The password confirmation does not match the password";
    } else
      $cpassword_err = "Write confirmation password please";
  }

  if (isset($_POST['terms'])) {
    require('connection.php');
    if (empty($Fname_err) && empty($Lname_err) && empty($gender_err) && empty($email_err) && empty($password_err) && empty($cpassword_err)) {
      try {
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO user VALUES (NULL,'user',?,?,?,?,?,NULL)");

        if ($stmt->execute([$Fname, $Lname, $email, $cpassword, $gender]))
          header('location: login.php');
        else
          echo "<script>alert('Failed to register. please try again then contact us please');</script>";

        $db->commit();
      } catch (PDOException $ex) {
        $db->rollBack();
        if ($ex->errorInfo[1] == 1062)
          $info_err = "This email is already registered";
      }
    }
  } else
    $terms_err = "You must agree the Terms of service to register";
}

function validate($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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

  <style>
    #labelmale,
    #labelfemale {
      font-size: 18px;
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 24px;
      padding: 5px 15px;
    }

    #labelmale:hover,
    #labelfemale:hover {
      transition-duration: 0.5s;
      color: #e6e6e6;
      border: 2px solid white;
    }

    #labelmale {
      border: 2px solid #A0ADFB;
    }

    #labelfemale {
      border: 2px solid #FBA0DA;
    }

    #male,
    #female {
      opacity: 0;
    }

    #male:checked+label {
      background-color: #A0ADFB;
    }

    #female:checked+label,
    #male:checked+label {
      transition-duration: 0.5s;
      font-size: 24px;
    }

    #female:checked+label {
      background-color: #FBA0DA;
    }
  </style>
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
    <div class="container-fluid mt-5">
      <div class="row my-1">
        <!-- <div class="col-12 col-sm-10 col-md-8 col-lg-2 ml-auto register-left-box login-box">
          <h4>Get Started</h4>
          <img src="Images/registerimage.png" width="220px " height="320px">
        </div> -->
        <div class="col-12 col-sm-10 col-md-8 col-lg-8 mx-auto pl-0 register-right-box login-box">
          <div class="card mb-1 login-box-body">
            <div class="card-header login-box-header">
              <h4 class="text-center login-box-header-first-text">Register Page</h4>
              <p class="text-center login-box-header-second-text">Enter your credentials to access your account</p>
            </div>
            <div class="card-body px-3">
              <?php if (isset($info_err)) echo "<h6 class='text-center'>$info_err</h6>"; ?>
              <form id="register" onsubmit="return validateForm();" class="needs-validation" novalidate action="" method="post">
                <i class="fa-solid fa-user"></i>
                <div class="row align-items-center my-1">
                  <div class="col-12 col-lg-7">
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <div class="form-controler">
                          <input required class="my-1 form-control form-control-sm " type="text" id="Fname" name="Fname" placeholder="First Name" value="<?php if (isset($_POST['Fname'])) echo $_POST['Fname']; ?>">
                          <small>Error message</small>
                        </div>
                        <?php if (isset($Fname_err)) echo "<h6>$Fname_err</h6>"; ?>
                      </div>
                      <div class="col ml-4 ml-md-0">
                        <div class="form-controler">
                          <input required class="my-1 form-control form-control-sm " type="text" id="Lname" name="Lname" placeholder="Last Name" value="<?php if (isset($_POST['Lname'])) echo $_POST['Lname']; ?>">
                          <small>Error message</small>
                        </div>
                        <?php if (isset($Lname_err)) echo "<h6>$Lname_err</h6>"; ?>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="my-1 position-relative text-center">
                      <div class="form-controler gender-cn" id="genderCn">
                        <div class="form-check form-check-inline form-control-sm" style="color: #A0ADFB ;">
                          <input class="form-check-input" type="radio" name="gender" id="male" value="M" <?php if (isset($_POST['gender']) && $_POST['gender'] == "M") echo "checked"; ?>>
                          <label id="labelmale" class="form-check-label" for="male"><i class="fa-solid fa-mars"></i> Male</label>
                        </div>
                        <div class="form-check form-check-inline form-control-sm " style="color:	#FBA0DA	;">
                          <input class="form-check-input" type="radio" name="gender" id="female" value="F" <?php if (isset($_POST['gender']) && $_POST['gender'] == "F") echo "checked"; ?>>
                          <label id="labelfemale" class="form-check-label" for="female"><i class="fa-solid fa-venus"></i> Female</label>
                        </div>
                        <small class="gender">Error message</small>
                      </div>
                      <?php if (isset($gender_err)) echo "<h6>$gender_err</h6>"; ?>
                    </div>
                  </div>
                </div>
                <div class="my-2">
                  <i class="fa-solid fa-envelope"></i>
                  <div class="form-controler">
                    <input required class="my-1 form-control form-control-sm " type="email" id="email" name="email" placeholder="Email" onkeyup="checkEmail(this)" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                    <small>Error message</small>
                  </div>
                  <?php if (isset($email_err)) echo "<h6>$email_err</h6>"; ?>
                </div>
                <i class="fa-solid fa-key"></i>
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="form-controler">
                      <input id="pass" class="my-1 form-control form-control-sm" type="password" name="password" placeholder="Password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">
                      <small>Error message</small>
                    </div>
                    <?php if (isset($password_err)) echo "<h6>$password_err</h6>"; ?>
                  </div>
                  <div class="col ml-4 ml-md-0">
                    <div class="form-controler">
                      <input id="pass2" class="my-1 form-control form-control-sm" type="password" name="cpassword" placeholder="Password Confirm" value="<?php if (isset($_POST['cpassword'])) echo $_POST['cpassword']; ?>">
                      <small>Error message</small>
                    </div>
                    <?php if (isset($cpassword_err)) echo "<h6>$cpassword_err</h6>"; ?>
                  </div>
                </div>
                <a class="my-1 btn btn-outline-primary" onclick="showpass()">
                  <i id="show" class="fa-solid fa-eye-slash"></i>
                  <label id="showlabel" class="form-check-label">Show Password</label>
                </a>
                <div class="form-check">
                  <input class="form-check-input" value="c" type="checkbox" id="promotion" name="promotion" <?php if (isset($_POST['promotion']) && $_POST['promotion'] == "c") echo "checked"; ?>>
                  <label class="form-check-label" for="promotion">
                    I would like to recieve promotion e-mails.
                  </label>
                </div>
                <div class="form-check">
                  <div class="form-controler">
                    <input class="form-check-input" value="c" type="checkbox" id="accept" name="terms" <?php if (isset($_POST['terms']) && $_POST['terms'] == "c") echo "checked"; ?>>
                    <label class="form-check-label" for="accept">
                      I agree all statements in <a class="primary-link" href="#">Terms of service</a>.
                    </label>
                    <small>Error message</small>
                  </div>
                  <?php if (isset($terms_err)) echo "<h6>$terms_err</h6>"; ?>
                </div>
                <div class="register-button-div d-grid ">
                  <!-- <div class="btn btn-outline-primary position-relative mt-2 login-box-button"> -->
                  <div>
                    <button name="register" class="btn position-relative mt-2 login-box-button">
                      <i class="fa-solid fa-right-to-bracket"></i>
                      <span>Register</span>
                    </button>
                  </div>
                </div>

                <!-- <div class="d-grid">
                  <div class="btn btn-outline-primary position-relative mt-2">
                    <i class="fa-solid fa-user-plus"></i>
                    <button data-sitekey="reCAPTCHA_site_key" data-callback='onSubmit' type="submit" class="btn-outline-primary bg-transparent border-0 stretched-link g-recaptcha">Register</button>
                  </div>
                </div> -->




              </form>
            </div>
          </div>
          <div class="alert alert-dark text-center login-box-footer">
            <p style="display:inline;">Already have an account? </p><a class="primary-link stretched-link" href="login.php">Log In</a>
            <p style="display:inline;">.</p>
          </div>
        </div>
      </div>
    </div>

  </main>
  <script src="script.js"></script>
  <!-- End of Body -->
  <script>
    function showpass() {
      var passinput = document.getElementById("pass");
      var passinput2 = document.getElementById("pass2");
      var show = document.getElementById("show");
      var label = document.getElementById("showlabel")
      if (passinput.type === "password") {
        passinput.type = "text";
        passinput2.type = "text";
        show.classList.replace("fa-eye-slash", "fa-eye");
        label.textContent = "Hide Password";
      } else {
        passinput.type = "password";
        passinput2.type = "password";
        show.classList.replace("fa-eye", "fa-eye-slash");
        label.textContent = "Show Password";
      }
    }
  </script>
  <!-- Begining of Footer -->
  <?php
  include("footer.php");
  ?>
  <!-- End of Footer -->
</body>

</html>