<?php session_start();
include_once('config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit."> 
    <title>Smart Attendance</title>

    <meta name="author" content="Codeconvey" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css"/>
    <!-- Student Registration Form CSS -->
    <link rel="stylesheet" href="assets/form_css/style.css">
    <!--Only for demo purpose - no need to add.-->
    <link rel="stylesheet" type="text/css" href="assets/form_css/demo.css" />
  
</head>
<body>
    <?php

    $user_id = $_GET['id'];
    $email = $_GET['email'];
    if (isset($_POST['changePassword'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    
    if ($newPassword !== $confirmPassword) {
          
          ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Attention!</strong> Passwords do not match.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        <?php
            } else {
             $query2 = mysqli_query($con, "UPDATE user SET password = '$newPassword' WHERE user_id='$user_id'");
             if ($query2) {
                 ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Well done!</strong> Password changed Successfully.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        <?php
             }
    }
  }
?>
    <header class="ScriptHeader">
        <div class="rt-container">
            <div class="col-rt-12">
                <div class="rt-heading">
                    <h1>Change Password</h1>
                </div>
            </div>
        </div>
    </header>
     <section>
            <div class="rt-container">
                <div class="col-rt-12">
                    <div class="Scriptcontent">
                        <!-- Start User Forgot Password Form -->
                        <form class="reg-form" role="form" method="POST" action="">
                            <div class="form-group">
                                <label class="control-label">New Password</label>
                                <div>
                                    <input type="Password" class="form-control input-lg" name="new_password" id="new_password" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Confirm Password</label>
                                <div>
                                    <input type="Password" class="form-control input-lg" name="confirm_password" id="confirm_password" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="changePassword" class="btn btn-success ">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
</div>
</section>

</body>
  <footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
     
  </footer>
</html>