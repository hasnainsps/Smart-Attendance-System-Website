<?php 

include('config.php');

if (!empty($_POST['username'])) {

	$username = $_POST['username'];
	$query = "SELECT * FROM `user` Where `user_name` = '$username'";
	$result = mysqli_query($con, $query);;

	if (mysqli_num_rows($result) > 0 ) {
		echo "<span style='color: red'>Username already exits</span>";
		echo "<script> $('#submit').prop('disabled', true);</script>";
	}
	else{
		echo "<span style='color: green'>Username avalible for registration </span>";
		echo "<script> $('#submit').prop('disabled', false);</script>";
	}
}
elseif (!empty($_POST['email'])) {

	$email = $_POST['email'];
	$query = "SELECT * FROM `user` Where `email` = '$email'";
	$result = mysqli_query($con, $query);;

	if (mysqli_num_rows($result) > 0 ) {
		echo "<span style='color: red'>Email already exits</span>";
		echo "<script> $('#submit').prop('disabled', true);</script>";
	}
	else{
		echo "<span style='color: green'>Email avalible for registration </span>";
		echo "<script> $('#submit').prop('disabled', false);</script>";
	}
}


 ?>