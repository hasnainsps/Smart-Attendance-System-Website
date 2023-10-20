
<?php include_once('header.php'); ?>

<!-- Main Content -->

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
                <h2>Events</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="zmdi zmdi-home"></i> Smart Attendance</a></li>
                    <li class="breadcrumb-item active">Events</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button><br><br><br>
            </div>
           <div class="container-fluid">  
            <div class="row clearfix">
                <div class="col-lg-12">
                    <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#addevent">Add Event</button><br><br><br>
                    <div class="card">
                        <?php
                        if(isset($_SESSION['message'])){
                            echo  $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>
                        <div class="body">
                            <h3>Continuous Events</h3>
                            <div class="table-responsive">
                                <table class="table m-b-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Event Title</th>
                                            <th>Event ID</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['page_continuous'])) {
                                            $page_continuous = $_GET['page_continuous'];
                                        } else {
                                            $page_continuous = 1;
                                        }
                                        $num_per_page_continuous = 10;
                                        $start_from_continuous = ($page_continuous - 1) * $num_per_page_continuous;

                                        $query_continuous = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type, event.encrypt_event_id, create_event.operation, create_event.user_id
                                            FROM `event`
                                            JOIN `create_event` ON event.event_id = create_event.event_id
                                            WHERE create_event.user_id = '$user_id' AND create_event.operation= 'create_event' AND event.event_type= 'continues'
                                            LIMIT $start_from_continuous, $num_per_page_continuous");
                                        while ($result_continuous = mysqli_fetch_array($query_continuous)) {
                                            ?>
                                            <tr data-event-id="<?php echo $result_continuous['event_id']; ?>">
                                                <td><?php echo $result_continuous['event_title']; ?></td>
                                                <td><?php echo $result_continuous['encrypt_event_id']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary edit_con_event"><i class="zmdi zmdi-edit" aria-hidden="true"></i> Update</button> |
                                                    <a href="continuous_events.php?event_id=<?php echo $result_continuous['event_id']; ?>&user_id=<?php echo $result_continuous['user_id']; ?>" class="btn btn-success"><i class="zmdi zmdi-eye" aria-hidden="true"></i> View</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php 
                                $query2_continuous = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type, event.encrypt_event_id, create_event.operation, create_event.user_id
                                    FROM `event`
                                    JOIN `create_event` ON event.event_id = create_event.event_id
                                    WHERE create_event.user_id = '$user_id' AND create_event.operation= 'create_event' AND event.event_type= 'continues'");
                                $total_records_continuous = mysqli_num_rows($query2_continuous);
                                $total_pages_continuous = ceil($total_records_continuous / $num_per_page_continuous);
                                ?>
                                <div style="padding-left: 30px;">
                                    <?php
                                    if ($page_continuous > 1) {
                                        echo "<a href='eventlist.php?page_continuous=" . ($page_continuous - 1) . "' class='previous'>&laquo; Previous</a>";
                                    }

                                    for ($i = 1; $i <= $total_pages_continuous; $i++) {
                                        echo "<a href='eventlist.php?page_continuous=" . $i . "' class='btn btn-secondary'>$i</a>";
                                    }

                                    if ($page_continuous < $total_pages_continuous) {
                                        echo "<a href='eventlist.php?page_continuous=" . ($page_continuous + 1) . "' class='previous'>Next &raquo;</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="body">
                            <h3>One Time Events</h3>
                            <div class="table-responsive">
                                <table class="table m-b-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Event Title</th>
                                            <th>Event Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['page_one_time'])) {
                                            $page_one_time = $_GET['page_one_time'];
                                        } else {
                                            $page_one_time = 1;
                                        }
                                        $num_per_page_one_time = 10;
                                        $start_from_one_time = ($page_one_time - 1) * $num_per_page_one_time;

                                        $query_one_time = mysqli_query($con, "SELECT event.event_id, event.event_title, event.event_type, one_time_event.one_start_time, one_time_event.one_end_time, one_time_event.one_event_date, create_event.operation
                                            FROM `event`
                                            JOIN `one_time_event` ON event.event_id = one_time_event.OTevent_id
                                            JOIN `create_event` ON event.event_id = create_event.event_id
                                            WHERE create_event.user_id = '$user_id' AND create_event.operation= 'create_event'
                                            LIMIT $start_from_one_time, $num_per_page_one_time");
                                        while ($result_one_time = mysqli_fetch_array($query_one_time)) {
                                            ?>
                                            <tr data-event-id="<?php echo $result_one_time['event_id']; ?>">
                                                <td><?php echo $result_one_time['event_title']; ?></td>
                                                <td><?php echo $result_one_time['one_event_date']; ?></td>
                                                <td><?php echo $result_one_time['one_start_time']; ?></td>
                                                <td><?php echo $result_one_time['one_end_time']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary edit_one_event"><i class="zmdi zmdi-edit" aria-hidden="true"></i> Update</button> |
                                                    <a href="attendance_marking.php?event_id=<?php echo $result_one_time['event_id']; ?>&event_type=<?php echo $result_one_time['event_type']; ?>" class="btn btn-success"><i class="zmdi zmdi-eye" aria-hidden="true"></i> View</a> |
                                                    <button type="button" class="btn btn-secondary fieldbtn" data-toggle="modal" data-target="#fieldmodal" data-eventid="<?php echo $result_one_time['event_id']; ?>"><i class="zmdi zmdi-check" aria-hidden="true"></i> Fields</button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php 
                                $query2_one_time = mysqli_query($con, "SELECT event.event_id, event.event_title, event.event_type, one_time_event.one_start_time, one_time_event.one_end_time, one_time_event.one_event_date, create_event.operation
                                    FROM `event`
                                    JOIN `one_time_event` ON event.event_id = one_time_event.OTevent_id
                                    JOIN `create_event` ON event.event_id = create_event.event_id
                                    WHERE create_event.user_id = '$user_id' AND create_event.operation= 'create_event'");
                                $total_records_one_time = mysqli_num_rows($query2_one_time);
                                $total_pages_one_time = ceil($total_records_one_time / $num_per_page_one_time);
                                ?>
                                <div style="padding-left: 30px;">
                                    <?php
                                    if ($page_one_time > 1) {
                                        echo "<a href='eventlist.php?page_one_time=" . ($page_one_time - 1) . "' class='previous'>&laquo; Previous</a>";
                                    }

                                    for ($i = 1; $i <= $total_pages_one_time; $i++) {
                                        echo "<a href='eventlist.php?page_one_time=" . $i . "' class='btn btn-secondary'>$i</a>";
                                    }

                                    if ($page_one_time < $total_pages_one_time) {
                                        echo "<a href='eventlist.php?page_one_time=" . ($page_one_time + 1) . "' class='previous'>Next &raquo;</a>";
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
</div>
    
</section>

 <!-- =================================php code for add modal====================================== -->

<?php 
include 'assets/php/encrypt_event_id.php';
if (isset($_POST['add_event_btn'])) {
    $add_event_title = $_POST['add_event_title'];
    $add_event_type = $_POST['add_event'];
     
    if ($add_event_type == 'one_time') {
       $query1= mysqli_query($con, "INSERT INTO event (event_title, event_type) VALUES ('$add_event_title', '$add_event_type')");
        $event_id = mysqli_insert_id($con); // get the last inserted event_id
        $encrypted_id = convert_value_to_string($event_id);
        $query2 = mysqli_query($con, "UPDATE event SET encrypt_event_id = '$encrypted_id' WHERE event_id = '$event_id'");
        $add_event_date = $_POST['add_one_event_date'];
        $add_start_time = $_POST['add_one_start_time'];
        $add_end_time = $_POST['add_one_end_time'];
        $sql = "INSERT INTO one_time_event (OTevent_id, one_event_date, one_start_time, one_end_time) VALUES ('$event_id', '$add_event_date', '$add_start_time', '$add_end_time')";
        $query2= mysqli_query($con, $sql);
        $query4 = "INSERT INTO `create_event`(`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$user_id', '$event_id', '0', 'create_event', '0') "; 
        $result4= mysqli_query($con, $query4);
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
        <div class="container">
        <div class="alert-icon">
        <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>Well done!</strong> Event Added Successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">
        <i class="zmdi zmdi-close"></i>
        </span>
        </button>
        </div>
        </div>';
        echo "<script> document.location ='eventlist.php'; </script>";

    }
    else {
          $check_query = mysqli_query($con, "SELECT COUNT(*) AS count FROM event
           JOIN `create_event` ON event.event_id = create_event.event_id
           WHERE event.event_title = '$add_event_title' AND event.event_type = 'continues' AND create_event.user_id = '$user_id'
           AND create_event.operation = 'create_event'");
        $result9 = mysqli_fetch_assoc($check_query);
        $count = $result9['count'];
        
        if ($count > 0){
         $query7 = mysqli_query($con, "SELECT event.event_id
          FROM event
          JOIN create_event ON event.event_id = create_event.event_id
          WHERE event_title = '$add_event_title' AND create_event.user_id = '$user_id'");
         $row = mysqli_fetch_assoc($query7); 
         $event_id = $row['event_id'];
         $_SESSION['message'] = '<div class="alert alert-info" role="alert">
         <div class="container">
         <div class="alert-icon">
         <i class="zmdi zmdi-alert-circle-o"></i>
         </div>
         <strong>Heads up!</strong> This continuoues Event is already exists .
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">
         <i class="zmdi zmdi-close"></i>
         </span>
         </button>
         </div>
         </div>';
       echo '<script>window.location.href = "continuous_events.php?event_id='.$event_id.'&user_id='.$user_id.'id";</script>';
     }
     else{
       $query1= mysqli_query($con, "INSERT INTO event (event_title, event_type) VALUES ('$add_event_title', '$add_event_type')");
        $event_id = mysqli_insert_id($con); // get the last inserted event_id
        $encrypted_id = convert_value_to_string($event_id);
        $query2 = mysqli_query($con, "UPDATE event SET encrypt_event_id = '$encrypted_id' WHERE event_id = '$event_id'");
        /*$query4 = "INSERT INTO `create_event`(`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$user_id', '$event_id', '0', 'create_event', '0') ";
        $result4= mysqli_query($con, $query4);*/ 
        $_SESSION['message'] = '<div class="alert alert-success" role="alert">
        <div class="container">
        <div class="alert-icon">
        <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>Well done!</strong> Event Added Successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">
        <i class="zmdi zmdi-close"></i>
        </span>
        </button>
        </div>
        </div>';
        echo '<script>window.location.href = "continuous_events.php?event_id='.$event_id.'&user_id='.$user_id.'";</script>';
    }


}    

}  
?>
<!-- =========================================================================== -->
<!-- =================================php code for edit modal====================================== -->
<?php 
if (isset($_POST['edit_con_event_modal_btn'])) {
    $event_id = $_POST['edit_event_id'];
    $event_title = $_POST['edit_event_title'];
    $query2= mysqli_query($con, "UPDATE `event` SET `event_title` = '$event_title' WHERE `event_id` ='$event_id' ");
    if ($query2) {
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
            <div class="container">
            <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
            </div>
            <strong>Well done!</strong> Event Updated Successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
            <i class="zmdi zmdi-close"></i>
            </span>
            </button>
            </div>
            </div>';
            echo "<script> document.location ='eventlist.php'; </script>";
        }        
    else{
        
        $_SESSION['message'] = "<div class='alert alert-danger'>Event Data Updation Failed</div>";
        echo "<script> document.location ='eventlist.php'; </script>";
    }
}
 ?>

 <!-- this code is for one time event -->
 <?php 
if (isset($_POST['edit_one_event_modal_btn'])) {
    $event_id = $_POST['edit_one_event_id'];
    $event_title = $_POST['edit_one_event_title'];
    $event_date = $_POST['edit_event_date'];
    $event_start_time = $_POST['edit_event_start_time'];
    $event_end_time = $_POST['edit_event_end_time'];
    /*echo $event_id;
    echo $event_title;
    echo $event_date;
    echo $event_start_time;
    echo $event_end_time;
*/
    $query2= mysqli_query($con, "UPDATE `event` SET `event_title` = '$event_title' WHERE `event_id` ='$event_id' ");
    $query3= mysqli_query($con, "UPDATE `one_time_event` SET `one_event_date` = '$event_date', `one_start_time` = '$event_start_time', `one_end_time` = '$event_end_time' WHERE `OTevent_id` ='$event_id' ");
    if ($query2 && $query3) {
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
            <div class="container">
            <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
            </div>
            <strong>Well done!</strong> Event Updated Successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
            <i class="zmdi zmdi-close"></i>
            </span>
            </button>
            </div>
            </div>';
            echo "<script> document.location ='eventlist.php'; </script>";
        }        
    else{
        
        $_SESSION['message'] = "<div class='alert alert-danger'>Event Data Updation Failed</div>";
        echo "<script> document.location ='eventlist.php'; </script>";
    }
}
 ?>

<!-- =============================php code for delete modal ============================================== -->
<?php 
if (isset($_POST['fieldsmodalbtn'])) {
    $f_event_id = $_POST['event_id_input'];
    $dynamicFields = $_POST['dynamicField'];
    foreach ($dynamicFields as $fieldName) {
        $fieldName = mysqli_real_escape_string($con, $fieldName);
        $query = "INSERT INTO `field_name` (`F_event_id`, `fields_name`) VALUES ('$f_event_id', '$fieldName')";
        mysqli_query($con, $query);
    }
            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
            <div class="container">
            <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
            </div>
            <strong>Well done!</strong> Fields Added Successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
            <i class="zmdi zmdi-close"></i>
            </span>
            </button>
            </div>
            </div>';
            echo "<script> document.location ='eventlist.php'; </script>";
        }
?>

<!-- =================================php code for edit password modal====================================== -->



<!-- ============================= Modal Section ============================================== -->

<!-- Add Event Modal -->
<div id="addevent" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Add Event</h1>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="" id="addeventform">
                    <div class="form-group">
                        <label class="control-label">Event Title</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="add_event_title" id="add_event_title" placeholder="Enter Event Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event Type</label><br>
                        <label class="radio-inline"style="margin-right: 30px;">
                        <input type="radio" name="add_event" value="one_time" id="add_one_time_event"> One Time Event
                        </label>
                        <label class="radio-inline">
                        <input type="radio" name="add_event" value="continues" id="add_continues_event"> Continues Event
                        </label>
                        <div id="oneTimeDetails" style="display: none;">
                           <div class="form-group">
                                <label class="control-label">Event Date</label>
                                <div>
                                  <input type="date" class="form-control input-lg" name="add_one_event_date" id="add_one_event_date" placeholder="">
                                </div>
                           </div>
                           <div class="form-group">
                                <label class="control-label">Start Time</label>
                                <div>
                                  <input type="time" class="form-control input-lg" name="add_one_start_time" id="add_one_start_time" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">End time</label>
                                <div>
                                  <input type="time" class="form-control input-lg" name="add_one_end_time" id="add_one_end_time" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div id="continuesDetails" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="add_event_btn" class="btn btn-success ">ADD Event</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit User Modal -->
<div id="edit_con_event_modal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Edit Event</h1>
            </div>
            <div class="modal-body">
                <form role="form" id="editeventform" method="POST" action="">
                    <input type="hidden" name="edit_event_id" id="edit_event_id">
                    <div class="form-group">
                        <label class="control-label">Event Title</label>
                        <div>
                          <input type="text" id="edit_event_title" class="form-control input-lg" name="edit_event_title" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="edit_con_event_modal_btn" class="btn btn-success">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="edit_one_event_modal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Edit Event</h1>
            </div>
            <div class="modal-body">
                <form role="form" id="editeventform" method="POST" action="">
                    <input type="hidden" name="edit_one_event_id" id="edit_one_event_id">
                    <div class="form-group">
                        <label class="control-label">Event Title</label>
                        <div>
                          <input type="text" id="edit_one_event_title" class="form-control input-lg" name="edit_one_event_title" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event Date</label>
                        <div>
                          <input type="date" id="edit_event_date" class="form-control input-lg" name="edit_event_date" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event Start Time</label>
                        <div>
                          <input type="time" id="edit_event_start_time" class="form-control input-lg" name="edit_event_start_time" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event End Time</label>
                        <div>
                          <input type="time" id="edit_event_end_time" class="form-control input-lg" name="edit_event_end_time" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="edit_one_event_modal_btn" class="btn btn-success">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Selection of fields Modal -->
<div id="fieldmodal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">How many fields do you want in Form</h3>
            </div>
            <div class="modal-body">
                <form role="form" id="edituserform" method="POST" action="">
                    <input type="hidden" name="event_id_input" id="event_id_input">
                    
                    <div id="dynamicFields" class="form-group">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="dynamicField[]" placeholder="Enter field">
                            <div class="input-group-append">
                                <button class="btn btn-danger removeFieldButton" type="button"><i class="zmdi zmdi-close"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-success addFieldButton"><i class="zmdi zmdi-plus"></i> Add Field</button>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="fieldsmodalbtn" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


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
       $('.edit_con_event').on('click', function() {
        var $tr = $(this).closest('tr');
        var eventTitle = $tr.find('td:eq(0)').text();
        var eventId = $tr.data('event-id'); // Retrieve the "Event ID" from the data attribute

        $('#edit_event_title').val(eventTitle);
        $('#edit_event_id').val(eventId);
        $('#edit_con_event_modal').modal('show');
    });
    });

</script>

<script>
    $(document).ready(function() {
        $('.edit_one_event').on('click', function() {
        var $tr = $(this).closest('tr');
        var eventTitle = $tr.find('td:eq(0)').text();
        var eventDate = $tr.find('td:eq(1)').text();
        var eventStartTime = $tr.find('td:eq(2)').text();
        var eventEndTime = $tr.find('td:eq(3)').text();
        var eventId = $tr.data('event-id'); // Retrieve the "Event ID" from the data attribute

        $('#edit_one_event_title').val(eventTitle);
        $('#edit_event_date').val(eventDate);
        $('#edit_event_start_time').val(eventStartTime);
        $('#edit_event_end_time').val(eventEndTime);
        $('#edit_one_event_id').val(eventId);
        $('#edit_one_event_modal').modal('show');
    });
            });

</script>
<!-- ============================================================================================ -->

<script>
  // When the "One Time Event" radio button is selected
  $('#add_one_time_event').click(function() {
    // Show the One Time event details and hide the Continues event details
    $('#oneTimeDetails').show();
    $('#continuesDetails').hide();
  });

  // When the "Continues Event" radio button is selected
  $('#add_continues_event').click(function() {
    // Show the Continues event details and hide the One Time event details
    $('#oneTimeDetails').hide();
    $('#continuesDetails').show();
  });
</script>

<!-- =================================jqeury code for delete modal====================================== -->

<!-- <script>
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

</script> -->
<!-- ============================================================================================ -->

<!-- =================================jqeury code for password modal====================================== -->

<!-- <script>
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

</script> -->
<!-- ============================================================================================ -->

<script>
    $('#addeventform').validate({
            rules: {
                add_event_title: 'required',
                add_one_event_date: 'required',
                add_one_start_time : 'required',
                add_one_end_time : 'required',
                add_event_number:'required',
                add_event_date:'required',
                add_start_time:'required',
                add_end_time:'required',
            },
            messages: {
                add_event_title: 'Event Title is required',
                add_one_event_date: 'Date is required',
                add_one_start_time: 'Start time is required',
                add_one_end_time: 'End time is required',
                add_event_number: 'Event No is required',
                add_event_date: 'Event Date is required',
                add_start_time: 'start time is required',
                add_end_time: 'End time is required',
            },
       });
</script>

<script>
    $('#editeventform').validate({
            rules: {
                edit_event_title: 'required',
                edit_event_date: 'required',
                edit_start_time: 'required',
                edit_end_time: 'required',
            },
            messages: {
                edit_event_title: 'Event Title is required',
                edit_event_date: 'Event Date is required',
                edit_start_time: 'Event Start Time is required',
                edit_end_time: 'Event End Time is required',
            },
       });
</script>

<script>
    // Get the current date
    var currentDate = new Date().toISOString().split("T")[0];
    
    // Set the value of the date input field
    document.getElementById("add_one_event_date").value = currentDate;

    var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Split the time into hours and minutes
    var hours = currentTime.slice(0, 2);
    var minutes = currentTime.slice(3, 5);

    // Set the default value of the input field to the current time
    document.getElementById('add_one_start_time').value = hours + ':' + minutes;
</script>

<script>
 $(document).ready(function() {
    var fieldIndex = 1;

    $('.addFieldButton').click(function() {
        var newField = $('<div class="input-group mb-2">' +
            '<input type="text" class="form-control" name="dynamicField[]" placeholder="Enter field">' +
            '<div class="input-group-append">' +
            '<button class="btn btn-danger removeFieldButton" type="button"><i class="zmdi zmdi-close"></i></button>' +
            '</div>' +
            '</div>');
        $('#dynamicFields').append(newField);
        fieldIndex++;
    });

    $(document).on('click', '.removeFieldButton', function() {
        $(this).closest('.input-group').remove();
    });

     $('.fieldbtn').click(function() {
    var event_id = $(this).data('eventid');
    $('#event_id_input').val(event_id);
  });
});




</script>
