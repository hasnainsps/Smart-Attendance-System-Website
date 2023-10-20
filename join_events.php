<?php include_once('header.php'); ?>

<!-- Main Content -->

<style>
    
    .pending {
 color: white;
 display: inline-block;
  padding: 10px 20px;
  background-color: red;
  border: 1px solid;
  border-radius: 8px;
  text-align: center;
  cursor: pointer;
  }
   .join {
 color: white;
 display: inline-block;
  padding: 10px 20px;
  background-color: #04be5b;
  border: 1px solid;
  border-radius: 8px;
  text-align: center;
  cursor: pointer;
  }
</style>
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Events</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Smart Attendance</a></li>
                    <li class="breadcrumb-item active">Join Events</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
           <div class="container-fluid">  
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                                    <?php
                                        if(isset($_SESSION['message'])){
                                            echo  $_SESSION['message'];
                                            unset($_SESSION['message']);
                                        }
                                        ?>
                        <div class="body">
                            <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#addevent">Join Event</button>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <h3>Join Events</h3>
                                        <tr>
                                            
                                            <th>Event Title</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                       <?php
                                        $query = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title,
                                                                     create_event.operation
                                                                    FROM event
                                                                    JOIN create_event ON event.event_id = create_event.event_id WHERE create_event.user_id = $user_id and create_event.operation IN ('pending', 'join') GROUP BY event.event_id");
                                        while($result     = mysqli_fetch_array($query)){
                                        ?>
                                               
                                        <tr>
                                            
                                            <td><?php echo $result['event_title'];?></td>
                                            <td style="padding-left: 10px; padding-top: 15px;">
                                                <?php if ($result['operation'] == 'pending'): ?>
                                                    <span class="pending" style="display: inline-block; padding: 5px 10px; border: 2px solid; border-radius: 5px;">Pending</span>
                                                <?php elseif ($result['operation'] == 'join'): ?>
                                                    <span class="join" style="display: inline-block; padding: 5px 10px; border: 2px solid; border-radius: 5px;">Join</span>
                                                <?php endif; ?>
                                            </td>
                                            <!-- <th>
                                                <a href="attendance_marking.php?event_id=" class="btn btn-success"><i class="zmdi zmdi-eye" aria-hidden="true"></i> View</a>

                                            </th> -->
                                        </tr>

                                        <?php

                                        }

                                        ?>
                                        
                                    </tbody>
                                </table>
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
include 'assets/php/decode_event_id.php';
if (isset($_POST['join_event_btn'])) {
    $join_event_id = $_POST['join_event_id'];
    $query1= "SELECT * FROM `event` WHERE `encrypt_event_id` = '$join_event_id' AND `event_type` = 'continues'";   
    $result1 = mysqli_query($con, $query1);
    $row = mysqli_fetch_assoc($result1);
    $num_rows1 = mysqli_num_rows($result1);
    if ($num_rows1 > 0) {
        $event_id = decode_string_to_value($join_event_id);
        $checkquery = "SELECT * FROM `create_event` WHERE `user_id` = '$user_id' AND `event_id` = '$event_id'";
        $result2 = mysqli_query($con, $checkquery);
        $row2 = mysqli_fetch_assoc($result2);
        $num_rows = mysqli_num_rows($result2); 
        if ($num_rows > 0) {
            $_SESSION['message'] = '<div class="alert alert-info" role="alert">
         <div class="container">
         <div class="alert-icon">
         <i class="zmdi zmdi-alert-circle-o"></i>
         </div>
         <strong>Heads up!</strong> Request sent already in this event .
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">
         <i class="zmdi zmdi-close"></i>
         </span>
         </button>
         </div>
         </div>';
            echo "<script> document.location ='join_events.php'; </script>";
        }
        else{
        $operation = 'pending'; 
        $sql = "SELECT MAX(event_no) AS max_event_no FROM `create_event` WHERE `event_id` = '$event_id'";
        $result = mysqli_query($con, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $max_event_no = $row['max_event_no'];
          
        $query3 = "INSERT INTO `create_event` (`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$user_id', '$event_id', '$max_event_no', '$operation', '0')";
        $result3= mysqli_query($con, $query3);
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
        <div class="container">
        <div class="alert-icon">
        <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>Well done!</strong> Request send successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">
        <i class="zmdi zmdi-close"></i>
        </span>
        </button>
        </div>
        </div>';
            echo "<script> document.location ='join_events.php'; </script>";
         }
        }
        }          
   else{
        $_SESSION['message'] = "<div class='alert alert-danger'>Event Joining Failed</div>";
        echo "<script> document.location ='join_events.php'; </script>";
    }
}
 ?>
<!-- =========================================================================== -->

<!-- ============================= Modal Section ============================================== -->

<!-- Add Event Modal -->
<div id="addevent" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Join Event</h1>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="" id="joineventform">
                    <div class="form-group">
                        <label class="control-label">Put Event Unique Id</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="join_event_id" id="join_event_id" placeholder="Enter Event Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="join_event_btn" class="btn btn-success ">Join Event</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



  <?php include_once('footer.php'); ?>


<script>
    $('#joineventform').validate({
            rules: {
                join_event_id: 'required',
            },
            messages: {
                join_event_id: 'Event ID is required',
            },
       });
</script>
