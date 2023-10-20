
<?php include_once('header.php'); ?>
<style>
    .status {
  display: flex;
  align-items: center;
}

.status i {
  font-size: 14px;
  margin-right: 5px;
}

.present {
  color: green;
}

.absent {
  color: red;
}


</style>
<div class="message"></div>
<section class="content">
    <div class="body_scroll">
        <div class="container-fluid">
                        <?php 
                        $event_id = $_GET['event_id'];
                        $event_type = $_GET['event_type'];
                        if ($event_type=='continues') {
                            
                            ?>
                             
                            <div class="row clearfix">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="chat_list">
                                            <ul  class="user_list list-unstyled mb-0 mt-3">
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <div id="present-list">
                                                        </div>
                                                    </a>
                                                </li> 
                                            </ul>
                                        </div>

                                        <?php

                                        $event_no = $_GET['event_no'];
                                        $query7 = mysqli_query($con, "SELECT `event_title` FROM event WHERE event_id = '$event_id'");
                                        $row = mysqli_fetch_assoc($query7); 
                                        $event_title = $row['event_title'];
                            include "phpqrcode/qrlib.php"; // Include the QR code library
                            $data_array = array('event_id' => $event_id,'event_name' => $event_title,'event_no' => $event_no);
                            $data = serialize($data_array); // Serialize the array
                            $filename = "qr-code-" . $event_id . "-" . urlencode($event_title) . ".png"; // Set the QR code filename and path
                            $filepath = "QR_code_image/" . $filename;
                            $size = 5; // Set the QR code size and error correction level
                            $level = "Q";
                            QRcode::png($data, $filepath, $level, $size);  // Generate the QR code
                            
                            ?>
                            <div class="chat_window body" style="margin-left: 300px;">
                                <div class="chat-header">
                                    <div class="user">
                                        <div class="chat-about">
                                            <div class="chat-with"><?php echo $event_title; ?></div>
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <ul class="chat-history">
                                    <?php  echo '<img src="' . $filepath . '" />'; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                            <?php
                        }
                        elseif ($event_type== 'one_time') {
                            $query7 = mysqli_query($con, "SELECT `event_title` FROM event WHERE event_id = '$event_id'");
                            $row = mysqli_fetch_assoc($query7); 
                            $event_title = $row['event_title'];
                            include "phpqrcode/qrlib.php";
                            $data = "http://192.168.43.88/smart-attendance-system/one_time_form.php?event_id=". $event_id;
                            $filename = "qr-code-" . $event_id . "-" . urlencode($event_title) . ".png";
                            $filepath = "QR_code_image/" . $filename;
                            $size = 10;
                            $level = "Q";
                            QRcode::png($data, $filepath, $level, $size);
                            ?>

                            <div class="row clearfix">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="body">
                                            <div class="chat-header">
                                                        <h5 class="card-title"><?php echo $event_title; ?></h5>
                                                </div>
                                            </div>
                                            <hr>
                                            <ul style="text-align: center;">
                                                <?php  echo '<img src="' . $filepath . '" />'; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        ?>
        </div>
    </div>
    <?php if ($event_type== 'one_time') {
        $event_id = $_GET['event_id'];
        $query = "SELECT DISTINCT fields_name FROM `field_name` WHERE `F_event_id` = '$event_id'";
        $result = mysqli_query($con, $query);
        $fieldNames = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $fieldName = $row['fields_name'];
            $fieldNames[] = $fieldName;
        }
        $dataQuery = "SELECT fv.field_values, fn.fields_name
        FROM field_values fv
        JOIN field_name fn ON fn.f_name_id = fv.F_name_id
        WHERE fn.F_event_id = '$event_id'";
        $dataResult = mysqli_query($con, $dataQuery);
        $data = array();
        while ($row = mysqli_fetch_assoc($dataResult)) {
         $fieldName = $row['fields_name'];
         $fieldValue = $row['field_values'];
         if (!isset($data[$fieldName])) {
            $data[$fieldName] = array();
        }
        $data[$fieldName][] = $fieldValue;
    }
    ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable table m-b-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S.NO</th>
                                        <?php foreach ($fieldNames as $fieldName) { ?>
                                            <th><?php echo $fieldName; ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                   if (!empty($data)) {
                                    $rowCount = count($data[$fieldNames[0]]);
                                    for ($i = 0; $i < $rowCount; $i++) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <?php foreach ($fieldNames as $fieldName) { ?>
                                                <td><?php echo $data[$fieldName][$i]; ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php }
                                } else {
                                    echo "<tr><td colspan='" . (count($fieldNames) + 1) . "'>No data available</td></tr>";
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
<?php } ?>
    
</section>

<?php  $event_id = $_GET['event_id'];
if ($event_title=='continues') {
    $event_no = $_GET['event_no'];
}
 ?>



<?php include_once('footer.php'); ?>
<script>
    $(document).ready(function() {
  // Call the server every 5 seconds to get the updated list of present users
  setInterval(getPresentUsers, 2000);
});

function getPresentUsers() {
    var event_id = '<?php echo $event_id; ?>';
    var event_no = '<?php echo $event_no; ?>';
  $.ajax({
  url: 'join_requests.php',
  type: 'GET',
  data: {marking: true, event_id: event_id, event_no: event_no},
  dataType: 'json',
  success: function(response) {
    if(response.status == 'success') {
      // Clear the existing list of present users
      $('#present-list').empty();
      // Iterate through the response data and append each present user to the list
      $.each(response.data, function(index, users) {
         var html = '<li>' +
        '<img src="' + users.image + '" alt="avatar" />' +
        '<div class="about">' +
        '<div class="name">' + users.name + '</div>' +
        '<div class="status">' +
        '<i class="zmdi zmdi-circle ' + (users.attendance_marked == 1 ? ' present' : ' absent') + '"></i>' +
        (users.attendance_marked == 1 ? ' present' : ' absent') +
        '</div>'+
        '</div>' +
        '</li>';
          $('#present-list').append(html);
      });
  }
else {
      // If the server returns an error message, display the message
      $('.message').html('<div class="alert alert-danger">' + response.message + '</div>').fadeIn(500).delay(2000).fadeOut(500);
    }
  },
  error: function(xhr, status, error) {
    $('.message').html('<div class="alert alert-danger">Error communicating with server.</div>').fadeIn(500).delay(2000).fadeOut(500);
  }
});

 }

</script>
