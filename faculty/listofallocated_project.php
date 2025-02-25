<?php 

include('../faculty/facultysidebar.php');



// Ensure faculty is logged in
if (!isset($_SESSION['fid'])) {
    die("Access Denied: Faculty not logged in.");
}

// Get faculty id from the session
$fid = $_SESSION['fid'];

// Retrieve year and semester from the session or use a default value if not set
$work_year = $_SESSION['work_year'] ?? "All";
$work_sem = $_SESSION['work_sem'] ?? "All";

// Handle year and semester selection form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use isset to avoid undefined array key warnings
    $work_year = isset($_POST['work_year']) ? $_POST['work_year'] : "All";
    $work_sem = isset($_POST['work_sem']) ? $_POST['work_sem'] : "All";

    // Save the selected values in the session
    $_SESSION['work_year'] = $work_year;
    $_SESSION['work_sem'] = $work_sem;
}

// selected year and semester
$where_conditions = "";
if (strtoupper($work_year) != "ALL") { // Case-insensitive check
    $where_conditions .= " AND ap.year = '$work_year'";
}
if (strtoupper($work_sem) != "ALL") { // Case-insensitive check
    $where_conditions .= " AND ap.semester = '$work_sem'";
}

$query = "
    SELECT 
        p.p_id, p.pname, p.pdesc, p.max_student, p.project_type,
        s.registration_no, s.name, s.email, s.mobile_no,
        n.message, n.datetime, ap.year, ap.semester, ap.section,
        f.fname  -- Assuming 'fname' is stored in a 'faculty' table
    FROM 
        allocated_project ap
    JOIN 
        project p ON ap.p_id = p.p_id
    JOIN 
        student s ON ap.registration_no = s.registration_no
    LEFT JOIN 
        notifications n ON s.registration_no = n.registration_no AND p.p_id = n.p_id
    JOIN
        faculty f ON ap.fid = f.fid  -- Join with the faculty table to get the 'fname'
    WHERE 
        ap.fid = '$fid' $where_conditions
    ORDER BY 
        s.name ASC";

$result = mysqli_query($con, $query);

// Debugging query execution
if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $p_id = $_POST['p_id'];
    $registration_no = $_POST['registration_no'];
    $action = $_POST['action']; // 'allow' or 'decline'

    if ($action === 'decline') {
        // Delete the student's record from allocated_project table
        $deleteQuery = "DELETE FROM allocated_project WHERE registration_no = '$registration_no' AND p_id = '$p_id'";
        if (mysqli_query($con, $deleteQuery)) {
            // Update student allocation count (-1)
            if (updateStudentAllocation($con, $p_id, false)) {
                // Save the notification about the decline
                $message = "Project ID: $p_id has been Declined.";
                saveNotification($con, $registration_no, $p_id, $message);
                echo "<script>alert('Student declined and record deleted successfully.');</script>";
            } else {
                echo "<script>alert('Failed to update student allocation.');</script>";
            }
        } else {
            echo "<script>alert('Error deleting record: " . mysqli_error($con) . "');</script>";
        }
    } else { // Allow action
        // Update the allocated_project table to mark the action as allowed
        $updateAllocatedQuery = "UPDATE allocated_project SET action = 'Allocated' WHERE registration_no = '$registration_no' AND p_id = '$p_id'";
        if (mysqli_query($con, $updateAllocatedQuery)) {
            // Update student allocation count (+1)
            if (updateStudentAllocation($con, $p_id, true)) {
                // Update the notification message to 'Allowed'
                $message = "Project ID: $p_id has been Allowed.";
                saveNotification($con, $registration_no, $p_id, $message);
                echo "<script>alert('Student has been allowed to continue with the project.');</script>";
            } else {
                echo "<script>alert('Failed to update student allocation.');</script>";
            }
        } else {
            echo "<script>alert('Error updating allocated project action: " . mysqli_error($con) . "');</script>";
        }
    }
}


// Function to save or update the notification with a p_id reference
function saveNotification($con, $registration_no, $p_id, $message = 'Pending') {
    // Set the timezone to India Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata');

    // Get the current date and time in the specified format
    $currentDateTime = date('y-m-d H:i:s');

    // Check if a notification already exists
    $checkQuery = "SELECT * FROM notifications WHERE registration_no = '$registration_no' AND p_id = '$p_id'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Update the existing notification
        $updateQuery = "UPDATE notifications SET message = '$message', datetime = '$currentDateTime' WHERE registration_no = '$registration_no' AND p_id = '$p_id'";
        mysqli_query($con, $updateQuery);
    } else {
        // Insert a new notification with default message 'Pending' and the current datetime
        $insertQuery = "INSERT INTO notifications (registration_no, p_id, message, datetime) VALUES ('$registration_no', '$p_id', '$message', '$currentDateTime')";
        mysqli_query($con, $insertQuery);
    }
}

// Function to update the number of students allocated to a project
function updateStudentAllocation($con, $p_id, $increment = true) {
    // Fetch the current number of allocated students
    $query = "SELECT no_of_student_allocated FROM project WHERE p_id = '$p_id'";
    $result = mysqli_query($con, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $currentCount = $row['no_of_student_allocated'];

        if ($increment) {
            $newCount = $currentCount + 1;
        } else {
            // Ensure the count does not go below 0
            $newCount = max(0, $currentCount - 1);
        }

        // Update the count in the project table
        $updateQuery = "UPDATE project SET no_of_student_allocated = '$newCount' WHERE p_id = '$p_id'";
        if (mysqli_query($con, $updateQuery)) {
            return true;
        } else {
            error_log("Failed to update student allocation: " . mysqli_error($con));
            return false;
        }
    } else {
        error_log("Failed to fetch current allocation count: " . mysqli_error($con));
        return false;
    }
}


?>



     
   
 

    <div class="container py-3">
        <div class="main_content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Project Allocation Dashboard</h3>
                    <p class="text-muted mb-0">Manage and monitor student project assignments</p>
                </div>
                <div>
                    <span class="badge bg-light text-dark">
                        <i class="far fa-calendar-alt me-1"></i>
                        <?php echo date('F j, Y'); ?>
                    </span>
                </div>
            </div>
            

            <div class="card filter-card my-4 shadow-sm">
                <div class="card-body">
                    <div class="filter-heading" style="  font-size: 1rem;">
                        <i class="fas fa-filter me-2 text-primary"></i>Filter Options
                    </div>
                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="workYear" class="form-label">Academic Year</label>
                                <select class="form-select shadow-none" id="workYear" name="work_year" required>
                                    <option value="ALL" <?php echo ($work_year == "ALL") ? "selected" : ""; ?>>All Years</option>
                                    <?php
                                    $current_year = date('Y'); 
                                    for ($year = $current_year; $year >= $current_year - 10; $year--) {
                                        echo "<option value='$year' " . ($work_year == $year ? "selected" : "") . ">$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="workSem" class="form-label">Semester</label>
                                <select class="form-select shadow-none" id="workSem" name="work_sem" required>
                                    <option value="ALL" <?php echo ($work_sem == "ALL") ? "selected" : ""; ?>>All Semesters</option>
                                    <?php
                                    $sem_labels = [
                                        3 => "PBL-1",
                                        4 => "PBL-2",
                                        5 => "PBL-3",
                                        6 => "MINOR",
                                        7 => "",
                                        8 => "MAJOR"
                                    ];

                                    foreach ($sem_labels as $sem => $label) {
                                        echo "<option value='$sem' " . ($work_sem == $sem ? "selected" : "") . ">$sem ($label)</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn w-100 btn-icon-text" id="btnorange" type="submit">
                                    <i class="fas fa-search"></i>
                                    <span>Apply Filters</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <i class="fas fa-users me-2 text-primary"></i>
                    <h5 class="mb-0 fw-bold">Student Project Allocations</h5>
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                    <div class="d-flex gap-2">
                        <button onclick="exportExcelWithoutLastColumn('Allocatedlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-file-excel"></i> Export Excel
                        </button>
                        <button onclick="printTableWithoutLastColumn('Allocatedlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                    </div>
                    <div class="search-wrapper mt-2 mt-md-0">
                        <input type="text" id="searchInput" class="search-input" placeholder="Search in all columns...">
                        <i class="fas fa-search search-icon" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: #adb5bd;"></i>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="Allocatedlist" class="searchtable table table-hover">
                        <thead  class="table-light">
                            <tr>
                                <th width="3%">#</th>
                                <th width="15%">Student</th>
                                <th width="22%">Project Details</th>
                                <th width="12%">Faculty</th>
                                <th width="15%">Academic Info</th>
                                <th width="18%">Contact</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $serial_no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Fetch the action status for the specific registration_no from the allocated_project table
                            $registration_no = $row['registration_no'];
                            $actionStatusQuery = "SELECT action FROM allocated_project WHERE registration_no = '$registration_no'";
                            $actionStatusResult = mysqli_query($con, $actionStatusQuery);
                            $actionRow = mysqli_fetch_assoc($actionStatusResult);
                            $actionStatus = isset($actionRow['action']) ? $actionRow['action'] : null;

                            // Assign highlight class based on the message in the row (Allowed/Declined)
                            $rowClass = '';
                            if ($row['message']) {
                                if (strpos($row['message'], 'Declined') !== false) {
                                    $rowClass = 'status-declined';
                                } elseif (strpos($row['message'], 'Allowed') !== false) {
                                    $rowClass = 'status-allowed';
                                }
                            }

                            echo "<tr class='$rowClass'>";
                            echo "<td>" . htmlspecialchars($serial_no++) . "</td>";
                            
                            echo "<td>
                                    <div class='d-flex flex-column'>
                                        <span class='fw-semibold'>" . htmlspecialchars($row['name']) . "</span>
                                        <small class='text-muted'>" . htmlspecialchars($row['registration_no']) . "</small>
                                    </div>
                                  </td>";
                            
                            echo "<td>
                                    <div class='d-flex flex-column'>
                                        <span class='fw-semibold'>" . htmlspecialchars($row['pname']) . "</span>
                                        <small class='text-muted'>" . htmlspecialchars(substr($row['pdesc'], 0, 50)) . (strlen($row['pdesc']) > 50 ? '...' : '') . "</small>
                                        <span class='badge bg-light text-dark mt-1'>" . htmlspecialchars($row['project_type']) . "</span>
                                    </div>
                                  </td>";
                            
                            echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
                    
                            echo "<td>
                                    <div class='d-flex flex-column'>
                                        <div><small class='text-muted'>Section:</small> " . htmlspecialchars($row['section']) . "</div>
                                        <div><small class='text-muted'>Semester:</small> " . htmlspecialchars($row['semester']) . "</div>
                                        <div><small class='text-muted'>Year:</small> " . htmlspecialchars($row['year']) . "</div>
                                    </div>
                                  </td>";
                            
                            echo "<td>
                                    <div class='d-flex flex-column'>
                                        <div class='text-truncate' style='max-width: 200px;'><i class='far fa-envelope text-muted me-1'></i> " . htmlspecialchars($row['email']) . "</div>
                                        <div><i class='fas fa-phone text-muted me-1'></i> " . htmlspecialchars($row['mobile_no']) . "</div>
                                    </div>
                                  </td>";
                            
                            echo "<td>";
                            
                            if ($actionStatus === 'Allocated') {
                                echo "<span class='badge bg-success px-3 py-2'>
                                        <i class='fas fa-check-circle me-1'></i>Allocated
                                      </span>";
                            } elseif ($actionStatus === null || $actionStatus === '') {
                                echo "<form method='POST' action='' class='table-action-form text-center p-3' onsubmit='return confirmAction(this)' style='max-width: 400px; margin: auto;'>

                                <!-- Action Selection -->
                                <div class='d-flex justify-content-center gap-4 align-items-center mb-3'>
                        
                                    <!-- Allow Option -->
                                    <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='action' id='allow_".$row['registration_no']."' value='allow' " . (strpos($row['message'], 'Allowed') !== false ? 'checked' : '') . " required>
                                        <label class='form-check-label fw-semibold' for='allow_".$row['registration_no']."'>
                                          <i class='fas fa-check-circle' style='color: green;'></i>
                                        </label>
                                    </div>
                        
                                    <!-- Decline Option -->
                                    <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='action' id='decline_".$row['registration_no']."' value='decline' " . (strpos($row['message'], 'Declined') !== false ? 'checked' : '') . ">
                                        <label class='form-check-label fw-semibold' for='decline_".$row['registration_no']."'>
                                           <i class='fas fa-times-circle' style='color: red;'></i>
                                        </label>
                                    </div>
                        
                                </div>
                        
                                <!-- Hidden Inputs -->
                                <input type='hidden' name='p_id' value='" . htmlspecialchars($row['p_id']) . "'>
                                <input type='hidden' name='registration_no' value='" . htmlspecialchars($row['registration_no']) . "'>
                        
                                <!-- Submit Button -->
                                <button id='btnorange' type='submit' class='btn  fw-bold py-2 shadow-sm' >
                                      
                                    Submit
                                </button>
                        
                            </form>";
                        
                                    
                            } else {
                                echo "<span class='badge bg-warning px-3 py-2'>
                                        <i class='fas fa-clock me-1'></i>Pending
                                      </span>";
                            }
                            
                            echo "</td>";
                            
                            echo "</tr>";
                        }

                        
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
    <script>
        // Confirmation dialog before submitting allocation decisions
        function confirmAction(form) {
            const action = form.querySelector('input[name="action"]:checked').value;
            const actionText = action === 'allow' ? 'allow' : 'decline';
            const regNo = form.querySelector('input[name="registration_no"]').value;
            
            return confirm(`Are you sure you want to ${actionText} this project allocation for student (${regNo})?`);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();
                const table = document.getElementById('Allocatedlist');
                const rows = table.getElementsByTagName('tr');
                
                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let found = false;
                    
                    for (let j = 0; j < cells.length - 1; j++) {
                        if (cells[j].textContent.toLowerCase().indexOf(searchText) > -1) {
                            found = true;
                            break;
                        }
                    }
                    
                    rows[i].style.display = found ? '' : 'none';
                }
            });
        });

    </script>

<?php

include('../faculty/facultyfooter.php');

?>