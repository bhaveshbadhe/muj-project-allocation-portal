
<?php
include('../student/studentfunctions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>

    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" href="../photo/muj-title-logo.png" type="image/png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  
    <!-- Icon Libraries -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/feather-icons/dist/feather.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../student/studentstyle.css">
    <link rel="stylesheet" href="../common-styling.css">
    <link rel="stylesheet" href="../sidebar-bootstrap-main/sidebar-style.css">

    <script src="../table_print/printjs.php"></script>



    <!-- JavaScript for Dynamic Title -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Map pages to their respective titles
            const pageTitles = {
                "studentprofile.php": "Student Profile",
                "listofproject.php": "List of Projects",
                "student_notification.php": "Notifications",
                "changepassword.php": "Change Password",
                "studentfeedback.php": "Feedback",
                "studentlogout.php": "Logout"
            };

            // Get the current URL of the page
            const currentURL = window.location.href;
            
            // Find the page name (last part of the URL after '/')
            const pageName = currentURL.split("/").pop();
            
            // Update the title dynamically if a match is found in the map
            document.title = pageTitles[pageName] || "  Student Profile";
        });
    </script>
<style>
.wrapper {
  display: flex;
  min-height: 100vh;
}





.main.shifted {
  margin-left: 250px;
}




</style>

<script src="../sidebar-bootstrap-main/sidebar.js"></script>


    <script>
        $(document).ready(function () {
          $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'print']
          });
        });
      </script>
</head>

<body>

  
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button" style="background-color: white;">
                <i class="lni lni-grid-alt" style="color:#e45f06; width:26px"></i>
            </button>
            <div class="sidebar-logo">
                <img src="../photo/manipallogo.png" alt="">
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="../student/studentprofile.php" class="sidebar-link">
                    <i class="lni lni-user"></i>
                    <span>Student Profile</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../student/listofproject.php" class="sidebar-link">
                    <i class="lni lni-agenda"></i>
                    <span>List of Projects</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../student/student_notification.php" class="sidebar-link">
                    <i class="lni lni-popup"></i>
                    <span>Notifications</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../student/changepassword.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-lock"></i>
                    <span>Change Password</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../student/studentfeedback.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-comment-dots"></i>
                    <span>Feedback</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="main px-5 pt-3">

            
            <div class="text-center">
    

            <header style="background: #e45f06; padding: 0; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
    <div style="display: flex; justify-content: space-between; align-items: center; height: 50px; padding: 0 20px; position: relative;">

        <!-- Mobile Menu Button (Aligned to the Left) -->
        <button class="mobile-menu-icon" style="background: transparent; border: none; cursor: pointer; position: absolute; left: 15px;">
            <i class="fas fa-bars" style="font-size: 22px; color: white;"></i>
        </button>

        <!-- Container for Center and Right Items -->
        <div class="container d-flex justify-content-between align-items-center" style="height: 50px; flex-grow: 1;">

            <!-- Right Section (Notification, Name, Logout) -->
            <div class="text-white d-flex align-items-center ms-auto">
                
                <!-- Notification Bell -->
                <a href="../student/student_notification.php" class="position-relative me-3">
                    <i class="fas fa-bell" style="font-size: 20px; color: white;"></i>
                </a>

                <!-- User Info (Visible on Medium Screens and Above) -->
                <div class="d-none d-md-inline">
                    <span class="me-2"><?php echo htmlspecialchars($name); ?> :: </span>
                    <span><?php echo htmlspecialchars($registration_no); ?></span>
                </div>

                <!-- Logout Button -->
                <a href="../student/studentlogout.php" style="background: white; padding: 6px 12px; margin-left: 15px; border-radius: 20px; 
                display: flex; align-items: center; text-decoration: none; color: #e45f06;
                font-weight: 500; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>

            </div>
        </div>
    </div>
</header>

