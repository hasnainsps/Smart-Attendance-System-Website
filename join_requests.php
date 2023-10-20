<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once('config.php');

if(isset($_POST['accept'])) {
    // Get the event ID and user ID from the form
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];
    // Update the database to set the operation to "join"
   $query = "UPDATE `create_event` SET `operation` = 'join' WHERE `user_id` = '$user_id' AND `event_id` = '$event_id'";
    $result = mysqli_query($con, $query);
    
    // Check if the query was successful
     if($result) {
        // If successful, remove the row from the table and return a success message
        echo json_encode(array('status' => 'success', 'message' => 'User Added Successfully.'));
    } else {
        // If unsuccessful, return an error message
        echo json_encode(array('status' => 'error', 'message' => 'Error in adding user.'));
    }
}

if(isset($_POST['reject'])) {
    // Get the event ID and user ID from the form
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];
    // Update the database to set the operation to "delete"
   $query = "UPDATE `create_event` SET `operation` = 'delete' WHERE `user_id` = '$user_id' AND `event_id` = '$event_id'";
    $result = mysqli_query($con, $query);
    
    // Check if the query was successful
     if($result) {
        // If successful, remove the row from the table and return a success message
        echo json_encode(array('status' => 'success', 'message' => 'User Delete Successfully.'));
    } else {
        // If unsuccessful, return an error message
        echo json_encode(array('status' => 'error', 'message' => 'Error in deleteing user.'));
    }
}

if(isset($_GET['marking'])) {
    // Get the event ID and user ID from the form
    $event_id = $_GET['event_id'];
    $event_no = $_GET['event_no'];
    // Update the database to set the operation to "join"
    $query = "SELECT user.user_name, user.image, create_event.attendance_id
    FROM user
    JOIN create_event ON create_event.user_id = user.user_id
    WHERE create_event.event_id = '$event_id' AND create_event.operation = 'join' AND create_event.event_no = '$event_no'
    ";
    $result = mysqli_query($con, $query);  
    // Check if the query was successful
    if($result) {
    $users = array();
    while($row = mysqli_fetch_assoc($result)) {
    $markedattendance = $row['attendance_id'];
    $attendance_marked = 0;
    $user_name = $row['user_name'];
    if ($row['image']== NULL) {
     $image = "assets/images/image-gallery/default_image.png";
     }
    else{
      $image = $row['image'];
    }

    if ($markedattendance > 0) {
        $attendance_marked = 1;
    }

    $user = array(
        'name' => $user_name,
        'image' => $image,
        'attendance_marked' => $attendance_marked
    );

    $users[] = $user;
}

//print_r($users);
    
    // Return the array of user data in the response
    echo json_encode(array('status' => 'success', 'data' => $users));
} else {
    // If unsuccessful, return an error message
    echo json_encode(array('status' => 'error', 'message' => 'There is no users'));
}
}

if(isset($_GET['chart'])) {
    // Get the event ID and user ID from the form
    $event_id = $_GET['event_id'];
    $user_id = $_GET['user_id'];
    $query = "SELECT DISTINCT create_event.event_no, continues_event.con_event_date
          FROM `create_event`
          JOIN `continues_event` ON create_event.event_id = continues_event.Cevent_id AND create_event.event_no = continues_event.event_no
          WHERE create_event.event_id = '$event_id'
          ORDER BY create_event.event_no ASC";
$result = mysqli_query($con, $query);

$users = array();

// Loop through each event_no
while ($row = mysqli_fetch_assoc($result)) {
    $event_no = $row['event_no'];
    $event_date = $row['con_event_date'];

    $Total_query = "SELECT COUNT(*) AS total_student
                    FROM `create_event`
                    WHERE `event_id` = '$event_id' AND `event_no` = '$event_no' AND `operation` = 'join'";
    $result_total = mysqli_query($con, $Total_query);
    $row_count = mysqli_fetch_assoc($result_total);
    $TotalStudent = $row_count['total_student'];

    $query_count = "SELECT COUNT(*) AS total_present
                    FROM `create_event`
                    WHERE `event_id` = '$event_id' AND `event_no` = '$event_no' AND `operation` = 'join' AND `attendance_id` > 0";
    $result_count = mysqli_query($con, $query_count);

        $row_count = mysqli_fetch_assoc($result_count);
        $TotalPresent = $row_count['total_present'];

        $total_absent = $TotalStudent-$TotalPresent;
        // Create the user array
        $user = array(
            'event_date' => $event_date,
            'total_present' => $TotalPresent,
            'total_absent' => $total_absent,
        );
        $users[] = $user;
    // Return the array of user data in the response
   // 
} 
echo json_encode(array('status' => 'success', 'data' => $users));
}


if(isset($_GET['dashboardchart'])) {
    
   $event_id = $_GET['event_id'];
    $user_id = $_GET['user_id'];
    $query = "SELECT DISTINCT create_event.event_no, continues_event.con_event_date
          FROM `create_event`
          JOIN `continues_event` ON create_event.event_id = continues_event.Cevent_id AND create_event.event_no = continues_event.event_no
          WHERE create_event.event_id = '$event_id'
          ORDER BY create_event.event_no ASC";
$result = mysqli_query($con, $query);

$users = array();

// Loop through each event_no
while ($row = mysqli_fetch_assoc($result)) {
    $event_no = $row['event_no'];
    $event_date = $row['con_event_date'];

    $Total_query = "SELECT COUNT(*) AS total_student
                    FROM `create_event`
                    WHERE `event_id` = '$event_id' AND `event_no` = '$event_no' AND `operation` = 'join'";
    $result_total = mysqli_query($con, $Total_query);
    $row_count = mysqli_fetch_assoc($result_total);
    $TotalStudent = $row_count['total_student'];

    $query_count = "SELECT COUNT(*) AS total_present
                    FROM `create_event`
                    WHERE `event_id` = '$event_id' AND `event_no` = '$event_no' AND `operation` = 'join' AND `attendance_id` > 0";
    $result_count = mysqli_query($con, $query_count);

        $row_count = mysqli_fetch_assoc($result_count);
        $TotalPresent = $row_count['total_present'];

        $total_absent = $TotalStudent-$TotalPresent;
        // Create the user array
        $user = array(
            'event_date' => $event_date,
            'total_present' => $TotalPresent,
            'total_absent' => $total_absent,
        );
        $users[] = $user;
    // Return the array of user data in the response
   // 
} 
echo json_encode(array('status' => 'success', 'data' => $users));
}

if(isset($_GET['dashboardjoinchart'])) {
    
   $event_id = $_GET['event_id'];
    $user_id = $_GET['user_id'];

    $query_count = "SELECT COUNT(*) AS total_present
                    FROM `create_event`
                    WHERE `user_id` = '$user_id' AND `event_id` = '$event_id' AND `operation` = 'join' AND `attendance_id` > 0";
    $result_count = mysqli_query($con, $query_count);

        $row_count = mysqli_fetch_assoc($result_count);
        $TotalPresent = $row_count['total_present'];

    $query_count = "SELECT COUNT(*) AS total_absent
                    FROM `create_event`
                    WHERE `user_id` = '$user_id' AND `event_id` = '$event_id' AND `operation` = 'join' AND `attendance_id` = 0";
    $result_count = mysqli_query($con, $query_count);

        $row_count = mysqli_fetch_assoc($result_count);
        $TotalAbset = $row_count['total_absent'];    

        // Create the user array
        $user = array(
            'total_present' => $TotalPresent,
            'total_absent' => $TotalAbset,
        );
        $users[] = $user;
    // Return the array of user data in the response
   // 
echo json_encode(array('status' => 'success', 'data' => $users));
}

if(isset($_GET['calender'])) {
    
    $user_id = $_GET['user_id'];

    $query = "SELECT DISTINCT event.event_title, continues_event.con_event_date, continues_event.con_start_time, continues_event.con_end_time, create_event.operation 
FROM `event`  
JOIN `continues_event` ON continues_event.Cevent_id = event.event_id 
JOIN `create_event` ON create_event.event_id = event.event_id
WHERE create_event.user_id = '$user_id' AND continues_event.con_event_date >= NOW() AND create_event.operation IN ('join', 'create_event')";
    $result = mysqli_query($con, $query);
    $events = array();

while ($row = mysqli_fetch_assoc($result)) {
    $event = array(
        'event_title' => $row['event_title'],
        'event_date' =>  $row['con_event_date'],
        'start_time' =>  $row['con_start_time'],
        'end_time' => $row['con_end_time']
    );

    // Check the operation value
    if ($row['operation'] == 'join') {
        $event['operation'] = 'join';
    } elseif ($row['operation'] == 'create_event') {
        $event['operation'] = 'create';
    }

    $events[] = $event;
}
echo json_encode(array('status' => 'success', 'data' => $events));
}


 ?>