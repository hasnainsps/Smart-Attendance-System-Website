<?php
require_once('config.php');

function getUsersAttendance($con, $event_id, $user_id) {
    $query = "SELECT DISTINCT user.user_id, user.user_name, user.email, create_event.attendance_id
              FROM `user`
              JOIN `create_event` ON user.user_id = create_event.user_id
              WHERE create_event.event_id = '$event_id' AND create_event.operation = 'join' GROUP BY user.user_id";
    $result = mysqli_query($con, $query);
    $users = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $attendance_id = $row['attendance_id'];
        // Determine if the user is present or absent based on attendance_id
        if ($attendance_id > 0) {
            $attendance = 'Present';
        } else {
            $attendance = 'Absent';
        }

        // Add user data to the users array
        $user = array(
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'email' => $row['email'],
            'attendance' => $attendance
        );

        $users[] = $user;
    }

    // Return the array of user data in JSON format
    return json_encode($users);
}

// Usage example:
$event_id = 67;
$user_id = 1;
$usersData = getUsersAttendance($con, $event_id, $user_id);
$users = json_decode($usersData, true); // Decode the JSON data into an array

// Output the formatted JSON data
echo '<pre>' . json_encode($users, JSON_PRETTY_PRINT) . '</pre>';

 ?>