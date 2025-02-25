
    <?php 
    session_start();
    include('../admin/adminsidebar.php');
    
    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Function to fetch faculty not assigned to any project
    function getFacultyNotAssignedToProject($con) {
        $semester = isset($_SESSION['semester']) && $_SESSION['semester'] != 'all' ? $_SESSION['semester'] : ''; // Check if semester is set or 'all'
        $semesterCondition = $semester ? "AND p.semester = ?" : ""; // Add condition for semester if it's not 'all'
        $query = "
            SELECT f.fid, f.fname, f.email, f.mobile
            FROM faculty f
            LEFT JOIN project p ON f.fid = p.fid
            WHERE p.fid IS NULL $semesterCondition
        ";
        $stmt = $con->prepare($query);
        if ($semester) {
            $stmt->bind_param("s", $semester);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    function getAllocatedStudents($p_id) {
        global $con;
        $semester = isset($_SESSION['semester']) && $_SESSION['semester'] != 'all' ? $_SESSION['semester'] : ''; // Check if semester is set or 'all'
        $semesterCondition = $semester ? "AND p.semester = ?" : ""; // Add condition for semester if it's not 'all'
        $sql = "
            SELECT s.registration_no, s.name 
            FROM student s
            JOIN allocated_project ap ON s.registration_no = ap.registration_no
            JOIN project p ON ap.p_id = p.p_id
            WHERE ap.p_id = ? $semesterCondition
        ";
        $stmt = $con->prepare($sql);
        if ($semester) {
            $stmt->bind_param("is", $p_id, $semester);
        } else {
            $stmt->bind_param("i", $p_id);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



// Function to fetch projects
function getproject() {
    global $con;
    $semester = isset($_SESSION['semester']) && $_SESSION['semester'] != 'all' ? $_SESSION['semester'] : ''; // Check if semester is set or 'all'
    $semesterCondition = $semester ? "WHERE p.semester = ?" : ""; // Add condition for semester if it's not 'all'
    $sql = "
        SELECT 
            p.p_id, p.pname, p.max_student, p.no_of_student_allocated, 
            p.pdesc, f.fname, f.fid 
        FROM project p
        JOIN faculty f ON p.fid = f.fid
        $semesterCondition
        ORDER BY p.pname
    ";
    $stmt = $con->prepare($sql);
    if ($semester) {
        $stmt->bind_param("s", $semester);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


function getRemainingStudents($con) {
    $semester = isset($_SESSION['semester']) && $_SESSION['semester'] != 'all' ? $_SESSION['semester'] : ''; // Check if semester is set or 'all'
    $semesterCondition = $semester ? "AND s.semester = ?" : ""; // Add condition for semester if it's not 'all'
    $query = "
        SELECT 
            s.registration_no, 
            s.name, 
            s.semester, 
            s.section
        FROM 
            student s
        LEFT JOIN 
            allocated_project ap 
        ON 
            s.registration_no = ap.registration_no
        WHERE 
            ap.registration_no IS NULL $semesterCondition
    ";
    $stmt = $con->prepare($query);
    if ($semester) {
        $stmt->bind_param("s", $semester);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
function getDashboardStats() {
    global $con;
    $semester = isset($_SESSION['semester']) && $_SESSION['semester'] != 'all' ? $_SESSION['semester'] : ''; // Check if semester is set or 'all'
    $semesterCondition = $semester ? "WHERE s.semester = ?" : ""; // Check if semester is set and add condition for semester
    $stats = [
        'total_capacity' => 0,
        'total_allocated' => 0,
        'total_students' => 0,
        'remaining_students' => 0,
        'remaining_project_capacity' => 0
    ];

    // Fetch total capacity for the semester
    $stmt = $con->prepare("SELECT SUM(p.max_student) as total FROM project p LEFT JOIN allocated_project ap ON p.p_id = ap.p_id LEFT JOIN student s ON ap.registration_no = s.registration_no $semesterCondition");
    if ($semester) {
        $stmt->bind_param("s", $semester);
    }
    $stmt->execute();
    $stats['total_capacity'] = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

    // Fetch total allocated students for the semester
    $stmt = $con->prepare("
        SELECT COUNT(*) as total 
        FROM allocated_project ap 
        JOIN project p ON ap.p_id = p.p_id 
        JOIN student s ON s.registration_no = ap.registration_no
        $semesterCondition
    ");
    if ($semester) {
        $stmt->bind_param("s", $semester);
    }
    $stmt->execute();
    $stats['total_allocated'] = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

    // Fetch total students in the semester
    $stmt = $con->prepare("SELECT COUNT(*) as total FROM student s $semesterCondition");
    if ($semester) {
        $stmt->bind_param("s", $semester);
    }
    $stmt->execute();
    $stats['total_students'] = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

    // Calculate remaining students
    $stats['remaining_students'] = $stats['total_students'] - $stats['total_allocated'];

    // Calculate remaining project capacity
    // Adjust the query to prevent syntax error when semesterCondition is empty
    $remaining_project_capacity_query = "
        SELECT SUM(p.max_student - p.no_of_student_allocated) AS total 
        FROM project p 
        LEFT JOIN allocated_project ap ON p.p_id = ap.p_id
        LEFT JOIN student s ON ap.registration_no = s.registration_no
        $semesterCondition
    ";

    // Add the additional condition if semesterCondition is not empty
    if ($semesterCondition) {
        $remaining_project_capacity_query .= " AND p.max_student > p.no_of_student_allocated";
    }

    $stmt = $con->prepare($remaining_project_capacity_query);
    if ($semester) {
        $stmt->bind_param("s", $semester);
    }
    $stmt->execute();
    $stats['remaining_project_capacity'] = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

    return $stats;
}


function performRandomAllocation() {
    global $con;
    $semester = $_SESSION['semester']; // Fetch the semester from the session

    // If the semester is "all", select from all semesters
    $semesterCondition = ($semester == "all") ? "" : "AND semester = ?";
    
    $con->begin_transaction();
    try {
        // Fetch unallocated students
        $remaining_students_query = "
            SELECT registration_no 
            FROM student 
            WHERE registration_no NOT IN (
                SELECT registration_no FROM allocated_project
            ) 
            $semesterCondition
        ";
        $stmt = $con->prepare($remaining_students_query);
        
        // Bind semester if it's not "all"
        if ($semester != "all") {
            $stmt->bind_param("s", $semester);
        }

        $stmt->execute();
        $remaining_students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (empty($remaining_students)) {
            throw new Exception("No unallocated students available.");
        }

        foreach ($remaining_students as $student) {
            // Find a project with available capacity
            $project_query = "
                SELECT p_id, fid 
                FROM project 
                WHERE no_of_student_allocated < max_student
                $semesterCondition
                ORDER BY RAND() 
                LIMIT 1
            ";
            $stmt = $con->prepare($project_query);
            
            // Bind semester if it's not "all"
            if ($semester != "all") {
                $stmt->bind_param("s", $semester);
            }

            $stmt->execute();
            $project = $stmt->get_result()->fetch_assoc();

            if (!$project) {
                throw new Exception("No projects with available capacity.");
            }

            // Allocate student to project
            $allocation_query = "
                INSERT INTO allocated_project (registration_no, p_id, fid) 
                VALUES (?, ?, ?)
            ";
            $allocation_stmt = $con->prepare($allocation_query);
            $allocation_stmt->bind_param(
                "sii", 
                $student['registration_no'], 
                $project['p_id'], 
                $project['fid']
            );
            if (!$allocation_stmt->execute()) {
                throw new Exception("Failed to allocate student: " . $student['registration_no']);
            }

            // Increment the project's allocated student count
            $update_project_query = "
                UPDATE project 
                SET no_of_student_allocated = no_of_student_allocated + 1 
                WHERE p_id = ?
            ";
            $update_project_stmt = $con->prepare($update_project_query);
            $update_project_stmt->bind_param("i", $project['p_id']);
            if (!$update_project_stmt->execute()) {
                throw new Exception("Failed to update project capacity for project ID: " . $project['p_id']);
            }
        }

        // Commit changes
        $con->commit();
        return ['status' => 'success', 'message' => 'Random allocation completed successfully.'];

    } catch (Exception $e) {
        // Rollback on error
        $con->rollback();
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}


// Direct invocation mechanism
if (isset($_POST['perform_allocation']) || isset($_GET['perform_allocation'])) {
    $result = performRandomAllocation();
    echo json_encode($result);
    exit;

    // Proceed with allocation logic
}
error_log(print_r($_POST, true)); // Log received POST data


// Fetch initial data
$projects = getproject();
$remainingStudents = getRemainingStudents($con);

$stats = getDashboardStats();

$facultyNotAssigned = getFacultyNotAssignedToProject($con);
?>



<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete_all'])) {
    session_start();
    include('../connection/connection.php');

    if (!isset($_SESSION['semester'])) {
        echo "<script>
            alert('Semester not set in session. Cannot proceed with deletion.');
            window.location.href = 'admin_remening_student.php';
        </script>";
        exit;
    }

    $semester = $_SESSION['semester'];

    try {
        $con->begin_transaction();

        // Reset project allocations
        $resetProjects = "UPDATE project SET no_of_student_allocated = 0 WHERE semester = ?";
        $stmt = $con->prepare($resetProjects);
        if (!$stmt) throw new Exception("Reset Project Allocations Statement Failed: " . $con->error);
        $stmt->bind_param("s", $semester);
        if (!$stmt->execute()) throw new Exception("Reset Project Allocations Execution Failed: " . $stmt->error);

        // Delete allocations
        $deleteAllocations = "DELETE FROM allocated_project WHERE semester = ?";
        $stmt = $con->prepare($deleteAllocations);
        if (!$stmt) throw new Exception("Delete Allocation Statement Failed: " . $con->error);
        $stmt->bind_param("s", $semester);
        if (!$stmt->execute()) throw new Exception("Delete Allocation Execution Failed: " . $stmt->error);

        // Delete notifications
        $deleteNotifications = "DELETE FROM notifications WHERE registration_no IN (
            SELECT registration_no FROM student WHERE semester = ?)";
        $stmt = $con->prepare($deleteNotifications);
        if (!$stmt) throw new Exception("Delete Notifications Statement Failed: " . $con->error);
        $stmt->bind_param("s", $semester);
        if (!$stmt->execute()) throw new Exception("Delete Notifications Execution Failed: " . $stmt->error);

        $con->commit();

        echo "<script>
            alert('All allocations for semester $semester deleted and project allocations reset successfully.');
            window.location.href = 'admin_remening_student.php';
        </script>";

    } catch (Exception $e) {
        $con->rollback();
        error_log($e->getMessage());
        echo "<script>
            alert('An error occurred while deleting allocations. Please try again later.');
            window.location.href = 'admin_remening_student.php';
        </script>";
    }
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Allocation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .student-badge {
            background-color: #e3f2fd;
            border-radius: 20px;
            padding: 5px 15px;
            margin: 2px;
            display: inline-block;
        }
        .empty-slot {
            background-color: #f8f9fa;
            border-radius: 20px;
            padding: 5px 15px;
            margin: 2px;
            display: inline-block;
        }
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        body {
            background-color: #f6f8fa;
        }
        .card-hover:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
            transition: box-shadow 0.3s ease;
        }
        .progress {
            height: 10px;
        }
        .badge-available {
            background-color: rgba(16, 185, 129, 0.2);
            color: rgb(5, 150, 105);
        }
        .badge-full {
            background-color: rgba(239, 68, 68, 0.2);
            color: rgb(220, 38, 38);
        }
      /* Underline effect on headings */
h1::after, h2::after, h3::after, h4::after, h5::after, h6::after {
    display: none;
 /* content: '';
  position: absolute;

  left: 0;
  bottom: -5px;
  height: 2px;
  width: 100%;
  background-color: #e45f06;
  transform: scaleX(0);
  transition: transform 0.5s ease;
  animation: draw 0.5s forwards;
  */
}
/*
@keyframes draw {
  from { transform: scaleX(0); }
  to { transform: scaleX(1); }
}

h1:hover::after, h2:hover::after, h3:hover::after, h4:hover::after, h5:hover::after, h6:hover::after {
  transform: scaleX(1);
}

*/
.button-group .btn {
    min-width: 200px; /* Ensure buttons have a consistent width */
    text-align: center; /* Center text and icon inside buttons */
    font-size: 10px; /* Adjust text size if needed */
}

.button-group .btn i {
    font-size: 18px; /* Adjust icon size for balance */
}

    </style>
</head>
<body>
<div class="main_content">
<div class="container py-4">
    <div class="card mb-4">
        <div class="card-body">
       
  <!-- Action Buttons -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row">
    <!-- Title on the left -->
    <h3 class="fw-bold">Project Allocation Dashboard</h3>

    <!-- Buttons on the right -->
    <div class="button-group d-flex flex-wrap">

    <button class="btn btn-primary me-2 px-4 py-2 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#faculty_not_assigned_to_any_project">
        <i class="bi bi-eye me-2"></i>
        <span>faculty not assigned  <!----- faculty not assigned to any project -->  </span>
    </button>
    <button class="btn btn-primary me-2 px-4 py-2 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#remainingStudentsModal">
        <i class="bi bi-eye me-2"></i>
        <span>Show Remaining Students</span>
    </button>

    <button class="btn btn-success px-4 py-2 d-flex align-items-center" onclick="performRandomAllocation()" 
        <?php echo $stats['remaining_students'] == 0 ? 'disabled' : ''; ?>>
        <i class="bi bi-shuffle me-2"></i>
        <span>Start Random Allocation</span>
    </button>
</div>

</div>

        <div class="row g-4 mb-4 d-flex justify-content-center align-items-center">
                <div class="col-md-4 col-6" style="min-width:120px">
                    <div class="bg-primary-subtle rounded-3 p-3">
                        <div class="d-flex align-items-center mb-2 text-primary flex-column flex-sm-row">
                            <i class="bi bi-people-fill me-2"></i>
                            <h3 class="h6 mb-0">Total Students</h3>
                        </div>

                        <h3 class="card-title text-primary fw-bold mb-0"><?php echo $stats['total_students']; ?></h3>
                    </div>
                </div>

                <div class="col-md-4 col-6" style="min-width:120px">
                    <div class="bg-warning-subtle rounded-3 p-3">
                        <div class="d-flex align-items-center mb-2 text-warning flex-column flex-sm-row">
                            <i class="bi bi-mortarboard-fill me-2"></i>
                            <h3 class="h6 mb-0">Remaining Studnet</h3>
                        </div>
                        <h3 class="card-title  text-warning"><?php  echo $stats['remaining_students']; ?></h3>
                       
                    </div>
                </div>
             
                <div class="col-md-4 col-6" style="min-width:120px">
                    <div class="bg-success-subtle rounded-3 p-3">
                        <div class="d-flex align-items-center mb-2 text-success flex-column flex-sm-row">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <h3 class="h6 mb-0">Allocated Students</h3>
                        </div>
                        <h3 class="card-title text-success fw-bold mb-0"><?php echo $stats['total_allocated']; ?></h3>
                      
                    </div>
                </div>

              

         
                    <div class="col-md-4 col-6"  style="min-width:120px">
                    <div class="bg-purple-subtle rounded-3 p-3">
                        <div class="d-flex align-items-center mb-2 text-purple  flex-column flex-sm-row">
                            <i class="bi bi-server me-2"></i>
                            <h3 class="h6 mb-0">Total Capacity</h3>
                        </div>
                        <h3 class="card-title mb-0"><?php echo $stats['total_capacity']; ?></h3>
                    </div>
                </div>

                <div class="col-md-4 col-6">
                    <div class="bg-purple-subtle rounded-3 p-3">
                        <div class="d-flex align-items-center mb-2 text-purple">
                            <i class="bi bi-bookmark-fill me-2"></i>
                            <h3 class="h6 mb-0">Remainig Capacity</h3>
                        </div>
                        <h3 class="card-title mb-0"><?php echo $stats['remaining_project_capacity']; ?></h3>
                    </div>
                </div>

                <div class="col-md-4 col-6" style="min-width:280px;">
    <div class="card-body p-0">
        <form method="POST" action="admin_remening_student.php" onsubmit="return confirm('Are you sure you want to delete all allocations?');">
            <button class="btn btn-danger w-100 h-100 d-flex justify-content-center align-items-center  rounded-3 p-3" name="confirm_delete_all" value="1" type="submit">
                <i class="fa-solid fa-trash-can me-2"></i> Delete All Allocations
            </button>
        </form>
    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" >
    <?php foreach ($projects as $project): ?>
        <?php 
            $allocated_students = getAllocatedStudents($project['p_id'] ?? '');
            $occupancy_percentage = ($project['no_of_student_allocated'] ?? 0) / ($project['max_student'] ?? 1) * 100;
            $remaining_spots = ($project['max_student'] ?? 0) - ($project['no_of_student_allocated'] ?? 0);
        ?>
        <div class="col-md-4 mb-3" >
            <div class="card card-hover h-100" >
                <div class="card-header d-flex justify-content-between align-items-start" >
                    <div >
                        <h5 style="font-weight:bold" class="card-title mb-1"><?php echo htmlspecialchars($project['pname'] ?? 'Unknown Project'); ?></h5>
                        <p class="card-subtitle text-muted small mb-2" style="font-size:15px">
                            Faculty: <?php echo htmlspecialchars($project['fname'] ?? 'Unknown Faculty'); ?> 
                            (FID: <?php echo htmlspecialchars($project['fid'] ?? 'N/A'); ?>)
                        </p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary">
                        ID: <?php echo htmlspecialchars($project['p_id'] ?? 'N/A'); ?>
                    </span>
                </div>
                <div class="card-body"  style="text-align: left;">
                <p class="card-text text-muted small mb-3">
    <?php echo htmlspecialchars($project['pdesc'] ?? 'No description available'); ?>
</p>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Capacity Usage</span>
                            <span class="fw-medium">
                                <?php echo $project['no_of_student_allocated'] ?? 0; ?>/<?php echo $project['max_student'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?php echo $occupancy_percentage; ?>%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="small text-muted"><?php echo $remaining_spots; ?> spots remaining</span>
                            <span class="badge <?php echo $remaining_spots > 0 ? 'badge-available' : 'badge-full'; ?>">
                                <?php echo $remaining_spots > 0 ? 'Available' : 'Full'; ?>
                            </span>
                        </div>
                    </div>
                    <?php if (!empty($allocated_students)): ?>
                        <div class="mt-3">
                            <h6 class="small fw-medium mb-2">Allocated Students:</h6>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($allocated_students as $student): ?>
                                    <span class="badge bg-light text-dark"><?php echo htmlspecialchars($student['name'] ?? 'Unknown Student'); ?> </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>






<!-----------------------------  Modal Reamining student------------------------- -->
<div class="modal fade" id="remainingStudentsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remaining Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="display: flex; gap: 10px;">
        <button onclick="exportFullExcelTable('remainingstudent')" class="btn"><i class="fa-solid fa-file-excel"></i>
        Export to Excel</button>
        <button onclick="printFullTable('remainingstudent')" class="btn"><i class="fa-solid fa-print"></i>
        Print Table</button>
    </div>
    <div class="search-wrapper" style="position: relative; display: inline-block;">
        <input type="text" id="searchInput" class="search-input" placeholder="Search in all columns..." style="padding-left: 30px;">
        <i  class="fas fa-search search-icon"  style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray;"
        ></i>
    </div>
</div>
</div>

<table  id="remainingstudent"  class="searchtable"  class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Registration No</th>
                            <th>Name</th>
                            <th>Section</th>
                            <th>Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($remainingStudents) && !isset($remainingStudents['error'])): ?>
                            <?php foreach ($remainingStudents as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['registration_no']); ?></td>
                                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['section']); ?></td>
                                    <td><?php echo htmlspecialchars($student['semester']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                          
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-----------------------------  Modal Reamining Faculty------------------------- -->
<div class="modal fade" id="faculty_not_assigned_to_any_project" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Faculty Not Assigned To Any Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="display: flex; gap: 10px;">
        <button onclick="exportFullExcelTable('facultyList')" class="btn"><i class="fa-solid fa-file-excel"></i>
        Export to Excel</button>
        <button onclick="printFullTable('facultyList')" class="btn"><i class="fa-solid fa-print"></i>
        Print Table</button>
    </div>
    <div class="search-wrapper" style="position: relative; display: inline-block;">
        <input type="text" id="searchInput" class="search-input" placeholder="Search in all columns..." style="padding-left: 30px;">
        <i  class="fas fa-search search-icon"  style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray;"
        ></i>
    </div>
</div>
</div>
<table id="facultyList" class="searchtable table table-bordered text-center">

    <thead>
        <tr>
            <th>Faculty ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($facultyNotAssigned) && !isset($facultyNotAssigned['error'])): ?>
            <?php foreach ($facultyNotAssigned as $faculty): ?>
                <tr>
                    <td><?php echo htmlspecialchars($faculty['fid']); ?></td>
                    <td><?php echo htmlspecialchars($faculty['fname']); ?></td>
                    <td><?php echo htmlspecialchars($faculty['email']); ?></td>
                    <td><?php echo htmlspecialchars($faculty['mobile']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
          
        <?php endif; ?>
    </tbody>
</table>

            </div>
        </div>
    </div>
</div>
                        </div>
                        

<script>
    function performRandomAllocation() {
        if (confirm("Are you sure you want to start the random allocation process?")) {
            fetch('./random_allocation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=random_allocation'
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);  // Log the response data for debugging
                alert(data.message);
                if (data.status === 'success') {
                    location.reload();
                }
            })
            .catch(error => {
                console.error("Error during random allocation:", error);
                alert("An unexpected error occurred. Please check the console for details.");
            });
        }
    }
</script>


<?php
// table link 
include('../admin/adminfooter.php');
?>
