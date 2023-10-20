
<?php include_once('header.php'); ?>

<!-- Main Content -->

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Dashboard</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="zmdi zmdi-home"></i> Smart Attendance</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <?php 

    $sql = mysqli_query($con, "SELECT COUNT(*) AS count FROM event
     JOIN `create_event` ON event.event_id = create_event.event_id
     WHERE event.event_type = 'continues' AND create_event.user_id = '$user_id'
     AND create_event.operation = 'create_event'");
    $result = mysqli_fetch_assoc($sql);
    $count = $result['count'];
    ?>

    <div class="container-fluid">
        <div class="row clearfix">

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body xl-blue">
                        <h4 class="m-t-0 m-b-0"><?php echo $count; ?></h4>
                        <p class="m-b-0">Continuous <br> Events</p>
                        <div class="button-container">
                            <a href="eventlist.php" class="btn btn-info btn-sm">More Info <i class="zmdi zmdi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div> 

            <?php 

            $sql = mysqli_query($con, "SELECT COUNT(*) AS count FROM event
               JOIN `create_event` ON event.event_id = create_event.event_id
               WHERE event.event_type = 'one_time' AND create_event.user_id = '$user_id'
               AND create_event.operation = 'create_event'");
            $result = mysqli_fetch_assoc($sql);
            $count = $result['count'];
            ?>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body xl-purple">
                        <h4 class="m-t-0 m-b-0"><?php echo $count; ?></h4>
                        <p class="m-b-0">One Time <br> Events</p>
                        <div class="button-container">
                            <a href="eventlist.php" class="btn btn-info btn-sm">More Info <i class="zmdi zmdi-arrow-right"></i></a>
                        </div>
                    </div>                        
                </div>
            </div>
            
            <?php  

            $sql = mysqli_query($con, "SELECT COUNT(DISTINCT user_id) AS count
                FROM `create_event`
                WHERE event_id IN (
                    SELECT event_id
                    FROM `create_event`
                    WHERE user_id = '$user_id' AND operation = 'create_event'
                ) AND operation = 'join'");
            $result = mysqli_fetch_assoc($sql);
            $email_count = $result['count'];

            ?>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body xl-green">
                        <h4 class="m-t-0 m-b-0"><?php echo $email_count; ?></h4>
                        <p class="m-b-0">Registered <br> Users</p>
                        <div class="button-container">
                            <a href="userlist.php" class="btn btn-info btn-sm">More Info <i class="zmdi zmdi-arrow-right"></i></a>
                        </div>
                    </div>                        
                </div>
            </div>

            <?php  

            $sql = mysqli_query($con, "SELECT COUNT(DISTINCT user_id) AS count
                FROM `create_event`
                WHERE event_id IN (
                    SELECT event_id
                    FROM `create_event`
                    WHERE user_id = '$user_id' AND operation = 'create_event'
                ) AND operation = 'pending'");
            $result = mysqli_fetch_assoc($sql);
            $pending_count = $result['count'];

            ?>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body xl-pink">
                        <h4 class="m-t-0 m-b-0"><?php echo $pending_count; ?></h4>
                        <p class="m-b-0">Pending <br> Requests</p>
                        <div class="button-container">
                            <a href="eventlist.php" class="btn btn-info btn-sm">More Info <i class="zmdi zmdi-arrow-right"></i></a>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>

        <?php  
        $query = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type,create_event.operation,create_event.user_id
            FROM `event`
            JOIN `create_event` ON event.event_id = create_event.event_id
            WHERE create_event.user_id = '$user_id' AND create_event.operation= 'create_event' AND event.event_type= 'continues'
            ");
        $counter = 1;
         ?>

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                    <h2><strong><i class="zmdi zmdi-chart"></i> Create</strong> Events</h2>
                    <ul class="header-dropdown">
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                   </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table m-b-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">S.NO</th>
                                        <th scope="col">Event Title</th>
                                        <th scope="col">NO Of Registered Students</th>
                                        <th scope="col">Total Event Attendance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($result= mysqli_fetch_array($query)){
                                        $C_event_id = $result['event_id'];
                                        $sql1 = "SELECT COUNT(DISTINCT user_id) AS count FROM `create_event` WHERE `event_id` = '$C_event_id' AND `operation` = 'join'";
                                        $sql1result = mysqli_query($con, $sql1);
                                        $row1= mysqli_fetch_assoc($sql1result);
                                        $sql2 = "SELECT COUNT(event_no) AS no_count FROM `create_event` WHERE `event_id` = '$C_event_id' AND `operation` = 'create_event'";
                                        $sql2result = mysqli_query($con, $sql2);
                                        $row2= mysqli_fetch_assoc($sql2result);
                                     ?>
                                    <tr>
                                        <th><?php echo $counter; ?></th>
                                        <td><?php echo $result['event_title']; ?></td>
                                        <td><?php echo $row1['count'];?></td>
                                        <td><?php echo $row2['no_count'];?></td>
                                    </tr>
                                    <?php 
                                    $counter= $counter+1;
                                      }
                                     ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
$query = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type, create_event.operation, create_event.user_id
            FROM `event`
            JOIN `create_event` ON event.event_id = create_event.event_id
            WHERE create_event.user_id = '$user_id' AND create_event.operation = 'create_event' AND event.event_type = 'continues'
            ");

// Store event IDs in an array
$eventIDs = array();
while ($result = mysqli_fetch_array($query)) {
    $eventIDs[] = $result['event_id'];
?>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong><i class="zmdi zmdi-chart"></i> Attendance</strong> Report of <?php echo $result['event_title']; ?></h2>
                    <ul class="header-dropdown">
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div id="columnchart_values_<?php echo $result['event_id']; ?>"></div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<?php  
        $query = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type,create_event.operation,create_event.user_id
            FROM `event`
            JOIN `create_event` ON event.event_id = create_event.event_id
            WHERE create_event.user_id = '$user_id' AND create_event.operation= 'join' AND event.event_type= 'continues' GROUP BY event.event_id
            ");
        $counter = 1;
         ?>

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                    <h2><strong><i class="zmdi zmdi-chart"></i> Join</strong> Events</h2>
                    <ul class="header-dropdown">
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                   </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table m-b-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">S.NO</th>
                                        <th scope="col">Event Title</th>
                                        <th scope="col">Total Present</th>
                                        <th scope="col">Total Absent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     while($result= mysqli_fetch_array($query)){
                                        $C_event_id = $result['event_id'];
                                        $sql1 = "SELECT COUNT(DISTINCT event_no) AS count FROM `create_event` WHERE `user_id` = '$user_id' AND `event_id` = '$C_event_id' AND `operation` = 'join' AND `attendance_id` > 0";
                                        $sql1result = mysqli_query($con, $sql1);
                                        $row1= mysqli_fetch_assoc($sql1result);
                                        $sql2 = "SELECT COUNT(event_no) AS no_count FROM `create_event` WHERE `user_id` = '$user_id' AND `event_id` = '$C_event_id' AND `operation` = 'join' AND `attendance_id` = 0";
                                        $sql2result = mysqli_query($con, $sql2);
                                        $row2= mysqli_fetch_assoc($sql2result);
                                     ?>
                                    <tr>
                                        <th><?php echo $counter; ?></th>
                                        <td><?php echo $result['event_title']; ?></td>
                                        <td><?php echo $row1['count'];?></td>
                                        <td><?php echo $row2['no_count'];?></td>
                                    </tr>
                                    <?php 
                                    $counter= $counter+1;
                                      }
                                     ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="row clearfix">
        <?php $query = mysqli_query($con, "SELECT DISTINCT event.event_id, event.event_title, event.event_type,create_event.operation,create_event.user_id
            FROM `event`
            JOIN `create_event` ON event.event_id = create_event.event_id
            WHERE create_event.user_id = '$user_id' AND create_event.operation= 'join' AND event.event_type= 'continues'");
            $joineventIDs = array();
            while ($result = mysqli_fetch_array($query)) {
            $joineventIDs[] = $result['event_id'];

             ?>


    <div class="col-lg-6 col-md-12">
        <div class="card">
                <div class="header">
                    <h2><strong><i class="zmdi zmdi-chart"></i> Attendance</strong> Report of <?php echo $result['event_title']; ?></h2>
                    <ul class="header-dropdown">
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div id="piechart_values_<?php echo $result['event_id']; ?>"></div>
                </div>
            </div>
    </div>

<?php } ?>
</div>
</div>

<?php include_once('footer.php'); ?>

<script type="text/javascript">
    var eventIDs = <?php echo json_encode($eventIDs); ?>;
    eventIDs.forEach(function(eventID) {
        makeChart(eventID);
    });

    function makeChart(eventID) {
        // Make an Ajax call to the `join_requests.php` file
        $.ajax({
            url: 'join_requests.php?dashboardchart=true&user_id=<?php echo $user_id; ?>&event_id=' + eventID,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    // Get the data from the response
                    var users = response.data;

                    // Prepare data for the chart
                    var chartData = [['Event Date', 'Total Present', 'Total Absent']];
                    $.each(users, function(index, user) {
                        var eventData = [user.event_date, parseInt(user.total_present), parseInt(user.total_absent)];
                        chartData.push(eventData);
                    });

                    // Create and draw the chart
                    google.charts.load('current', { packages: ['corechart'] });
                    google.charts.setOnLoadCallback(function() {
                        drawChart(eventID, chartData);
                    });

                    function drawChart(eventID, chartData) {
                        var data = google.visualization.arrayToDataTable(chartData);

                        var options = {
                            title: 'Attendance per date',
                            width: 1000,
                            height: 400,
                            legend: { position: 'top' },
                        };

                        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values_' + eventID));
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
    }
</script>

<script type="text/javascript">
    var eventIDs = <?php echo json_encode($joineventIDs); ?>;
    eventIDs.forEach(function(eventID) {
        joinmakeChart(eventID);
    });

    function joinmakeChart(eventID) {
        // Make an Ajax call to the `join_requests.php` file
        $.ajax({
            url: 'join_requests.php?dashboardjoinchart=true&user_id=<?php echo $user_id; ?>&event_id=' + eventID,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
    // Get the data from the response
    var users = response.data;

    // Prepare data for the chart
    var chartData = [['Event', 'Count']];
    $.each(users, function(index, user) {
        var eventData = ['Total Present', parseInt(user.total_present)];
        var eventData2 = ['Total Absent', parseInt(user.total_absent)];
        chartData.push(eventData);
        chartData.push(eventData2);
    });

    // Create and draw the chart
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(function() {
        drawChart(eventID, chartData);
    });

    function drawChart(eventID, chartData) {
        var data = google.visualization.arrayToDataTable(chartData);

        var options = {
            title: 'Attendance Summary',
            width: 400,
            height: 300,
            legend: { position: 'top' },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_values_' + eventID));
        chart.draw(data, options);
    }
}
 else {
                    // If the server returns an error message, display the message
                    $('.message2').html('<div class="alert alert-danger">' + response.message + '</div>').fadeIn(500).delay(2000).fadeOut(500);
                }
            },
            error: function(xhr, status, error) {
                $('.message2').html('<div class="alert alert-danger">Error communicating with the server.</div>').fadeIn(500).delay(2000).fadeOut(500);
            }
        });
    }
</script>
