<?php include_once('header.php'); ?>


<!-- Main Content -->

<style>
.chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 400px; /* Adjust the height as needed */
}  
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
                    <li class="breadcrumb-item">Events</li>
                    <li class="breadcrumb-item active">Continuous Events</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button><br><br><br>
            </div>
           <div class="container-fluid">  
            <div class="row clearfix">
                <div class="col-lg-12">
                    <button type="button" id="addEventButton" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#addevent">Add Event</button><br><br><br>
                    <div class="card">
                                    <?php
                                        if(isset($_SESSION['message'])){
                                            echo  $_SESSION['message'];
                                            unset($_SESSION['message']);
                                        }
                                        ?>
                                        <div id="message"></div>
                        <div class="body">
                            <h3>Continuous Events</h3>
                            <div class="table-responsive">
                                <table class="table m-b-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Event No</th>
                                            <th>Event Title</th>
                                            <th>Event date</th>
                                            <th>Event start time</th>
                                            <th>Event End Time</th>
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
                                       $event_id = $_GET['event_id'];
                                       $query1 = "SELECT * FROM `event` WHERE `event_id`= '$event_id'";
                                       $result1 = mysqli_query($con, $query1);
                                       $row = mysqli_fetch_array($result1);
                                       $event_title = $row['event_title'];
                                       $query = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type, continues_event.event_no, continues_event.con_event_date, continues_event.con_start_time, continues_event.con_end_time 
                                        FROM `event`
                                        JOIN `create_event` ON event.event_id = create_event.event_id
                                        JOIN `continues_event` ON event.event_id = continues_event.Cevent_id
                                        WHERE create_event.user_id = '$user_id' and event.event_id = '$event_id' AND create_event.operation = 'create_event' LIMIT $start_from_continuous, $num_per_page_continuous");
                                        while($result     = mysqli_fetch_array($query)){
                                        ?>
                                               
                                        <tr>
                                            <td><?php echo $result['event_no'];?></td>
                                            <td><?php echo $result['event_title'];?></td>
                                            <td><?php echo $result['con_event_date'];?></td>
                                            <td><?php echo $result['con_start_time'];?></td>
                                            <td><?php echo $result['con_end_time'];?></td>
                                            <th>
                                                <button type="button" class="btn btn-primary editeventbtn" ><i class="zmdi zmdi-edit" aria-hidden="true"></i> Update</button> |
                                                <a href="attendance_marking.php?event_id=<?php echo $result['event_id'];?>&event_no=<?php echo $result['event_no'];?>&event_type=<?php echo $result['event_type'];?>" class="btn btn-success"><i class="zmdi zmdi-eye" aria-hidden="true"></i> View</a>

                                            </th>
                                        </tr>

                                        <?php

                                        }

                                        ?>
                                        
                                    </tbody>
                                </table>
                                <?php 
                                $query2_continuous = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type, continues_event.event_no, continues_event.con_event_date, continues_event.con_start_time, continues_event.con_end_time 
                                        FROM `event`
                                        JOIN `create_event` ON event.event_id = create_event.event_id
                                        JOIN `continues_event` ON event.event_id = continues_event.Cevent_id
                                        WHERE create_event.user_id = '$user_id' and event.event_id = '$event_id' AND create_event.operation = 'create_event'");
                                $total_records_continuous = mysqli_num_rows($query2_continuous);
                                $total_pages_continuous = ceil($total_records_continuous / $num_per_page_continuous);
                                ?>
                                <div style="padding-left: 30px;">
                                    <?php
                                    if ($page_continuous > 1) {
                                        echo "<a href='continuous_events.php?page_continuous=" . ($page_continuous - 1) . "&event_id=$event_id&user_id=$user_id' class='previous'>&laquo; Previous</a>";
                                    }

                                    for ($i = 1; $i <= $total_pages_continuous; $i++) {
                                        echo "<a href='continuous_events.php?page_continuous=" . $i . "&event_id=$event_id&user_id=$user_id' class='btn btn-secondary'>$i</a>";
                                    }

                                    if ($page_continuous < $total_pages_continuous) {
                                        echo "<a href='continuous_events.php?page_continuous=" . ($page_continuous + 1) . "' class='previous'>Next &raquo;</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="message"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="body">
                            <h3>Join Requests</h3>
                            <div class="table-responsive">
                                <table class="table m-b-0">
                                    <thead class="thead-light">
                                        
                                        <tr>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                       <?php
                                       $event_id = $_GET['event_id'];
                                       $query1 = "SELECT * FROM `event` WHERE `event_id`= '$event_id'";
                                       $result1 = mysqli_query($con, $query1);
                                       $row = mysqli_fetch_array($result1);
                                       $event_title = $row['event_title'];
                                       $query = mysqli_query($con, "SELECT * FROM create_event WHERE event_id = $event_id AND operation = 'pending'");
                                       if (mysqli_num_rows($query)>0) {
                                        while($result     = mysqli_fetch_array($query)){
                                            $user_id = $result['user_id'];
                                            $query2 = "SELECT * FROM `user` WHERE `user_id` = '$user_id'";
                                            $result2 = mysqli_query($con, $query2);
                                            $row2 = mysqli_fetch_array($result2);

                                        ?>        
                                        <tr>
                                            <td><?php echo $row2['user_name'];?></td>
                                            <td><?php echo $result['operation'];?></td>
                                            <th style="text-align: center;">
                                                <button id="joinButton" type="button" class="btn btn-success" data-eventid="<?php echo $event_id; ?>" data-userid="<?php echo $user_id; ?>">Add User</button>
                                                | <button id="deleteButton" type="button" class="btn btn-danger" data-eventid="<?php echo $event_id; ?>" data-userid="<?php echo $user_id; ?>">Delete User</button>

                                            </th> 
                                        </tr>

                                        <?php

                                        }
                                    }
                                    else{
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo"Currently, there are no user requests available";?>
                                           </td>
                                        </tr>
                                        <?php
                                         }

                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="message2"></div>
                    <div id="columnchart_values" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    
</section>


 <!-- =================================php code for add modal====================================== -->

<?php 
include 'assets/php/decode_event_id.php';
if (isset($_POST['add_event_btn'])) {
    $C_user_id = $_GET['user_id']; 
    $event_id = $_GET['event_id'];
    $add_event_date = $_POST['con_event_date'];
    $add_start_time = $_POST['con_event_start_time'];
    $add_end_time = $_POST['con_event_end_time'];
    $query5 = mysqli_query($con, "SELECT MAX(continues_event.event_no) AS max_event_no FROM continues_event JOIN event ON continues_event.Cevent_id = event.event_id WHERE event.event_title = '$event_title'");
    $result5 = mysqli_fetch_assoc($query5);
    $max_event_no = $result5['max_event_no'];
    if ($max_event_no == 0 ) {
        $sql3 = "SELECT count(*) AS count FROM `continues_event` WHERE `Cevent_id` = '$event_id' AND `event_no` = '$max_event_no'";
        $result3= mysqli_query($con, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $count = $row3['count'];
        if ($count==0) {
             $sql = "INSERT INTO `continues_event` (`Cevent_id`, `event_no`, `con_event_date`, `con_start_time`, `con_end_time`) VALUES ('$event_id', '$max_event_no', '$add_event_date', '$add_start_time', '$add_end_time')";
             $query3= mysqli_query($con, $sql);
             $query4 = mysqli_query($con, "INSERT INTO `create_event` (`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$C_user_id', '$event_id', '$max_event_no', 'create_event', '0')");
        }

        else{
            $new_event_no = $max_event_no + 1;
        $query3= mysqli_query($con, "INSERT INTO `continues_event` (`Cevent_id`, `event_no`, `con_event_date`, `con_start_time`, `con_end_time`) VALUES ('$event_id', '$new_event_no', '$add_event_date', '$add_start_time', '$add_end_time')");
        $query4 = mysqli_query($con, "INSERT INTO `create_event` (`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$C_user_id', '$event_id', '$new_event_no', 'create_event', '0')");
    }
        }
    else{
        $new_event_no = $max_event_no + 1;
        $query3= mysqli_query($con, "INSERT INTO `continues_event` (`Cevent_id`, `event_no`, `con_event_date`, `con_start_time`, `con_end_time`) VALUES ('$event_id', '$new_event_no', '$add_event_date', '$add_start_time', '$add_end_time')");
        $query4 = mysqli_query($con, "INSERT INTO `create_event` (`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$C_user_id', '$event_id', '$new_event_no', 'create_event', '0')");
    }

    
     
            if ($query3) {
                // Retrieve all users associated with the previous event
                $query3 = mysqli_query($con, "SELECT user_id FROM create_event WHERE event_id = '$event_id' AND event_no BETWEEN 0 AND '$max_event_no' AND `operation`= 'join'");
    
                 // Insert data for each user into the new event
                 while ($row = mysqli_fetch_assoc($query3)) {
                   $join_user_id = $row['user_id'];
                   $checkQuery = mysqli_query($con, "SELECT * FROM `create_event` WHERE `user_id` = '$join_user_id' AND `event_id` = '$event_id' AND `event_no` = '$new_event_no'");
                   if (mysqli_num_rows($checkQuery) == 0) {
                      $query4 = mysqli_query($con, "INSERT INTO `create_event` (`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$join_user_id', '$event_id', '$new_event_no', 'join', '0')");
                       }
                    }

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
            echo '<script>window.location.href = "continuous_events.php?event_id='.$event_id.'&user_id='.$C_user_id.'";</script>';
            }
        else{
        $_SESSION['message'] = "<div class='alert alert-danger'>Event Addition Failed</div>";
        echo '<script>window.location.href = "continuous_events.php?event_id='.$event_id.'&user_id='.$C_user_id.'";</script>';
         }
}
 ?>
<!-- =========================================================================== -->

<?php 
if (isset($_POST['edit_event_modal_btn'])) {
    $C_user_id = $_GET['user_id']; 
    $event_id = $_GET['event_id'];
    $event_date = $_POST['edit_event_date'];
    $event_start_time = $_POST['edit_start_time'];
    $event_end_time = $_POST['edit_end_time'];
    $query3= mysqli_query($con, "UPDATE `continues_event` SET con_event_date = '$event_date', con_start_time = '$event_start_time', con_end_time = '$event_end_time' WHERE `Cevent_id` ='$event_id'");
    if ($query3){   
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
            echo '<script>window.location.href = "continuous_events.php?event_id='.$event_id.'&user_id='.$C_user_id.'";</script>';
        } 

    else{
        
        $_SESSION['message'] = "<div class='alert alert-danger'>Event Data Updation Failed</div>";
        echo '<script>window.location.href = "continuous_events.php?event_id='.$event_id.'&user_id='.$C_user_id.'";</script>';
    }
}
 ?>

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
                    <input type="hidden" name="user_id_input" id="user_id_input">
                    <div class="form-group">
                        <label class="control-label">Event Title</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="join_event_id" id="join_event_id" placeholder="Enter Event Title" value="<?php echo $event_title; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event Date</label>
                        <div>
                            <input type="date" class="form-control input-lg" name="con_event_date" id="con_event_date" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event Start Time</label>
                        <div>
                            <input type="time" class="form-control input-lg" name="con_event_start_time" id="con_event_start_time" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event End Time</label>
                        <div>
                            <input type="time" class="form-control input-lg" name="con_event_end_time" id="con_event_end_time" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="add_event_btn" class="btn btn-success ">Add Event</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="editeventmodal" class="modal fade">
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
                          <input type="text" id="edit_event_title" class="form-control input-lg" name="edit_event_title" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Event date</label>
                        <div>
                            <input type="date" id="edit_event_date" class="form-control input-lg" name="edit_event_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Start Time</label>
                        <div>
                            <input type="time" id="edit_start_time" class="form-control input-lg" name="edit_start_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">End Time</label>
                        <div>
                            <input type="time" id="edit_end_time" class="form-control input-lg" name="edit_end_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" name="edit_event_modal_btn" class="btn btn-success">Save Changes</button>
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
    $(document).ready(function() {
        $('#addEventButton').click(function() {
            var userId = '<?php echo $user_id; ?>';
            $('#user_id_input').val(userId);
        });
    });
</script>


<script>
    $('#addeventform').validate({
            rules: {
                con_event_date: 'required',
                con_event_start_time: 'required',
                con_event_end_time: 'required',
            },
            messages: {
                con_event_date: 'Event data is required',
                con_event_start_time: 'Event start time is required',
                con_event_end_time: 'Event end time is required',
            },
       });
</script>

<script>
    $(document).ready(function() {
        $('.editeventbtn').on('click',function() {
            $('#editeventmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {

                return $(this).text();
            }).get();

            console.log(data);
            $('#edit_event_id').val(data[0]);
            $('#edit_event_title').val(data[1]);
            $('#edit_event_date').val(data[2]);
            $('#edit_start_time').val(data[3]);
            $('#edit_end_time').val(data[4]);
        });
    });

</script>
<script>
$(document).on('click', '#joinButton', function() {
    console.log('Clicked the join button'); // add this line
    
    var event_id = $(this).data('eventid');
    var user_id = $(this).data('userid');
    var row = $(this).closest('tr');
    
    $.ajax({
        url: 'join_requests.php',
        type: 'POST',
        data: {accept: true, event_id: event_id, user_id: user_id},
        dataType: 'json',
        success: function(response) {
            if(response.status == 'success') {
                // If the server returns a success message, remove the row from the table and display a message
                row.fadeOut(500, function() {
                    $(this).remove();
                });
                $('.message').html('<div class="alert alert-success">' + response.message + '</div>').fadeIn(500).delay(2000).fadeOut(500);
            } else {
                // If the server returns an error message, display the message
                $('.message').html('<div class="alert alert-danger">' + response.message + '</div>').fadeIn(500).delay(2000).fadeOut(500);
            }
        },
        error: function() {
            // If there's an error with the AJAX request, display an error message
            $('.message').html('<div class="alert alert-danger">Error communicating with server.</div>').fadeIn(500).delay(2000).fadeOut(500);
        }
    });
});
</script>

<script>
    $(document).on('click', '#deleteButton', function() {
    console.log('Clicked the delete button'); // add this line
    
    var event_id = $(this).data('eventid');
    var user_id = $(this).data('userid');
    var row = $(this).closest('tr');
    
    $.ajax({
        url: 'join_requests.php',
        type: 'POST',
        data: {reject: true, event_id: event_id, user_id: user_id},
        dataType: 'json',
        success: function(response) {
            if(response.status == 'success') {
                // If the server returns a success message, remove the row from the table and display a message
                row.fadeOut(500, function() {
                    $(this).remove();
                });
                $('.message').html('<div class="alert alert-success">' + response.message + '</div>').fadeIn(500).delay(2000).fadeOut(500);
            } else {
                // If the server returns an error message, display the message
                $('.message').html('<div class="alert alert-danger">' + response.message + '</div>').fadeIn(500).delay(2000).fadeOut(500);
            }
        },
        error: function() {
            // If there's an error with the AJAX request, display an error message
            $('.message').html('<div class="alert alert-danger">Error communicating with server.</div>').fadeIn(500).delay(2000).fadeOut(500);
        }
    });
});
</script>

<script type="text/javascript">
   var event_id = $(this).data('eventid');
   var user_id = $(this).data('userid');

$.ajax({
  url: 'join_requests.php?chart=true&event_id=<?= $_GET['event_id']; ?>&user_id=<?= $user_id; ?>',
  type: 'GET',
  //data: {chart: true, event_id: event_id, user_id: user_id},
  dataType: 'json',
  success: function(response) {
    if (response.status == 'success') {
      var users = response.data; // Array of users from the response

// Prepare data for the chart
var chartData = [['Event Date', 'Total Present', 'Total Absent']];
$.each(users, function(index, user) {
  var eventData = [user.event_date, parseInt(user.total_present), parseInt(user.total_absent)];
  chartData.push(eventData);
});

// Create and draw the chart
google.charts.load('current', {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable(chartData);

  var options = {
    title: 'Attendance per date',
    width: 1000,
    height: 400,
    legend: {position: 'top'},
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values'));
  chart.draw(data, options);
}
    } else {
      // If the server returns an error message, display the message
      $('.message2').html('<div class="alert alert-danger">' + response.message + '</div>').fadeIn(500).delay(2000).fadeOut(500);
    }
  },
  error: function(xhr, status, error) {
    $('.message2').html('<div class="alert alert-danger">Error communicating with the server.</div>').fadeIn(500).delay(2000).fadeOut(500);
  }
});

</script>

<script>
    // Get the current date
    var currentDate = new Date().toISOString().split("T")[0];
    
    // Set the value of the date input field
    document.getElementById("con_event_date").value = currentDate;

    var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Split the time into hours and minutes
    var hours = currentTime.slice(0, 2);
    var minutes = currentTime.slice(3, 5);

    // Set the default value of the input field to the current time
    document.getElementById('con_event_start_time').value = hours + ':' + minutes;
</script>

