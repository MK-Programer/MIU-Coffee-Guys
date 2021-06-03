<?php

class Person
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "phpoop";
    public $con;
    public $errors = [];
    public $get_errors_login = [];
    public $email_verified = [];
    public $email_verifieds = "";

    public function __construct()
    {
        $this->con = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if (mysqli_connect_error()) {
            trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
        } else {
            return $this->con;
        }
    }

    public function register($post)
    {
       
        $name = $this->con->escape_string($_POST['name']);
        $lname = $this->con->escape_string($_POST['lname']);
        $email = $this->con->escape_string($_POST['email']);
        $password =  $this->con->escape_string($_POST['password']);
        $confirmPassword = $this->con->escape_string($_POST['confirmPassword']);

        if (isset($name) && !empty($name) && isset($lname) && !empty($lname) && isset($email) && !empty($email) &&  isset($password) && !empty($password) && isset($confirmPassword) && !empty($confirmPassword)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $query = "SELECT * FROM users WHERE email ='$email'";
                $result = $this->con->query($query);
                if ($result->num_rows > 0) {
                    $this->errors[] = "Email already exist!";
                } else {
                    if (strlen($password) >= 8 && strlen($confirmPassword) >= 8) {
                        if ($password === $confirmPassword) {
                            $password = password_hash($password, PASSWORD_BCRYPT);
                            $confirm_password = password_hash($confirmPassword, PASSWORD_BCRYPT);
                            $activationcode = rand(999999, 111111);
                            $date = strtotime('+ 1 year', strtotime("now"));
                            $license_date =  date('Y-m-d', $date);
                            $query = "INSERT INTO `users` (`name`,`lastname`,`email`, `password`,`active_status`,`license_date`) VALUES ('$name','$lname','$email','$password','$activationcode','$license_date')";
                            $sql = $this->con->query($query);
                            
                        } else {
                            $this->errors[] = "Password and Confirm password doesn't match!";
                        }
                    } else {
                        $this->errors[] = "Password must be more than 8 characters!";
                    }
                }
            } else {
                $this->errors[] = "Email is not valid!";
            }
        } else {
            $this->errors[] = "All fields are required!";
        }
    }

    // public function verified($post)
    // {
    //     $code = $this->con->escape_string($_POST['code']);
    // }

    public function get_errors()
    {
        return  $this->errors;
    }
    public function get_errors_login_all()
    {
        return $this->get_errors_login;
    }
    public function email_verified()
    {
        return $this->email_verified;
    }
    public function get_errors_forgot_password(){
        return $this->get_errors_forgot;
    }

    // login form 
    public function login($post)
    {
        
        $email = $this->con->escape_string($_POST['email']);
        $password =  $this->con->escape_string($_POST['password']);
        if (isset($email) && !empty($email) && isset($password) && !empty($password)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = "SELECT * FROM `users` WHERE `email`='$email'";

                if ($result = $this->con->query($sql)) {
                    $row = $result->fetch_assoc();
                    if ($email == $row['email']) {
                        if (password_verify($password, $row['password'])) {
                             #Show this user are verified or no
                            if ($row['active_status'] !== "verified") {
                                $activationcode = rand(999999, 111111);
                                $query = "UPDATE users SET active_status = '$activationcode' WHERE email = '$email'";
                                $sql = $this->con->query($query);
                            }
                            if(!empty($_POST["remember"]))   
                            {  
                             setcookie ("email",$email,time()+ (10 * 365 * 24 * 60 * 60));  
                             setcookie ("password",$password,time()+ (10 * 365 * 24 * 60 * 60));
                              $_SESSION['email'] = $email;
                            }  
                            else  
                            {  
                             if(isset($_COOKIE["email"]))   
                             {  
                              setcookie ("email","");  
                             }  
                             if(isset($_COOKIE["password"]))   
                             {  
                              setcookie ("password","");  
                             }  
                            } 

                            $_SESSION['admin']=array(
                                'id'=>$row['id'],
                                'email'=>$row['email'],
                                'password'=>$row['password'],
                                'role'=>$row['role']
                            );

                            if($row['role'] == "admin" && $row['status'] == "0"){
                           
                                header("Location:product.php");
                            }
                           
                             elseif($row['role'] == "user" && $row['status'] == "0"){
                        
                                header("Location: user_page.php");
                                $id_user =  $_SESSION['admin']['id'];
                                $query = "UPDATE users SET online='1' WHERE id='$id_user'";
                                $sql = $this->con->query($query);
                                $startDate =  date("Y-m-d");
                                $license_dates = $row['license_date'];
                                $new_date = strtotime($license_dates); 
                                $endDate = date('Y-m-d', $new_date);
                                
                                $diff = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
                                if($startDate > $endDate){
                                $_SESSION['status'] = 'License Expired';
                                header("Location: index.php");
                                 }
                                elseif($diff <= 1   && $startDate<$endDate){
                                $_SESSION['License'] =  "License will expire with next 1 days";
                                header("Location:index1.php");
                                }elseif($diff <= 2  && $startDate<$endDate){
                                    $_SESSION['License'] =  "License will expire with next 2 days";
                                    header("Location:index1.php");
                                }elseif($diff <= 3  && $startDate<$endDate){
                                    $_SESSION['License'] = "License will expire with next 3 days";
                                    header("Location:index1.php");
                                }elseif($diff <= 4  && $startDate<$endDate){
                                    $_SESSION['License'] =  "License will expire with next 4 days";
                                    header("Location:index1.php");
                                }elseif($diff <= 5  && $startDate<$endDate){
                                    $_SESSION['License'] =  "License will expire with next 5 days";
                                    header("Location:index1.php");
                                }elseif($diff <= 10  && $startDate<$endDate){
                                    $_SESSION['License'] =  "License will expire with next 10 days";
                                    header("Location:index1.php");
                                }
                                elseif($diff <= 20  && $startDate<$endDate){
                                    $_SESSION['License'] =  "License will expire with next 20 days";
                                    header("Location:index1.php");
                                }
                                elseif($diff <= 30 && $startDate<$endDate){
                                    $_SESSION['License'] = "License will expire with next 30 days";
                                    header("Location:index1.php");
                                }
                               
                            }
                            elseif( $row['role'] == "user" && $row['status'] == "1"){
                                unset( $_SESSION['admin']);
                                header("Location:index.php");
                             
                                $_SESSION['status'] = 'Your account is deactivated!!!';
                           }

                           
                        } else {
                            $this->get_errors_login[] = "Password is incorrect!";
                           if(!isset($_SESSION['attempt'])){
                             $_SESSION['attempt'] = 0;
                           }
                           $_SESSION['attempt'] += 1;
                           if($_SESSION['attempt'] === 3){
                            $query = "UPDATE users SET status='1' WHERE email='$email'";
                            $sql = $this->con->query($query);
                            session_unset();
         
                           }
                        }
                    } else {
                        $this->get_errors_login[] = "This email don't exit!";
                    }
                } else {
                    $this->get_errors_login[] = "Login failed!";
                }
            } else {
                $this->get_errors_login[] = "Email is not valid!";
            }
        } else {
            $this->get_errors_login[] = "All fields are required!";
        }
    }

    // Forgot Password 
    public function forgotPassword($email){
        $email = $this->con->escape_string($_POST['email']);   
        $sql = "SELECT * FROM `users` WHERE `email`='$email'";
        if ($result = $this->con->query($sql)) {
            $row = $result->fetch_assoc();
            if ($email == $row['email']) {
                $to = $email;
                $subject = "Reset your password on examplesite.com";
                $msg = "Hi there, click on this <a href =\"http://localhost/e-comerce/new-password.php\">Reset your password</a> to reset your password on our site";
                if (mail($to, $subject, $msg)) {
                    $info = "Please login into your $email account and click on the link we sent to reset your password";
                    $_SESSION['info'] = $info;
                    $_SESSION['email_'] = $email;
                    header('location: forgotPassword.php');
                    exit();
                } else {
                   
                    $this->get_errors_forgot[] = "Failed while sending code!";
                    header('location: forgotPassword.php');
                }

            }else {
                $this->get_errors_forgot[] = "Email is not valid!";
                header('location: forgotPassword.php');
            }
        }else {
            $this->get_errors_forgot[] = "Failed!";
            header('location: forgotPassword.php');
        }
    }
   // Change a Password
   public function changePassword($change,$email){
    $newpassword  = $this->con->escape_string($_POST['Newpassword']);
    $cnewpassword  = $this->con->escape_string($_POST['CNewpassword']);
    $email = $email;
    $sql = "SELECT * from users";
    $res = $this->con->query($sql);
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
           
            if($email == $row['email']){
     
               if($newpassword == $cnewpassword){
                  $password = password_hash($newpassword, PASSWORD_BCRYPT);
                  $query = "UPDATE users SET password = '$password' WHERE email = '$email'";
                  $sql = $this->con->query($query);
                  if ($sql == true) {
                      header("Location:index.php?msg2=newPassword");
                  } else {
                      $this->errors[] = "Change updated failed try again!";
                  }
               }else{
                  $this->errors[] = "Password and Confirm password doesn't match!";
               }
            }else{
              $this->errors[] = "Email doesn't match!";
            }
        }
    }

   }
}
