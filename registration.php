<?php session_start();

if(isset($_SESSION['user_id'])){
   echo $_SESSION['user_id'];
   echo "<script>window.location.href='dashboard.php'</script>";
}
include('config.php');
   if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile_number = $_POST['Mnumber'];
     
        $query = "INSERT INTO `user` (`user_name`,`email`,`password`,`Mobile_number`) VALUES ('$username','$email','$password','$mobile_number')";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Redirect to login page after successful registration
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error occurred, please try again later";
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

<title>:: Aero Bootstrap4 Admin :: Sign Up</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Custom Css -->
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.min.css">   
<style>
    .error{
        color: red;
        width: 100%;
        margin-top: 10px;
    
    }
    .manual-error{
        display: none;
    }

     input[name="signup"].btn-primary {
     background-color: #1c2d40;
      }


</style>  
</head>

<body class="theme-blush">

<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" role ="form" action="" method="POST" id="registrationform">
                    <div class="header">
                        <img class="logo" src="assets/images/login_image3.png" alt="">
                        <h5>Sign Up</h5>
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
                        <span id="check_username"></span>
                        <div class="input-group mb-3">
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                               </div>
                               <input type="text" name="username" id="username" class="form-control" placeholder="Username"  onInput="checkusername()">
                            </div> 
                        </div>
                        <span id="check_email"></span>
                        <div class="input-group mb-3">
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span> 
                               </div>
                               <input type="email" name="email" id="email" class="form-control" placeholder="Email" onInput="checkemail()">
                            </div> 
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                               <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                               </div>
                               <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            </div>                         
                        </div>
                         <div class="input-group mb-3">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                               <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                               </div>
                               <input type="text" name="Mnumber" id="Mnumber" class="form-control" placeholder="Phone number">
                            </div>                         
                        </div>

                        <input type="submit" name="signup" id="submit" value="Sign Up now" class="btn btn-primary btn-block waves-effect waves-light">
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="assets/images/signup.svg" alt="Sign In"/>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once('footer.php'); ?>
<script>
    $(document).ready(function() {
        $('#registrationform').validate({
            rules: {
                username: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                username: {
                    required: "Please enter your username"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Your password must be at least 8 characters long"
                }
            },
            highlight: function(element) {
      $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
      $(element).closest('.form-group').removeClass('has-error');
    },
        });
    });
</script>
<script>
function checkusername(){
   jQuery.ajax({
    url: "check_username.php",
    data:'username='+$('#username').val(),
    type: "POST",
    success:function(data){
        $("#check_username").html(data);
    },
    error:function(){}
   });
}

function checkemail(){
   jQuery.ajax({
    url: "check_username.php",
    data:'email='+$('#email').val(),
    type: "POST",
    success:function(data){
        $("#check_email").html(data);
    },
    error:function(){}
   });
}
</script>
</body>
</html>