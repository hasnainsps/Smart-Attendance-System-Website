<?php session_start();

if(isset($_SESSION['user_id'])){
   echo $_SESSION['user_id'];
   echo "<script>window.location.href='dashboard.php'</script>";
}
include('config.php');
   if (isset($_POST['login']))
      {
         $email_or_username = mysqli_real_escape_string($con, $_POST['email_or_username']);
         $password = mysqli_real_escape_string($con, $_POST['password']);
                  
         $query      = mysqli_query($con, "SELECT * FROM `user` WHERE  `password`='$password' and `email`='$email_or_username' or `user_name` = '$email_or_username'");
         $row     = mysqli_fetch_array($query);
         $num_row    = mysqli_num_rows($query);
         
         if ($num_row > 0) 
            {        
               $_SESSION['user_id']=$row['user_id'];
               // $_SESSION['user_name'] = $row['user_name'];
               header('location:dashboard.php');
               
            }
         else
            {
                $_SESSION['error_message'] = "Invalid Email or Password ";
            }
      }
  ?>

<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>:: Aero Bootstrap4 Admin :: Sign In</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Custom Css -->
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.min.css">  
<style>
    .error{
        color: red;
        width: 100%;
    }
    .manual-error{
        display: none;
    }

    input[name="login"].btn-primary {
     background-color: #1c2d40;
      }
    
    p.mb-0 a[href="registration.php"] {
      color: #1c2d40;
     }


</style>  
</head>

<body class="theme-blush">

<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" action="" method="post" id="loginform">
                    <div class="header">
                        <img class="logo" src="assets/images/login_image3.png" alt="">
                        <h5>Log in</h5>
                    </div>
                    <div style="text-align:center;">
                    <span class="text-danger"><?php
                        if(isset($_SESSION['error_message'])){
                            echo  $_SESSION['error_message'];
                            unset($_SESSION['error_message']);
                        }
                    ?></span>
                    </div>
                    <div class="body">
                        <div class="input-group mb-3">
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                               </div>
                               <input type="text" name="email_or_username" id="email_or_username" class="form-control" placeholder="Email or Username">
                            </div> 
                        </div>
                            <span id="email-error" class="error manual-error" for="email_or_username"></span>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                               </div>
                               <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>                         
                        </div>
                        <span id="password-error" class="error manual-error" for="password"></span>
                        <div class="checkbox">
                            <input id="remember_me" type="checkbox">
                            <label for="remember_me">Remember Me</label>
                        </div>
                        <input type="submit" name="login" value="Sign In" class="btn btn-primary btn-block waves-effect waves-light">
                                               
                        <div class="signin_with mt-3">
                            <p class="mb-0">or <a href="registration.php"><strong>Sign Up</strong></a></p><br>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round facebook"><i class="zmdi zmdi-facebook"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round twitter"><i class="zmdi zmdi-twitter"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round google"><i class="zmdi zmdi-google-plus"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="assets/images/signin.svg" alt="Sign In"/>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once('footer.php'); ?>
<script>
    $('#loginform').validate({
            rules: {
                email_or_username:{
                    required: true,
                    //email: true // Optional, if you want to validate email format
                }, 
                password: 'required'
            },
            messages: {
                email_or_username: 'Email or Username is required',
                password: 'Password is required'
            },
       });
</script>
</body>
</html>