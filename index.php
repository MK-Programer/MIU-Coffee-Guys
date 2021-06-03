<?php
include "class.php";
session_start();
if (isset($_SESSION["admin"]) ? $_SESSION["admin"]['role'] == 'admin' : '') {
    header('location: product.php');
}
if (isset($_SESSION["admin"]) ? $_SESSION["admin"]['role'] == 'user' : '') {
    header('location: user_page.php');
}
$registerLogin = new Person();
if (isset($_POST['register'])) {
    $registerLogin->register($_POST);
    $error = $registerLogin->get_errors();
    // $email_verified = $registerLogin->email_verified;
}
if (isset($_POST['login'])) {
    $registerLogin->login($_POST);
    $get_errors_login = $registerLogin->get_errors_login_all();
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- File CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Coffee Guys</title>
</head>

<body>

    <div class="container">
        <header class="header">
            <nav class="navbar navbar-expand-lg navbar-light py-3">
                <div class="container">

                    <a href="#" class="navbar-brand">
                        <img src="image/logoupper.png" alt="logo" width="150px;">
                    </a>
                </div>
            </nav>
        </header>



        <div class="container">
            <div class="row py-5 mt-4 align-items-center">
                <!-- For Demo Purpose -->
                <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
                    <img src="https://res.cloudinary.com/mhmd/image/upload/v1569543678/form_d9sh6m.svg" alt="" class="img-fluid mb-3 d-none d-md-block">
                    <h1>Welcome to Coffee Guys</h1>
                    <p class="font-italic text-muted mb-0">Create a Register/Login</p>
                    </p>
                </div>


                <div class="col-md-7 col-lg-6 ml-auto">
                    <!-- Registeration Form -->
                    <form id="register-form" method="Post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="text-left w-100 mb-4 ml-3">
                            <p class="text-green h3 font-weight-bold text-uppercase">Create an Account</p>
                            <?php
                            if (isset($error)) {
                                foreach ($error as $e) { ?>
                                    <div class='alert alert-danger alert-dismissible col-md-10 ml-4 mt-1'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        <?php echo $e; ?>
                                    </div>
                            <?php }
                            } ?>



                        </div>
                        <div class="container">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" name="lname" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email address">
                        </div>
                        <div class="form-group col-lg-12 mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="form-group col-lg-12 mb-3">
                            <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password">
                        </div>
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <input type="submit" name="register" class="btn btn-primary btn-block py-2 font-weight-bold" value="Create your account">
                        </div>
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>
                        <!-- Already Registered -->
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold">Already Registered? <a href="#" id="login" class="text-primary ml-2">Login</a></p>
                        </div>
                    </form>



                    <!-- 
                    Login form -->

                    <form id="login-form" method="Post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="text-left w-100 mb-4 ml-3">
                            <p class="text-green h3 font-weight-bold text-uppercase">Login Form</p>
                            <?php 
                                          if (isset($_GET['msg2']) == "newPassword") {
                                            echo "
                                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                            Password change successfully !
                                 <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                                    </div>
                                                    
                                                    ";
                                        }
                                        ?>
                            <?php
                            if (!empty($_SESSION['success'])) {
                            ?>

                                <div class='alert alert-success alert-dismissible col-md-10 ml-4 mt-1'>
                                    <button class='close' type="submit" name="unset_session" data-dismiss='alert'>&times;</button>
                                    <?php echo $_SESSION['success']; ?>
                                </div>
                            <?php
                            }
                            ?>
                            <?php
                            if (!empty($_SESSION['status'])) {
                            ?>



                                <div class='alert alert-danger alert-dismissible col-md-10 ml-4 mt-1'>

                                    <button class='close' type="submit" name="unset_session" data-dismiss='alert'>&times;</button>
                                    <?php echo $_SESSION['status']; ?>
                                </div>

                            <?php
                            }
                            ?>
                            <?php
                            if (isset($get_errors_login)) {
                                foreach ($get_errors_login as $e) { ?>
                                    <div class='alert alert-danger alert-dismissible col-md-10 ml-4 mt-1'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        <?php echo $e; ?>
                                    </div>
                            <?php }
                            } ?>
                       
                        </div>

                        <div class="form-group col-lg-12 mb-3">
                            <input type="email" class="form-control" name="email" value="<?php if (isset($_COOKIE["email"])) {
                                                                                                echo $_COOKIE["email"];
                                                                                            } ?>" placeholder="Email address">
                        </div>
                        <div class="form-group col-lg-12 mb-3">
                            <input type="password" class="form-control" name="password" value="<?php if (isset($_COOKIE["password"])) {
                             echo $_COOKIE["password"];
                                  } ?>" placeholder="Password">
                        </div>
                        <div class="form-check col-lg-12 mb-3 ml-3">
                            <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1" <?php if (isset($_COOKIE["remember"])) { ?> checked <?php } ?> />

                            <label class="form-check-label text-muted font-weight-bold" for="exampleCheck1">Remember me</label>
                        </div>

                        <div class="form-group col-lg-12 mx-auto mb-3">
                            <input type="submit" id="login_now" name="login" class="btn btn-primary btn-block py-2 font-weight-bold" value="Log In">


                        </div>
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold"><a href="forgotPassword.php" class="text-primary ml-2">Forgot Password?</a></p>
                        </div>
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>
                        <!-- Already Registered -->
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold">Do not have an account? <a href="#" id="register" class="text-primary ml-2">Register</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <script>
        let loginForm = document.getElementById("login-form");
        let registerForm = document.getElementById("register-form");
        loginForm.style.display = "none";
        let login = document.getElementById("login");
        let register = document.getElementById("register");
        let login_now = document.getElementById("login_now");

        login_now.addEventListener("click", function() {

            registerForm.style.display = "none";
            loginForm.style.display = "block";
        });
        login.addEventListener("click", function() {
            registerForm.style.display = "none";
            loginForm.style.display = "block";
        });
        register.addEventListener("click", function() {
            registerForm.style.display = "block";
            loginForm.style.display = "none";
        });
    </script>
</body>

</html>