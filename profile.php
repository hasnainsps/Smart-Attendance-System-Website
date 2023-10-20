<?php include_once('header.php'); ?>

<?php
if(!isset($_SESSION["user_id"]))
{   
    header('location:logout.php');
} 
    $user_id = $_SESSION['user_id'];
    $query = mysqli_query($con, "SELECT * FROM user WHERE user_id='$user_id'");
    $result = mysqli_fetch_assoc($query);
     /*if($result = mysqli_fetch_array($query) ){*/
         $user_name = $result["user_name"];
         $email = $result["email"];
         if ($result['image']== NULL) {
            $image = "assets/images/image-gallery/default_image.png";
            }
         else{
           $image = $result['image'];
           }
         $MobileNumber = $result["Mobile_number"];
    //}
    
    if (isset($_POST['changepassword'])) {
        $currentpassword = ($_POST['currentpassword']);
        $newpassword = ($_POST['newpassword']);
        $confirmPassword = ($_POST['confirmPassword']);
        $query = mysqli_query($con, "SELECT * FROM user WHERE user_id='$user_id'");
        $row = mysqli_fetch_assoc($query);
        if ($currentpassword==$row['password']) {
            $query2 = mysqli_query($con, "UPDATE user SET password = '$newpassword' WHERE user_id='$user_id'");
            $_SESSION['error_message'] = '<div class="alert alert-success" role="alert">
                                            <div class="container">
                                                <div class="alert-icon">
                                                    <i class="zmdi zmdi-thumb-up"></i>
                                                </div>
                                                <strong>Well done!</strong> Password changed Successfully.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">
                                                        <i class="zmdi zmdi-close"></i>
                                                    </span>
                                                </button>
                                            </div>
                                           </div>';
        }
        else{
            $_SESSION['error_message'] = '<div class="alert alert-danger" role="alert">
                                            <div class="container">
                                            <strong>Current</strong> Password is Wrong .
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                            <i class="zmdi zmdi-close"></i>
                                            </span>
                                            </button>
                                            </div>
                                            </div>';
            }
        }
        ?>

<!-- Main Content -->

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Profile</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="zmdi zmdi-home"></i> Smart Attendance</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div> 
             <div class="col-lg-4 col-md-12"> 
            <div class="card mcard_3"><br><br>
            <div class="body">
                <div class="rounded-circle shadow " alt="profile-image">
                    <img src="<?php echo $image; ?>">
                </div><br>
                <h6></h6>
                <h4 class="m-t-10"> <span style="font-size: small; float: left;">User Name: </span> <?php echo $user_name; ?></h4>   
                <h4 class="m-t-10"><span style="font-size: small; float: left;">Email: </span><?php echo $email;  ?></h4> 
                <h4 class="m-t-10"><span style="font-size: small; float: left;">Mob NO: </span><?php echo $MobileNumber;  ?></h4>                       

            </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                       <div class="card">
                                <span class="text-danger"><?php
                                if(isset($_SESSION['error_message'])){
                                    echo  $_SESSION['error_message'];
                                    unset($_SESSION['error_message']);
                                }
                            ?></span>
                        <div class="header">
                            <h2><strong>Password</strong> Settings</h2>
                        </div>
                        <div class="body">
                        <form method="post" id="chngpwd">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="password" name="currentpassword" id="currentpassword" class="form-control" placeholder="Current Password">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info" name="changepassword">Save Changes</button>
                                </div>                                
                            </div> 
                            </form>                             
                        </div>
                </div>
            </div>

        </div>
    </div>
    
</section>

<?php include_once('footer.php'); ?>
<script>
    $('#chngpwd').validate({
	      	rules: {
	         	currentpassword: 'required',
	         	newpassword: 'required',
	         	confirmPassword: {
	            	required: true,
	            	equalTo : "#newpassword",
	         	},
	      	},
	      	messages: {
			   	currentpassword: 'Current Password is required',
			   	newpassword: 'New Password is required',
			   	confirmPassword: {
			   		required : 'Confirm Password is required',
			   		equalTo : 'Password not matching',
			   	}
			},
	   });
</script>
</body>
</html>