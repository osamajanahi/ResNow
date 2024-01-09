<?php
session_start();
try
{
    require ("connection.php");
}
catch(PDOException $e)
{
    die($e->getMessage());
}
// Check if the user is already logged in
if(isset($_SESSION["activeUser"])){
	header("location: index.php");
}

if(isset($_POST['login'])){
  // Define variables and initialize with empty values
  $email = $password = "";
  $email_err = $password_err = $info_err = "";

  if (!empty( $_POST["email"] )) {
    $value = validate( $_POST["email"] );
    if ( filter_var($value, FILTER_VALIDATE_EMAIL) )
      $email = $value;
    else
      $info_err = "Please re-check your email";
  }
  else
    $email_err = "Write your email please";

  if (!empty( $_POST["password"] )) {
    $value = validate( $_POST["password"] );
    $expression = "/^[A-Za-z0-9?@.]{8,25}$/";
    if ( preg_match( $expression , $value) )
      $password = $value;
    else
      $info_err = "Invalid email or password";
  }
  else
    $password_err = "Write your password please";

	if (empty( $_POST["email"] ) || empty( $_POST["password"] ))
		unset($info_err);

	if(empty($info_err) && empty($email_err) && empty($password_err)) {
		try {
			$db->beginTransaction();
			$stmt1=$db->prepare("SELECT * FROM user WHERE email = ?");

			if ( $stmt1->execute([$email]) ){
				$returened=$stmt1->fetch();
				if ($returened != false){
					$dbpassword=$returened['password'];
					if (password_verify($password,$dbpassword)){
						$_SESSION['activeUser']=$returened['id'];
						$_SESSION['userType']=$returened['type'];
						header('location: index.php');
					}
					else
						$info_err = "Invalid email or password";
				}
				else
					$info_err = "Invalid email or password";
			}
			else
				$info_err = "There is an error. Please try again then contact us.";

			$db->commit();
		}
		catch(PDOException $ex) {
			$db->rollBack();
			die ($ex->getMessage());
		}
	}
}

 function validate($data){
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

    <div class="login-page-logo">
      <a class="navbar-brand " href="index.php">
        <img src="Images/logo.png" alt="" style="height: 52px ;margin-left:32px" />
      </a>
    </div>

    <div class="container-fluid mt-5  ">
      <div class="row ">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto mt-5 login-box ">
          <div class="card mb-1 login-box-body">
            <div class="card-header  login-box-header">
              <h4 class="text-center login-box-header-first-text">Login</h4>
              <p class="text-center login-box-header-second-text">Enter your credentials to access your account</p>
            </div>
            <div class="card-body px-5 ">
              <!-- <h5 class="text-center">Welcome Back</h5> -->

              <form id="login" class="needs-validation" novalidate action="" method="post">


                <div class="login-email-input-div">
                  <i class="fa-solid fa-envelope "></i>
                  <input required class="my-1 form-control login-box-body-input " type="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
									<?php if (isset($email_err)) echo "<h6>$email_err</h6>"; ?>
                </div>


                <div class="login-password-input-div">

                  <i class="fa-solid fa-key"></i>
                  <input id="pass" class="my-1 form-control login-box-body-input " type="password" name="password" placeholder="Password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">
									<?php if (isset($password_err)) echo "<h6>$password_err</h6>"; ?>
                  <!-- <a class=" btn btn-outline-primary" onclick="showpass()"> -->
                  <i id="show" class="fa-solid fa-eye-slash login-showpass-icon" onclick="showpass()"></i>
                  <!-- <label id="showlabel" class="form-check-label">Show Password</label> -->
                  <!-- </a> -->
                </div>

                <div class=" login-button-div d-grid ">
                  <!-- <div class="btn btn-outline-primary position-relative mt-2 login-box-button"> -->
                  <div>

											<?php if (isset($info_err)) echo "<h6 class='text-center'>$info_err</h6>"; ?>
                    <button class="btn position-relative mt-2 login-box-button" name="login">
                      <i class="fa-solid fa-right-to-bracket"></i>
                      <span>Log In</span>
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <div class="alert alert-dark text-center login-box-footer">
            <p style="display:inline;margin-right:2px;">Do not have an account? </p><a class="primary-link stretched-link" href="register.php">Register Now</a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- End of Body -->
  <script>
    function showpass() {
      var passinput = document.getElementById("pass");
      var show = document.getElementById("show");
      var label = document.getElementById("showlabel")
      if (passinput.type === "password") {
        passinput.type = "text";
				show.classList.replace("fa-eye-slash", "fa-eye");
        label.textContent = "Hide Password";
      } else {
        passinput.type = "password";
				show.classList.replace("fa-eye", "fa-eye-slash");
        label.textContent = "Show Password";
      }
    }
  </script>
  <script>
    function onSubmit(token) {
      document.getElementById("login").submit();
    }
  </script>
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <!-- Begining of Footer -->
  <?php
  include("footer.php");
  ?>
  <!-- End of Footer -->
</body>

</html>
