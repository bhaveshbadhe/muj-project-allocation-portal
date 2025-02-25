<?php
session_start();
include('../admin/adminsidebar.php');

if (!isset($_SESSION['id'])) {
    die("Access Denied: Admin not logged in.");
}

$admin_id = $_SESSION['id'];

// Retrieve the semester stored in the session
$semester = $_SESSION['semester'] ?? '';

// Ensure 'work_year' has a default value in the session
if (!isset($_SESSION['work_year'])) {
    $_SESSION['work_year'] = "All"; // Default value
}
$work_year = $_SESSION['work_year'];

// Handle year selection form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['work_year'])) {
    $work_year = $_POST['work_year'];
    $_SESSION['work_year'] = $work_year;
}

// Build the WHERE conditions
$where_conditions = "1"; // Default condition (always true)

if ($semester !== "all") {
    $where_conditions .= " AND s.semester = '$semester'";
}

if ($work_year !== "All") {
    $where_conditions .= " AND s.year = '$work_year'";
}

// Query to fetch selected students data
$query = "
    SELECT
        ap.*, 
        p.pname, p.pdesc, p.max_student, 
        s.name, s.email, s.mobile_no, 
        n.message, n.datetime, 
        s.semester, s.section, s.year
    FROM 
        allocated_project ap
    JOIN 
        project p ON ap.p_id = p.p_id
    JOIN 
        student s ON ap.registration_no = s.registration_no
    LEFT JOIN 
        notifications n ON s.registration_no = n.registration_no AND p.p_id = n.p_id
    WHERE 
        $where_conditions
    ORDER BY 
        p.p_id";

$result = mysqli_query($con, $query);
$serial_no = 1;

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

function updateStudentAllocation($con, $p_id, $increment) {
    $operation = $increment ? '+' : '-'; // Determine whether to increment or decrement
    $query = "UPDATE project SET no_of_student_allocated = no_of_student_allocated $operation 1 WHERE p_id = '$p_id'";
    
    return mysqli_query($con, $query); // Return the result of the query execution
}

function saveNotification($con, $registration_no, $p_id, $message) {
    $query = "INSERT INTO notifications (registration_no, p_id, message) VALUES ('$registration_no', '$p_id', '$message')";
    return mysqli_query($con, $query); // Return the result of the query execution
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $p_id = $_POST['p_id'];
    $registration_no = $_POST['registration_no'];
    $action = $_POST['action']; // 'allow' or 'decline'

    if ($action === 'decline') {
        // Delete the student's record
        $deleteQuery = "DELETE FROM allocated_project WHERE registration_no = '$registration_no' AND p_id = '$p_id'";
        if (mysqli_query($con, $deleteQuery)) {
            if (updateStudentAllocation($con, $p_id, false)) {
                $message = "Project ID: $p_id has been Declined.";
                saveNotification($con, $registration_no, $p_id, $message);
                echo "<script>alert('Student declined and record deleted successfully.');</script>";
            } else {
                echo "<script>alert('Failed to update student allocation.');</script>";
            }
        } else {
            echo "<script>alert('Error deleting record: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Handle 'allow' action
        if (updateStudentAllocation($con, $p_id, true)) {
            $message = "Project ID: $p_id has been Allowed.";
            saveNotification($con, $registration_no, $p_id, $message);
            echo "<script>alert('Student has been allowed to continue with the project.');</script>";
        } else {
            echo "<script>alert('Failed to update student allocation.');</script>";
        }
    }
}
?>



<div class="main_content">
    <h3 class="text-center mt-5" style="font-weight: bold">List of Projects Selected by Students</h3>
    <form method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-2">
                <label for="workYear" class="form-label">Work Year</label>
<select class="form-control" id="workYear" name="work_year" required>
    <option value="All" <?php echo ($work_year == "All") ? "selected" : ""; ?>>All</option>
    <?php
    $currentYear = date("Y"); // Get the current year
    for ($year = $currentYear; $year >= $currentYear - 10; $year--) { 
        echo "<option value='$year' " . ($work_year == $year ? "selected" : "") . ">$year</option>";
    }
    ?>
</select>


            </div>
            <div class="col-md-2">
                    <label for="validationDefault01" class="form-label">Semester</label>
                    <input type="text" class="form-control" id="workSem" name="work_sem" value="<?php echo htmlspecialchars($semester); ?>" readonly>
                </div>
            <div class="col-md-2 mt-5">
            <select id="sectionFilter" class="form-select">
            <option value="">Filter by Section</option>
        </select>
                </div>
            <div class="col-md-2 mt-4">
                <button class="btn btn-primary" id="btnorange" type="submit">Filter</button>
            </div>
       
        </div>
    </form>

   
    <div class="card shadow">
            
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                
            <div class="d-flex align-items-center mb-2 mb-md-0">
                  
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                    <div class="d-flex gap-2">
 
                        <button onclick="exportExcelWithoutLastColumn('Allocatedlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-file-excel"></i> Excel
                        </button>
                        <button onclick="printTableWithoutLastColumn('Allocatedlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-print"></i> Print
                        </button>

           
                    </div>
                    <div class="search-wrapper" style="position: relative; display: inline-block;">
        <input type="text" id="searchInput" class="search-input" placeholder="Search in all columns..." style="padding-left: 30px;">
        <i  class="fas fa-search search-icon"  style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray;"
        ></i>
    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="Allocatedlist" class="searchtable table table-hover">
                        <thead class="table-light">
        <tr>
        <tr>
            <th>Sr No.</th>
            <th>Student Name</th>
            <th>Student Enrollment No</th>
            <th>Student Email</th>
            <th>Student Mobile No</th>
            <th>Faculty Id</th>
            <th>Project Title</th>
        <!---    <th>Project Description</th>   -->
            <th>Max Students Allowed</th>
            <th>Date time</th>
            <th>Section</th>
            <th>Semester</th>
            <th>Year</th>
             <th>Action </th> 
        </tr>
    </thead>
    <tbody>
        <?php 
        $serial_no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
             $sections[] = $row['section']; // Collect sections dynamically
            echo "<tr data-section='{$row['section']}'>";
            echo "<td>" . htmlspecialchars($serial_no++) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['registration_no']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['mobile_no']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fid']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pname']) . "</td>";
        /*    echo "<td>" . htmlspecialchars($row['pdesc']) . "</td>";    */
            echo "<td>" . htmlspecialchars($row['max_student']) . "</td>";
            echo "<td>" . htmlspecialchars($row['datetime']) . "</td>";
            echo "<td>" . htmlspecialchars($row['section']) . "</td>";
            echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
            echo "<td>" . htmlspecialchars($row['year']) . "</td>";

           echo "<td>
    <form method='POST' action='' onsubmit='return confirmAction(this)'>
        <input type='radio' name='action' value='allow' " . (strpos($row['message'], 'Allowed') !== false ? 'checked' : '') . " required> Allow<br>
        <input type='radio' name='action' value='decline' " . (strpos($row['message'], 'Declined') !== false ? 'checked' : '') . "> Decline<br>
        <input type='hidden' name='p_id' value='" . htmlspecialchars($row['p_id']) . "'>
        <input type='hidden' name='registration_no' value='" . htmlspecialchars($row['registration_no']) . "'>
        <button type='submit' class='btn mt-2' id='btnorange'>Submit</button>
    </form>
</td>";

            echo "</tr>";
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
    </div>
    </div>
    </div>
<script>
    function confirmAction(form) {
        return confirm("Are you sure you want to perform this action?");
    }
</script>


<?php
// table link 
include('../admin/adminfooter.php');
?>

