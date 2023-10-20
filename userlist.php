<?php include_once('header.php'); ?>

          <!-- Main ntent -->

<style>
    a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.next {
  background-color: #04AA6D;
  color: white;
}

.round {
  border-radius: 50%;
}

</style>

    <section class="content">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-7 col-md-6 col-sm-12">
                        <h2>Users</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="zmdi zmdi-home"></i> Smart Attendance</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ul>
                        <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12">                
                        <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button><br><br><br>
                    </div>
                    <div class="container-fluid">  
                        <div class="row clearfix">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#adduser">Add User</button><br><br><br>
                                <div class="card">
                                <?php
                                        if(isset($_SESSION['message'])){
                                            echo  $_SESSION['message'];
                                            unset($_SESSION['message']);
                                        }
                                        ?>
                                    <div class="body">                                  
                                        <div class="table-responsive">
                                            <table class="table m-b-0">                                                
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>User ID</th>
                                                        <th>User name</th>
                                                        <th>Email</th>
                                                        <th>Operation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                 <?php
                                        if (isset($_GET['page'])) {
                                            $page = $_GET['page'];
                                        } else {
                                            $page = 1;
                                        }
                                        $num_per_page = 10;
                                        $start_from = ($page - 1) * $num_per_page;
                                                 $query= mysqli_query($con, "SELECT DISTINCT user.user_id, user.user_name, user.email, create_event.event_id
                                                    FROM `user`
                                                    JOIN `create_event` ON user.user_id = create_event.user_id
                                                    WHERE event_id IN (
                                                        SELECT event_id
                                                        FROM `create_event`
                                                        WHERE user_id = '$user_id' AND operation = 'create_event'
                                                    ) AND operation = 'join' GROUP BY user.user_id LIMIT $start_from, $num_per_page");
                                                 while($result= mysqli_fetch_array($query)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $result['user_id'];?></td>
                                                        <td><?php echo $result['user_name'];?></td>
                                                        <td><?php echo $result['email'];?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary editbtn" ><i class="zmdi zmdi-edit" aria-hidden="true"></i> Update</button> | 
                                                            <button type="button" class="btn btn-danger statusbtn" ><i class="zmdi zmdi-delete" aria-hidden="true"></i> Status</button> | 
                                                            <button type="button" class="btn btn-success passwordeditbtn" ><i class="zmdi zmdi-lock" aria-hidden="true"></i> Password</button>

                                                        </td>
                                                    </tr>        
                                                    <?php 
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php 
                                        $query2 = mysqli_query($con, "SELECT DISTINCT user.user_id, user.user_name, user.email, create_event.event_id
                                                    FROM `user`
                                                    JOIN `create_event` ON user.user_id = create_event.user_id
                                                    WHERE event_id IN (
                                                        SELECT event_id
                                                        FROM `create_event`
                                                        WHERE user_id = '$user_id' AND operation = 'create_event'
                                                    ) AND operation = 'join' GROUP BY user.user_id");
                                        $total_records = mysqli_num_rows($query2);
                                        $total_pages = ceil($total_records / $num_per_page);
                                        ?>
                                        <div style="padding-left: 30px;">
                                            <?php
                                            if ($page > 1) {
                                                echo "<a href='userlist.php?page=" . ($page - 1) . "' class='previous'>&laquo; Previous</a>";
                                            }

                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                echo "<a href='userlist.php?page=" . $i . "' class='btn btn-secondary'>$i</a>";
                                            }

                                            if ($page < $total_pages) {
                                                echo "<a href='userlist.php?page=" . ($page + 1) . "' class='previous'>Next &raquo;</a>";
                                            }
                                            ?>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>


    <!-- =================================php code for add modal====================================== -->

<?php 
if (isset($_POST['adduserbtn'])) {
    $addusername = $_POST['addusername'];
    $addemail = $_POST['adduseremail'];
    $addpassword = $_POST['adduserpassword'];
    $addrole = $_POST['adduserrole'];
    $query3= mysqli_query($con, "INSERT INTO user (user_name,email,password,role) VALUES ('$addusername','$addemail','$addpassword','$addrole') ");
    if ($query3) {
        //echo '<script>alert("User Added Successfully");</script>';
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
        <div class="container">
            <div class="alert-icon">
                <i class="zmdi zmdi-thumb-up"></i>
            </div>
            <strong>Well done!</strong> User Added Successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                    <i class="zmdi zmdi-close"></i>
                </span>
            </button>
        </div>
    </div>';
        echo "<script> document.location ='userlist.php'; </script>";
    }else{
        $_SESSION['message'] = "<div class='alert alert-danger'>User Adding Failed</div>";
        echo "<script> document.location ='userlist.php'; </script>";
    }
}
 ?>
<!-- =========================================================================== -->
<!-- =================================php code for edit modal====================================== -->
<?php 
if (isset($_POST['editmodal'])) {
    $editid = $_POST['editid'];
    $editusername = $_POST['editusername'];
    $editemail = $_POST['editemail'];
    $query2= mysqli_query($con, "UPDATE user SET user_name = '$editusername', email = '$editemail' WHERE user_id ='$editid' ");

    if ($query2) {
        //echo '<script>alert("User Data Updated Successfully");</script>';
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="zmdi zmdi-thumb-up"></i>
                                    </div>
                                    <strong>Well done!</strong> User Data Updated Successfully.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                            <i class="zmdi zmdi-close"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>';
        echo "<script> document.location ='userlist.php'; </script>";
    }else{
        
        $_SESSION['message'] = "<div class='alert alert-danger'>User Data Updation Failed</div>";
        echo "<script> document.location ='userlist.php'; </script>";
    }
}
 ?>
<!-- =============================php code for delete modal ============================================== -->
<?php 
if (isset($_POST['deletemodalbtn'])) {
    $deleteid = $_POST['deleteid'];
    $query2= mysqli_query($con, "UPDATE user SET status = 'disable'  WHERE user_id ='$deleteid'");

    if ($query2) {
        //echo '<script>alert("User Deleted Successfully");</script>';
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="zmdi zmdi-thumb-up"></i>
                                    </div>
                                    <strong>Well done!</strong> User Status Updated Successfully.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                            <i class="zmdi zmdi-close"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>' ;
        echo "<script> document.location ='userlist.php'; </script>";
    }else{
        $_SESSION['message'] = "<div class='alert alert-danger'>User Status Updation Failed</div>";
        echo "<script> document.location ='userlist.php'; </script>";
    }
}
?>

<!-- =================================php code for edit password modal====================================== -->
<?php 
if (isset($_POST['editpassworsmodalbtn'])) {
    $passwordid = $_POST['user_id'];
    $editpassword = $_POST['userpassword'];
    $query2= mysqli_query($con, "UPDATE user SET `password` = '$editpassword' WHERE user_id ='$passwordid' ");

    if ($query2) {
        //echo '<script>alert("User Data Updated Successfully");</script>';
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="zmdi zmdi-thumb-up"></i>
                                    </div>
                                    <strong>Well done!</strong> Password Updated Successfully.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                            <i class="zmdi zmdi-close"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>';
        echo "<script> document.location ='userlist.php'; </script>";
    }else{
        
        $_SESSION['message'] = "<div class='alert alert-danger'>Password Updation Failed</div>";
        echo "<script> document.location ='userlist.php'; </script>";
    }
}
 ?>


<!-- ============================= Modal Section ============================================== -->

<!-- Add User Modal -->
<div id="adduser" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Add User</h1>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="" id="adduserform">
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="addusername" id="addusername" placeholder="Enter Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email Address</label>
                        <div>
                            <input type="email" class="form-control input-lg" name="adduseremail" id="adduseremail" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <div>
                            <input type="password" class="form-control input-lg" name="adduserpassword" id="adduserpassword" placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Role</label><br>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="adduserrole" value="admin">Admin
                        </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="adduserrole" value="user">User
                          </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="adduserbtn" class="btn btn-success ">ADD User</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit User Modal -->
<div id="editmodal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Edit User</h1>
            </div>
            <div class="modal-body">
                <form role="form" id="edituserform" method="POST" action="">
                    <input type="hidden" name="editid" id="editid">
                    <div class="form-group">
                        <label class="control-label">UserName</label>
                        <div>
                            <input type="text" id="editusername" class="form-control input-lg" name="editusername" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <div>
                            <input type="email" id="editemail" class="form-control input-lg" name="editemail">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="editmodal" class="btn btn-success">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Password Modal -->
<div id="editpasswordmodal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Edit Password</h1>
            </div>
            <div class="modal-body">
                <form role="form" id="edituserform" method="POST" action="">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <div>
                            <input type="password" id="userpassword" class="form-control input-lg" name="userpassword" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="editpassworsmodalbtn" class="btn btn-success">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- ===========================delete modal==================================== -->
<div id="deletemodal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Delete User</h1>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="">
                    <input type="hidden" name="deleteid" id="deleteid">
                    <h4>Do you want to Update status of this User?</h4>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="deletemodalbtn" class="btn btn-success">Yes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <?php include_once('footer.php'); ?>
<!-- =================================jqeury code for edit modal====================================== -->

<script>
    $(document).ready(function() {
        $('.editbtn').on('click',function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {

                return $(this).text();
            }).get();

            console.log(data);
            $('#editid').val(data[0]);
            $('#editusername').val(data[1]);
            $('#editemail').val(data[2]);
        });
    });

</script>
<!-- ============================================================================================ -->

<!-- =================================jqeury code for delete modal====================================== -->

<script>
    $(document).ready(function() {
        $('.statusbtn').on('click',function() {
            $('#deletemodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {

                return $(this).text();
            }).get();

            console.log(data);
            $('#deleteid').val(data[0]);
        });
    });

</script>
<!-- ============================================================================================ -->

<!-- =================================jqeury code for password modal====================================== -->

<script>
    $(document).ready(function() {
        $('.passwordeditbtn').on('click',function() {
            $('#editpasswordmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {

                return $(this).text();
            }).get();

            console.log(data);
            $('#user_id').val(data[0]);
        });
    });

</script>
<!-- ============================================================================================ -->

<script>
    $('#adduserform').validate({
            rules: {
                addusername: 'required',
                adduseremail: 'required',
                adduserpassword:'required',
                adduserrole:'required'
            },
            messages: {
                addusername: 'Username is required',
                adduseremail: 'Email is required',
                adduserpassword: 'Password is required',
                adduserrole: 'Role is required'
            },
       });
</script>

<script>
    $('#edituserform').validate({
            rules: {
                editusername: 'required',
                editemail: 'required',
                editrole:'required',
            },
            messages: {
                editusername: 'Username is required',
                editemail: 'Email is required',
                editrole: 'Role is required'
            },
       });
</script>


</body>
</html>
