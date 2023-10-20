<?php session_start();
include_once('config.php');
if(strlen($_SESSION["user_id"])==0)
{   header('location:logout.php');
} else {
   $user_id = $_SESSION["user_id"];
?>

<!doctype html>
        <html class="no-js " lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=Edge">
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
            <title>Smart Attendance</title>
            <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css"/>
            <link rel="stylesheet" href="assets/plugins/charts-c3/plugin.css"/>
            <link rel="stylesheet" type="text/css" href="assets/dist/apexcharts.css">
             
            <link rel="stylesheet" href="assets/plugins/morrisjs/morris.min.css" />
            <!-- Custom Css -->
            <link rel="stylesheet" href="assets/css/style.min.css">
            <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.4"></script>
             <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
             <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        </head>

        <body class="theme-blush">

            <!-- Page Loader -->
            <div class="page-loader-wrapper">
                <div class="loader">
                    <div class="m-t-30"><img src="assets/images/image-gallery/loader.svg" width="68" height="68" alt="Aero"></div>
                    <p>Please wait...</p>
                </div>
            </div>

            <!-- Overlay For Sidebars -->
            <div class="overlay"></div>

            <!-- Main Search -->
            <!-- <div id="search">
                <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
                <form>
                  <input type="search" value="" placeholder="Search..." />
                  <button type="submit" class="btn btn-primary">Search</button>
              </form>
            </div> -->
        <div class="navbar-right">
        <ul class="navbar-nav">
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" title="Notifications" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
                <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
            </a>
            <ul class="dropdown-menu slideUp2">
                <li class="header">Notifications</li>
                <li class="body">
                    <ul class="menu list-unstyled">
                        <?php
                        $query = "SELECT DISTINCT event.event_title, create_event.user_id, create_event.event_id, create_event.operation FROM event JOIN create_event ON event.event_id = create_event.event_id WHERE create_event.user_id = '$user_id' AND create_event.operation = 'create_event' GROUP BY create_event.event_id";
                        $All_events = mysqli_query($con, $query);
                        $num_requests = 0;

                        while($row = mysqli_fetch_assoc($All_events)) {
                            $event_id = $row['event_id'];
                            $event_title = $row['event_title'];
                            $pending_requests = mysqli_query($con, "SELECT DISTINCT * FROM `create_event` WHERE `event_id` = '$event_id' AND `operation` = 'pending'");
                            $num_pending_requests = mysqli_num_rows($pending_requests);

                            if ($num_pending_requests > 0) {
                                $num_requests += $num_pending_requests;
                            }

                            if ($num_pending_requests > 0) {
                                ?>
                                <li>
                                    <a href="continuous_events.php?event_id=<?php echo $event_id;?>"> 
                                        <div class="icon-circle bg-blue"><i class="zmdi zmdi-account"></i></div>
                                        <div class="menu-info">
                                            <h4><?php echo $num_pending_requests; ?> new join requests for <?php echo $event_title; ?></h4>
                                            <p><i class="zmdi zmdi-time"></i> <?php echo date('H:i'); ?> </p>
                                        </div>
                                    </a>
                                </li> 
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </li>
                <li class="footer"> <a href="javascript:void(0);">View All Notifications</a> </li>
            </ul>
        </li>
        <li><a href="profile.php" class="mega-menu" title="Profile"><i class="zmdi zmdi-account"></i></a></li>
        <li><a href="logout.php" class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i></a></li>
    </ul>
    </div>
    <aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="dashboard.php"><img src="assets/images/login_image3.png" width="25" alt="Aero"><span class="m-l-10">Smart Attendance</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            
            <?php 
               $sql = "SELECT * FROM `user` WHERE `user_id` = '$user_id'";
               $result = mysqli_query($con, $sql);
               $row = mysqli_fetch_assoc($result);
               $user_name = $row['user_name']; 
               if ($row['image']== NULL) {
                   $image = "assets/images/image-gallery/default_image.png";
               }
               else{
                $image = $row['image'];
               }


             ?>

            <li>
                <div class="user-info">
                     <a class="image" href="dashboard.php"><img src="<?php echo $image; ?>" alt="User"></a> 
                    <div class="detail">
                        <h4><?php echo $user_name; ?></h4>                       
                    </div>
                </div>
            </li>
            <li id="dashboard-link"><a href="dashboard.php"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            <li id="eventlist-link"><a href="eventlist.php"><i class="zmdi zmdi-calendar"></i><span>Events</span></a></li>
            <li id="userlist-link"><a href="userlist.php"><i class="zmdi zmdi-accounts"></i><span>Users</span></a></li>
             <li id="join-events-link"><a href="join_events.php"><i class="zmdi zmdi-calendar"></i><span>Join Events</span></a></li>
            </li>
        </ul>
    </div>
</aside>

</body>
    <script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
    <script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 

    <script src="assets/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
    <script src="assets/bundles/sparkline.bundle.js"></script> <!-- Sparkline Plugin Js -->
    <script src="assets/bundles/c3.bundle.js"></script>

    <script src="assets/bundles/mainscripts.bundle.js"></script>
    <script src="assets/js/pages/index.js"></script>
    <?php include_once('footer.php'); ?>

    <script>
$(document).ready(function() {
  // Get the current page URL
  var currentPageUrl = window.location.href;

  // Iterate through each <li> element
  $('li').each(function() {
    // Get the href attribute of the <a> element inside the <li>
    var linkUrl = $(this).find('a').attr('href');

    // Check if the current page URL matches the link URL
    if (currentPageUrl.indexOf(linkUrl) > -1) {
      // Add the "active open" class to the matching <li> element
      $(this).addClass('active open');
    }
  });
});
</script>

<?php

    }
?>