<?php
/*error_reporting(E_ALL); 
var_dump($_POST);
var_dump($_REQUEST);*/
//ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$data = json_decode(file_get_contents('php://input'), true);


require_once('config.php');
 /* $username = $data['username'];
	$email = $data['email'];
	$password = $data['password'];
	$mobilenumber = $data['Mobile_number'];
	$role = 'user';
   echo $username;
   echo $email;
   echo $password;
   echo $mobilenumber;
   echo $role;*/
   
if(isset($data) && $data['action'] == 'login') {

	$email_or_username = $data['email_or_username'];
	$password = $data['password'];
   //echo $email_or_username;
	$sql = "SELECT * FROM user WHERE `email`='$email_or_username' or `user_name` = '$email_or_username'";
	//echo $sql;
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
// Check if the query returned a result
	if (mysqli_num_rows($result) > 0) {
  // Authentication successful
		if ($password==$row['password']) {
			$user_id = $row['user_id'];
    // Authentication successful
			$response = array('status' => 'success', 'status_code' => '200', 'user_id' => $user_id);
      echo json_encode($response);
    //echo json_encode(array('status' => 'success', 'status_code' => '200'));
  } else {
    // Password incorrect
    echo json_encode(array('status' => 'error', 'status_code' => '202'));
  }
}
	else {
  // Authentication failed
		echo json_encode(array('status' => 'error', 'status_code' => '201'));
	}

}
   
elseif(isset($data) && $data['action'] == 'registration') {

	$username = $data['username'];
	$email = $data['email'];
	$password = $data['password'];
	$mobilenumber = $data['Mobile_number'];
	$role = 'user';
	$status = 'enable';


	$sql1 = "SELECT * FROM `user` WHERE `user_name` = '$username' OR `email` = '$email'";
	$result1 = mysqli_query($con, $sql1);

	if (mysqli_num_rows($result1) > 0) {
		echo json_encode(array('status' => 'success', 'status_code' => '202'));
	} else {
		$sql2 = "INSERT INTO `user` (`user_name`,`email`,`password`,`role`,`status`,`Mobile_number`) VALUES ('$username','$email','$password','$role','$status','$mobilenumber')";
		$result2 = mysqli_query($con, $sql2);
		$row = mysqli_fetch_array($result2);
		if($result2) {
			$user_id = $row['user_id'];
    // Authentication successful
			$response = array('status' => 'success', 'status_code' => '200', 'user_id' => $user_id);
      echo json_encode($response);
			//echo json_encode(array('status' => 'success', 'status_code' => '200'));
		} 
		else {
			echo json_encode(array('status' => 'error', 'status_code' => '201'));
		}
	}

}

elseif(isset($data) && $data['action'] == 'home') {

	$user_id = $data['user_id'];
	$sql = "SELECT * FROM user WHERE `user_id`='$user_id'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);

	$user_name = $row['user_name'];
	$imageUrl = $row['image'];
	if ($imageUrl == NULL) {
		$baseUrl = 'http://192.168.43.88/smart-attendance-system/';
		$default_image = "assets/images/image-gallery/default_image.png";
		$image = $baseUrl . $default_image;
	} else {
		$baseUrl = 'http://192.168.43.88/smart-attendance-system/';
		$image = $baseUrl . $imageUrl;
	}
	$sql = "SELECT DISTINCT event.event_title, event.event_id
        FROM user 
        JOIN create_event ON user.user_id = create_event.user_id
        JOIN event ON create_event.event_id = event.event_id
        WHERE user.user_id = '$user_id' AND create_event.operation = 'join'";
        $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0) {
     $events = array();

  while($row = mysqli_fetch_assoc($result)) {
        $event_id = $row['event_id'];
        $event_title = $row['event_title'];

        $events[] = array('event_id' => $event_id, 'event_title' => $event_title);
     }
     $response = array('status' => 'success', 'status_code' => '200' ,'user_name' => $user_name, 'image' => $image,  'events' => $events );
	   echo json_encode($response);
   }
   else{
      echo json_encode(array('status' => 'success', 'status_code' => '201', 'user_name' => $user_name, 'image' => $image, ));
   }	
      
} 

elseif(isset($data) && $data['action'] == 'attendance') {

	$joinevent_id = $data['event_id'];
	$user_id = $data['user_id'];
	$mac_address = $data['mac_address'];
	$QRCodeString = $data['QRCodeString'];
	$Codedata = unserialize($QRCodeString);
	$event_id = $Codedata['event_id'];
	$event_title = $Codedata['event_name'];
	$event_no = $Codedata['event_no'];
	date_default_timezone_set('Asia/Karachi');
	$currentDateTime = date('Y-m-d H:i:s');
	$currentTime = date('H:i:s', strtotime($currentDateTime));
	$currentDate = date('Y-m-d', strtotime($currentDateTime));

	$timesql = "SELECT * FROM `continues_event` WHERE `Cevent_id` = '$event_id' AND `event_no` = '$event_no'";
	$timeresult = mysqli_query($con, $timesql);
	$timerow = mysqli_fetch_assoc($timeresult);
	$event_date = $timerow['con_event_date'];
	$start_time = $timerow['con_start_time'];
	$end_time = $timerow['con_end_time'];
	if ($event_date==$currentDate) {
		if ($currentTime>= $start_time&&$currentTime<=$end_time) {
			if ($joinevent_id == $event_id) {
				$sql = "SELECT * FROM attendance WHERE `event_id` = '$event_id' AND `event_no` = '$event_no' AND `mac_address` = '$mac_address'";
				$result = mysqli_query($con, $sql);

				if (mysqli_num_rows($result) > 0) {
					echo json_encode(array('status' => 'success', 'status_code' => '201'));
				}
				else{
					$sql1 = "INSERT INTO `attendance` (`event_id`, `user_id`, `event_no`, `mac_address`, `attendance_type`, `marking_time`) VALUES('$event_id', '$user_id', '$event_no', '$mac_address', 'qr_code', '$currentDateTime' )";
					$result1 = mysqli_query($con, $sql1);

					if ($result1) {
						$lastInsertId = mysqli_insert_id($con);
						$sql3 = "UPDATE `create_event` SET `attendance_id` = '$lastInsertId' WHERE `user_id` = '$user_id' AND `event_id` = '$event_id' AND `event_no` = '$event_no'";
						$result3 = mysqli_query($con, $sql3);
						echo json_encode(array('status' => 'success', 'status_code' => '202'));
					}
				}
			}
			else{
				echo json_encode(array('status' => 'success', 'status_code' => '203'));
			} 
		}
		else{
			echo json_encode(array('status' => 'success', 'status_code' => '204'));
		} 
	}
	else{
		echo json_encode(array('status' => 'success', 'status_code' => '205'));
	}   
} 

elseif(isset($data) && $data['action'] == 'chart') {

	$event_id = $data['event_id'];
	$user_id = $data['user_id'];
	$sql = "SELECT COUNT(event_no) AS total_event_count FROM `continues_event` WHERE `Cevent_id` = '$event_id'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
  $total_event_count = $row['total_event_count'];

  $sql = "SELECT COUNT(event_no) AS present_event_count FROM `create_event` WHERE `user_id` = '$user_id' AND `event_id` = '$event_id' AND `attendance_id` > 0 ";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
  $present_event_count = $row['present_event_count'];

  $sql = "SELECT COUNT(event_no) AS absent_event_count FROM `create_event` WHERE `user_id` = '$user_id' AND `event_id` = '$event_id' AND `attendance_id` = 0";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
  $absent_event_count = $row['absent_event_count'];

  $averagevalue = $present_event_count / $total_event_count;

  echo json_encode(array('status' => 'success', 'total_classes' => $total_event_count, 'present' => $present_event_count, 'absent' => $absent_event_count, 'average_value' => $averagevalue));
} 

elseif(isset($data) && $data['action'] == 'barchart') {

	$event_id = $data['event_id'];
	$user_id = $data['user_id'];
$sql1 = "SELECT MONTH(con_event_date) AS month, COUNT(*) AS count FROM `continues_event` WHERE YEAR(con_event_date) = YEAR(NOW()) AND Cevent_id = '$event_id' GROUP BY MONTH(con_event_date)";
$result1 = mysqli_query($con, $sql1);
$attendanceCounts = array();

while ($row1 = mysqli_fetch_assoc($result1)) {
    $month = date("F", mktime(0, 0, 0, $row1['month'], 1)); // Get the month name from the month number
    $count = $row1['count'];
    $attendanceCounts[$month]['count'] = $count;
}

$sql2 = "SELECT MONTH(marking_time) AS month, COUNT(*) AS count FROM `attendance` WHERE YEAR(marking_time) = YEAR(NOW()) AND event_id = '$event_id' AND user_id = '$user_id' GROUP BY MONTH(marking_time)";
$result2 = mysqli_query($con, $sql2);

while ($row2 = mysqli_fetch_assoc($result2)) {
    $month = date("F", mktime(0, 0, 0, $row2['month'], 1)); // Get the month name from the month number
    $count = $row2['count'];
    if (isset($attendanceCounts[$month]['count'])) {
        $attendanceCounts[$month]['count'] -= $count;
    }
    $attendanceCounts[$month]['present'] = $count;
}

foreach ($attendanceCounts as &$counts) {
    $counts = array('count' => $counts['count'], 'present' => isset($counts['present']) ? $counts['present'] : 0);
}

// Print the attendance counts
echo json_encode(array('status' => 'success', 'data_array' => $attendanceCounts));


}

elseif(isset($data) && $data['action'] == 'join') {

	$join_event = $data['join_event'];
	$user_id = $data['user_id'];
	$sql = "SELECT * FROM `event` WHERE `encrypt_event_id`='$join_event'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
// Check if the query returned a result
	if (mysqli_num_rows($result) > 0) {
		  $event_id = $row['event_id'];
	      $sql1 = "SELECT MAX(`event_no`) AS max_event_no FROM `continues_event` WHERE `Cevent_id` = '$event_id'";
          $result1 = mysqli_query($con, $sql1);
	      $row1 = mysqli_fetch_array($result1);		
		  $event_no = $row1['max_event_no'];        
          $query3 = "INSERT INTO `create_event` (`user_id`, `event_id`, `event_no`, `operation`, `attendance_id`) VALUES ('$user_id', '$event_id', '$event_no', 'pending', '0')";
          $result3= mysqli_query($con, $query3);
          echo json_encode(array('status' => 'success', 'status_code' => '200'));
}
	else {
  // Authentication failed
		echo json_encode(array('status' => 'error', 'status_code' => '201'));
	}

} 

elseif(isset($data) && $data['action'] == 'forgotpassword') {

	$email = $data['email'];
	$sql = "SELECT * FROM `user` WHERE `email`='$email'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	if (mysqli_num_rows($result) > 0) {
		  $user_id= $row['user_id'];
		  $url = 'http://192.168.43.88/smart-attendance-system/mobile_forgot_password.php?id='.$user_id.'&email='.$email;
          echo json_encode(array('status' => 'success', 'status_code' => '200','url' => $url));
}
	else {
  // Authentication failed
		$url = "Invalide user";
		echo json_encode(array('status' => 'error', 'status_code' => '201', 'url' => $url));
	}

} 

elseif(isset($data) && $data['action'] == 'profile') {

	$user_id = $data['user_id'];
	$sql = "SELECT * FROM `user` WHERE `user_id`='$user_id'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	if (mysqli_num_rows($result) > 0) {
		  $username= $row['user_name'];
		  $email = $row['email'];
		  $mobile = $row['Mobile_number'];
          echo json_encode(array('status' => 'success', 'status_code' => '200','username' => $username, 'email' => $email, 'mobile' => $mobile));
}
	else {
		echo json_encode(array('status' => 'error', 'status_code' => '201'));
	}

}

?>