<?php session_start();
include_once('config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit."> 
    <title>Smart Attendance</title>

    <meta name="author" content="Codeconvey" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css"/>
    <!-- Student Registration Form CSS -->
    <link rel="stylesheet" href="assets/form_css/style.css">
    <!--Only for demo purpose - no need to add.-->
    <link rel="stylesheet" type="text/css" href="assets/form_css/demo.css" />
  
</head>
<body>

     <?php
$event_id = $_GET['event_id'];

date_default_timezone_set('Asia/Karachi');
$currentDateTime = date('Y-m-d H:i:s');
$currentTime = date('H:i:s', strtotime($currentDateTime));
$currentDate = date('Y-m-d', strtotime($currentDateTime));

$sql = "SELECT * FROM `one_time_event` WHERE `OTevent_id` = '$event_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$event_date = $row['one_event_date'];
$event_start_time = $row['one_start_time'];
$event_end_time = $row['one_end_time'];
 
 
if ($event_date == $currentDate) {
    if ($currentTime >= $event_start_time && $currentTime <= $event_end_time) {
        if (isset($_POST['form_submit'])) {
            $fieldValues = $_POST['fieldValue'];
            foreach ($fieldValues as $f_name_id => $value) {
                $Query = "INSERT INTO `field_values` (`F_name_id`, `F_event_id`, `field_values`) VALUES ('$f_name_id', '$event_id', '$value')";
                $result = mysqli_query($con, $Query);
            }
             ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Well done!</strong> Attendance has been Recorded.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php
        }
        ?>
        <header class="ScriptHeader">
            <div class="rt-container">
                <div class="col-rt-12">
                    <div class="rt-heading">
                        <h1>Event Form</h1>
                    </div>
                </div>
            </div>
        </header>

        <section>
            <div class="rt-container">
                <div class="col-rt-12">
                    <div class="Scriptcontent">
                        <!-- Start Student Registration Form -->
                        <form class="reg-form" role="form" method="POST" action="">
                            <p class="helper-text">* denotes a required field</p>
                            <?php
                            $sql = "SELECT * FROM `field_name` WHERE `F_event_id` = '$event_id'";
                            $query = mysqli_query($con, $sql);
                            while ($result = mysqli_fetch_array($query)) {
                                $f_name_id = $result['f_name_id'];
                                ?>
                                <div class="field-row">
                                    <label class="form-label" for="firstName"><?php echo $result['fields_name']; ?></label>
                                    <input type="text" id="firstName" name="fieldValue[<?php echo $f_name_id; ?>]" class="field text-field" required>
                                    <span class="message"></span>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <button type="submit" name="form_submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php 
            } 
            else {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Attention!</strong> Event Time is Expired.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php
            }
        }
        else {
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Attention!</strong> Event Date is Expired.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php
        }
        ?>
</div>
</section>
     


    <!-- Analytics -->

  </body>
  <footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
     
  </footer>
</html>