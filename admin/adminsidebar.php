<?php
//--------------------connection file 
include('../admin/adminfunction.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>

    <!-- Favicon -->
    <link rel="icon" href="../photo/muj-title-logo.png" type="image/png">

    <!---------------------------- CSS Links --------------------------------->

    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
    <link rel="stylesheet" href="../sidebar-bootstrap-main/sidebar-style.css">
    <link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../table_print/table.css">
    <link rel="stylesheet" href="../faculty-style.css">
    <link rel="stylesheet" href="../common-styling.css"> <!-- Uncomment if needed -->
    <!---------------------------- JS Links --------------------------------->
    <script src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="../fontawesome-free-6.6.0-web/js/fontawesome.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    
<!-- JavaScript for Dynamic Title -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Map pages to their respective titles
        const pageTitles = {
            "adminprofile.php": "Admin Profile",
            "adminaddfaculty.php": "Add Faculty",
            "adminaddstudent.php": "Add Student",
            "adminaddproject.php": "Add Project",
            "admin_allocated_project.php": "Allocated Project",
            "admin_remening_student.php": "Remaining Student",
            "admin_share_notification.php": "Circular Notice",
            "change_password.php": "Change Password",
            "adminfeedback.php": "Admin Feedback",
            "adminlogout.php": "Admin Logout",
        };

        // Get the current URL of the page
        const currentURL = window.location.href;
        
        // Find the page name (last part of the URL after '/')
        const pageName = currentURL.split("/").pop();
        
        // Update the title dynamically if a match is found in the map
        document.title = pageTitles[pageName] || "Addmin Profile";
    });

    
</script>


      <style>

        
    
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
                    <a href="../admin/adminprofile.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-user-circle icon"></i>
                        <span  style="font-size:18px">Profile</span>
                    </a>
                </li>
   
                <li class="sidebar-item">
                    <a href="../admin/adminaddfaculty.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-chalkboard-teacher icon"></i>
                        <span style="font-size:18px">Faculty</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="../admin/adminaddstudent.php" class="sidebar-link">
                
                    <i style="font-size:20px" class="fas fa-user-graduate icon"></i>
                        <span style="font-size:18px">Student</span>
                    </a>
                </li>
             

                <li class="sidebar-item">
                    <a href="../admin/addproject.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-project-diagram icon"></i>
                        <span style="font-size:18px">projects</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../admin/admin_allocated_project.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-tasks icon"></i>
                        <span style="font-size:18px">Allocated project</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../admin/admin_remening_student.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-user-clock icon"></i>
                        <span style="font-size:18px">Remaining Student</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="../admin/admin_share_notification.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-bullhorn icon"></i>
                        <span style="font-size:18px">Share Notice</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../admin/adminfeedback.php" class="sidebar-link">
                    <i style="font-size:20px" class="fas fa-comment-dots"></i>
                    <span>Feedback</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../admin/change_password.php" class="sidebar-link">
    
<i style="font-size:20px" class="fas fa-lock"></i>
                        <span style="font-size:18px">Change Password</span>
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
                <span class="me-2"><?php echo htmlspecialchars($admin['aname']); ?> :: </span>
                <span><?php echo htmlspecialchars($admin['id']); ?></span>
                </div>

                <!-- Logout Button -->
                <a href="../admin/adminlogout.php" style="background: white; padding: 6px 12px; margin-left: 15px; border-radius: 20px; 
                display: flex; align-items: center; text-decoration: none; color: #e45f06;
                font-weight: 500; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>

            </div>
        </div>
    </div>
</header>



<script src="../sidebar-bootstrap-main/sidebar.js"></script>










