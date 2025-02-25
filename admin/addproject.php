<?php 
session_start();
include('../admin/adminsidebar.php');


// upload using excel

// require '../vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addproject'])) {

//     if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
//         $fileName = $_FILES['excelFile']['tmp_name'];

//         try {

//             $spreadsheet = IOFactory::load($fileName);
        
//             // Get the active sheet (first sheet)
//             $sheet = $spreadsheet->getActiveSheet();
//             $data = $sheet->toArray();
            
//             // Prepare the SQL insert statement
//             $stmt = $con->prepare("INSERT INTO project (p_id, pname, pdesc, fid, max_student, no_of_student_allocated,semester) VALUES (?, ?, ?, ?, ?, ?,?)");
            
//             // Iterate over each row of the Excel file
//             foreach ($data as $key => $row) {
//                 // Skip the header row if it exists
//                 if ($key == 0) continue;

//                 // Check if any required field is empty
//                 if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4]) && !empty($row[5])) {
//                     // Bind the Excel data to the SQL statement
//                     $stmt->bind_param("ssssss", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);

//                     // Execute the SQL statement
//                     $stmt->execute();
//                 } else {
//                     echo "<script>alert('Empty fields found in the Excel sheet. Please check the data.')</script>";
//                 }
//             }

//             $stmt->close();
//             echo "<script>alert('Data has been uploaded successfully!')</script>";

//         } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
//             echo "<script>alert('Error loading file: ".$e->getMessage()."')</script>";
//         }
//     } else {
//         echo "<script>alert('Please upload a valid Excel file.')</script>";
//     }
// }



// Function to generate a unique 15-digit project ID
function generateUniqueProjectId($con) {
    do {
        $p_id = str_pad(mt_rand(0000000000, 9999999999), 10, '0', STR_PAD_LEFT);
        $check_sql = "SELECT `p_id` FROM `project` WHERE `p_id` = '$p_id'";
        $result = $con->query($check_sql);
    } while ($result->num_rows > 0);

    return $p_id;
}

// Handle project addition
if (isset($_POST['addproject'])) {

    $p_id = generateUniqueProjectId($con);
    $pname = $_POST['pname'];
    $pdesc = $_POST['pdesc'];
    $fid = $_POST['fid']; // Corrected to $_POST['fid']
    $max_student = intval($_POST['max_no_of_student']);
    $no_of_student_allocated = 0;

    $semester = $_SESSION['semester'] ?? '';
    $sql = "INSERT INTO `project` (`p_id`, `pname`, `pdesc`, `fid`, `max_student`, `no_of_student_allocated`, `semester`) 
    VALUES ('$p_id', '$pname', '$pdesc', '$fid', '$max_student', '$no_of_student_allocated', '$semester')";
    

    if ($con->query($sql) === TRUE) {
        ?>
        <script>
            alert('New project added successfully');
            window.location.href = 'addproject.php'; // Redirect to the current page
        </script>
        <?php
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Handle project deletion
if (isset($_POST['delete'])) {
    $p_id_to_delete = $_POST['p_id'];

    $delete_sql = "DELETE FROM `project` WHERE `p_id` = '$p_id_to_delete'";

    if ($con->query($delete_sql) === TRUE) {
        ?>
        <script>
            alert('Project deleted successfully');
            window.location.href = 'addproject.php'; // Redirect to the current page
        </script>
        <?php
    } else {
        echo "Error: " . $delete_sql . "<br>" . $con->error;
    }
}


// Delete all project
if (isset($_POST['deleteallproject'])) {
    $deleteallproject = "DELETE FROM project";
    if (mysqli_query($con, $deleteallproject)) {
        echo "<script>alert('All Projects have been deleted successfully');</script>";
    } else {
        echo "Error: " . $deleteallproject . "<br>" . mysqli_error($con);
    }
}
?>



<?php



// Add domain type addition
if (isset($_POST['add_domain'])) {
    $domain_type = $_POST['domain_type'];

    // Prepare the insert statement
    $stmt = $con->prepare("INSERT INTO admin_add_contain (project_domain_type) VALUES (?)");
    $stmt->bind_param("s", $domain_type);

    // Execute and check for success
    if ($stmt->execute()) {
        $success_message = "Domain type added successfully!";
    } else {
        $error_message = "Error adding domain type: " . $stmt->error;
    }

    $stmt->close(); // Close the statement
}

// Handle domain type deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $con->prepare("DELETE FROM admin_add_contain WHERE sr_no = ?");
    $stmt->bind_param("i", $id);  
    if ($stmt->execute()) {
        $success_message = "Domain type deleted successfully!";
    } else {
        $error_message = "Error deleting domain type: " . $stmt->error;
    }
    $stmt->close(); 
}
$fetch_query = "SELECT * FROM admin_add_contain ORDER BY sr_no DESC";
$result = $con->query($fetch_query); 
?>

<!-- Modal -->
<div class="modal fade" id="addproject" tabindex="-1" aria-labelledby="addproject" aria-hidden="true">
  <div class=" modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"  style="font-weight:bold">Upload Faculty Excel sheet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="row g-3 m-3" method="POST" enctype="multipart/form-data" action="">
                <div class="col-md-6">
                    <label for="validationDefault01" class="form-label">Upload file</label>
                    <input type="file" class="form-control" name="excelFile" value="" required>
                </div>
           <h5 class="text-bold">Note: <span> <u>formate of excel should be project name,project description, max student no, faculty id</u></span></h5>
                <div class="col-12 mt-5">
                    <button class="btn btn-primary" name="admin_add_project" type="submit">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           
        </form>
      </div>
    </div>
  </div>
</div>


</div>



<div class="main_content">
    

<h3 class="mt-5 text-center mb-3" style="font-weight:bold">Project Details</h3>

 
       <!-- Button trigger modal 
       <button type="button" class="btn btn-success" id="btnorange" style="font-weight:bolder; width:200px" data-toggle="modal" data-target="#addproject">
       <i class="fas fa-plus"></i> Upload excel File
       </button>
       -->
       <!-- Form to handle delete all faculty request -->


    

           
     
 
        <!-- Add Domain Form -->
        <div id="addDomainForm" style="display: none;">
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Add New Project Domain Type</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="domain_type" class="form-label">Domain Type</label>
                            <input type="text" class="form-control" id="domain_type" name="domain_type" required>
                        </div>
                        <button type="submit" name="add_domain" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Domain Type
                        </button>
                    </form>
                </div>
            </div>
        </div>

       <!-- Domain List -->
<div id="domainList" style="display: none;">
    <div class="card mb-3" >
        <div class="card-header">
            <h5>Project Domain Types</h5>
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="projectlist" class="searchtable table table-hover">
                        <thead class="table-light">
        
                            <tr>
                                <th>Sr No.</th>
                                <th>Domain Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $serial_no = 1; // Initialize serial number
                            while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo $serial_no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['project_domain_type']); ?></td>
                                    <td>
                                        <a href="?delete=<?php echo $row['sr_no']; ?>" 
                                           class="btn btn-sm" id="btnred"
                                           onclick="return confirm('Are you sure you want to delete this domain type?')">
                                           <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center">No domain types found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

    <script>
    function showAddForm() {
        document.getElementById('addDomainForm').style.display = 'block';
        document.getElementById('domainList').style.display = 'none';
    }

    function showDomainList() {
        document.getElementById('addDomainForm').style.display = 'none';
        document.getElementById('domainList').style.display = 'block';
    }
    </script>



           </div>

           <div class="main_content">
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center w-100" style="font-weight:bold; color: #e45f06;">
                        <i class="fas fa-folder-plus"></i> Add Project
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
            <form class="row g-3 m-3" method="POST">
                <div class="col-md-6">
                    <label for="validationDefault01" class="form-label">Project Name</label>
                    <input type="text" class="form-control" id="validationDefault01" name="pname" required>
                </div>
                <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Project Description</label>
                    <input type="text" class="form-control" id="validationDefault02" name="pdesc" required>
                </div>
                <div class="col-md-6">
                    <label for="validationDefault05" class="form-label">Max Number of Students</label>
                    <input type="number" class="form-control" id="validationDefault05" name="max_no_of_student" required>
                </div>
                <div class="col-md-6">
                    <label for="validationDefault05" class="form-label">Faculty Id</label>
                    <input type="text" class="form-control" id="validationDefault05" name="fid" required>
                </div>
                <div class="col-12 mt-5">
                    <button class="btn btn-primary" name="addproject" id="btnorange" type="submit">Add Project</button>
                </div>
            </form>
        </div>
    </div>
    </div>
        </div>

    
    <div class="container py-4">
    <form method="POST">
    <button class="btn" name="deleteallproject" id="btnred" type="submit" 
            onclick="return confirm('Are you sure you want to delete all Projects records?');"> <i class="fa-solid fa-trash-can"></i>
        Delete All Projects
    </button>
</form>
        <div class="card shadow">
            
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                
            <div class="d-flex align-items-center mb-2 mb-md-0">
                  
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                    <div class="d-flex gap-2">
                        
                        <button onclick="exportExcelWithoutLastColumn('projectlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-file-excel"></i> Excel
                        </button>
                        <button onclick="printTableWithoutLastColumn('projectlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-print"></i> Print
                        </button>

                        <button type="button" class="btn" id="btnorange" data-bs-toggle="modal" data-bs-target="#addProjectModal">
       <i class="fa-solid fa-folder-plus"></i>  Add Project
    </button>

    <button class="btn" id="btnorange" onclick="showAddForm()">
                    <i class="fas fa-plus-circle me-2"></i>Add Domain Type
                </button>
                <button class="btn" id="btnorange" onclick="showDomainList()">
                    <i class="fas fa-list"></i>View Domain Types
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
                    <table id="projectlist" class="searchtable table table-hover">
                        <thead class="table-light">
            <tr>
                <th scope="col">Sr no.</th>
                <th scope="col">Project Id</th>
                <th scope="col">Project Name</th>
                <th scope="col">Project Description</th>
                <th scope="col">Faculty ID</th>
                <th scope="col">Faculty Name</th>
                <th scope="col">Semester</th>
                <th scope="col">Max No Student</th>
                <th scope="col">No of Student Allocation</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
$serial_no = 1; // Initialize the serial number
$semester = $_SESSION['semester'] ?? ''; // Get the semester from session

// Prepare the SQL query
if ($semester === "all") {
    $stmt = $con->prepare("
        SELECT 
            p.p_id, p.pname, p.pdesc, p.fid, f.fname, p.semester, p.max_student, p.no_of_student_allocated 
        FROM 
            project p
        JOIN 
            faculty f
        ON 
            p.fid = f.fid
    ");
} else {
    $stmt = $con->prepare("
        SELECT 
            p.p_id, p.pname, p.pdesc, p.fid, f.fname, p.semester, p.max_student, p.no_of_student_allocated 
        FROM 
            project p
        JOIN 
            faculty f
        ON 
            p.fid = f.fid
        WHERE 
            p.semester = ?
    ");
    $stmt->bind_param("s", $semester);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $serial_no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['p_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pdesc']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
        echo "<td>" . htmlspecialchars($row['max_student']) . "</td>";
        echo "<td>" . htmlspecialchars($row['no_of_student_allocated']) . "</td>";

        // Delete Button
        echo "<td>
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='p_id' value='" . htmlspecialchars($row['p_id']) . "'>
                <button type='submit' name='delete' id='btnred' class='btn btn-danger' 
                        onclick=\"return confirm('Are you sure you want to delete this project?');\">
                    <i class='fa-solid fa-trash-can'></i> Delete
                </button>
            </form>
        </td>";

        echo "</tr>";
    }
} else {
    // Ensure it spans exactly 10 columns
    echo "<tr><td colspan='10' class='text-center'>No projects found.</td></tr>";
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
<?php
// table link 
include('../admin/adminfooter.php');
?>




