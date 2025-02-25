<?php


include('../faculty/facultyfunctions.php');
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>

    <!-- Favicon -->
    <link rel="icon" href="../photo/muj-title-logo.png" type="image/png">

    <!---------------------------- CSS Links --------------------------------->
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../sidebar-bootstrap-main/sidebar-style.css">
    <link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="../faculty-style.css">
    <link rel="stylesheet" href="../table_print/table.css">
    <link rel="stylesheet" href="../common-styling.css">

    <!---------------------------- JS Links --------------------------------->

    <script src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="../fontawesome-free-6.6.0-web/js/fontawesome.min.js"></script>


    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  

  


    

<!-- JavaScript for Dynamic Title -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Map pages to their respective titles
        const pageTitles = {
            "faculty_profile.php": "Faculty Profile",
            "faculty_addproject.php": "Add Project",
            "listofallocated_project.php": "Project Allocation",
            "faculty_notice.php": "Circular Notice",
            "faculty_changepassword.php": "Change Password",
            "faculty_feedback.php": "Feedback",
            "facultylogout.php": "Logout"
        };

        // Get the current URL of the page
        const currentURL = window.location.href;
        
        // Find the page name (last part of the URL after '/')
        const pageName = currentURL.split("/").pop();
        
        // Update the title dynamically if a match is found in the map
        document.title = pageTitles[pageName] || "Faculty Profile";
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




.password-container {
  position: relative;
}
.toggle-password {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  border: none;
  background: none;
  cursor: pointer;
  color: #6c757d;
}
.alert {
  animation: fadeIn 0.5s;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>

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
        <ul class="sidebar-nav" style="text-decoration: none;">
                <li class="sidebar-item">
                    <a href="../faculty/faculty_profile.php" class="sidebar-link"> 
                        <i style="font-size:20px" class="lni lni-user"></i>
                        <span>Faculty Profile</span>
                    </a>
                </li>
   
                <li class="sidebar-item">
                    <a href="../faculty/faculty_addproject.php" class="sidebar-link">
                        <i class="fa-solid fa-folder-plus"></i>
                        <span>Add Project</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../faculty/listofallocated_project.php" class="sidebar-link">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>Allocate Project</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../faculty/faculty_notice.php" class="sidebar-link">
                    <i class="lni lni-popup"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                <a href="../faculty/faculty_feedback.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-comment-dots"></i>
                    <span>Feedback</span>
                </a>
            </li>
                <li class="sidebar-item">
                    <a href="../faculty/faculty_changepassword.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-lock"></i>
                        <span>Change Password</span>
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
                <span class="me-2"><?php echo htmlspecialchars($faculty['fname']); ?> :: </span>
                <span><?php echo htmlspecialchars($fid); ?></span>
                </div>

                <!-- Logout Button -->
                <a href="../faculty/facultylogout.php" style="background: white; padding: 6px 12px; margin-left: 15px; border-radius: 20px; 
                display: flex; align-items: center; text-decoration: none; color: #e45f06;
                font-weight: 500; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>

            </div>
        </div>
    </div>
</header>




<script src="../sidebar-bootstrap-main/sidebar.js"></script>