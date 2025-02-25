<?php
session_start();
include('../admin/adminsidebar.php');

// Add faculty using an Excel sheet
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_faculty_excel'])) {
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
            $fileName = $_FILES['excelFile']['tmp_name'];

            try {
                // Load the Excel file
                $spreadsheet = IOFactory::load($fileName);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();

                // Fetch all existing fids in a single query
                $existingFids = [];
                $result = $con->query("SELECT fid FROM faculty");
                while ($row = $result->fetch_assoc()) {
                    $existingFids[] = $row['fid'];
                }

                // Prepare the SQL insert statement
                $stmt = $con->prepare("INSERT INTO faculty (fid, fname, email, mobile, specialization, designation, password) VALUES (?, ?, ?, ?, ?, ?, ?)");

                $insertCount = 0;
                $errorMessages = [];
                
                foreach ($data as $key => $row) {
                    // Skip the header row
                    if ($key == 0) continue;

                    // Read values from the Excel file
                    $fid = trim($row[0] ?? '');
                    $fname = trim($row[1] ?? ''); // Column B (fname)
                    $email = trim($row[2] ?? ''); // Column C (outlook/email)
                    $mobile = trim($row[3] ?? ''); // Column D (mobile)
                    $specialization = trim($row[4] ?? ''); // Column E (specialization)
                    $designation = trim($row[5] ?? ''); // Column F (designation)

                    // Validate mandatory fields
                    if (empty($fid) || empty($fname) || empty($email)) {
                        $errorMessages[] = "Skipping row " . ($key + 1) . ": Mandatory fields (fid, fname, email) missing.";
                        continue;
                    }

                    // Skip if fid already exists
                    if (in_array($fid, $existingFids)) {
                        $errorMessages[] = "Skipping row " . ($key + 1) . ": Faculty ID already exists.";
                        continue;
                    }

                    // Generate password by reversing fid and hashing it
                    $reversed_fid = strrev($fid);
                    $hashed_password = password_hash($reversed_fid, PASSWORD_DEFAULT);

                    // Insert the valid row into the database
                    $stmt->bind_param("sssssss", $fid, $fname, $email, $mobile, $specialization, $designation, $hashed_password);
                    if ($stmt->execute()) {
                        $existingFids[] = $fid;
                        $insertCount++;
                    } else {
                        $errorMessages[] = "Skipping row " . ($key + 1) . ": Database insertion error.";
                    }
                }

                // Close statement
                $stmt->close();

                // Show error messages if any
                if (!empty($errorMessages)) {
                    echo "<script>alert('" . implode("\\n", $errorMessages) . "');</script>";
                }

                // Show success message
                echo "<script>alert('Total $insertCount records were added successfully.');</script>";
                
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                echo "<script>alert('Error reading Excel file: " . $e->getMessage() . "');</script>";
            }
        } else {
            echo "<script>alert('Error: No file uploaded or invalid file.');</script>";
        }
    } 
}


// Add a faculty manually
if (isset($_POST['addfaculty'])) {
    $fid = mysqli_real_escape_string($con, $_POST['fid']);
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $outlook = mysqli_real_escape_string($con, $_POST['outlook']);
    $mnumber = mysqli_real_escape_string($con, $_POST['mnumber']);
    $specialization = mysqli_real_escape_string($con, $_POST['specialization']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);

    // Reverse fid and hash it for password
    $reversed_fid = strrev($fid);
    $hashed_password = password_hash($reversed_fid, PASSWORD_DEFAULT);

    if (empty($fname)) {
        echo "<script>alert('Please enter faculty name');</script>";
    } elseif (isfidexist($fid, $con)) {
        echo "<script>alert('Faculty ID number already exists');</script>";
    } elseif (is_null($fid)) {
        echo "<script>alert('Faculty ID (fid) is missing. Please ensure you are logged in correctly.');</script>";
    } else {
        $insertquery = "INSERT INTO faculty (fid, password, fname, email, mobile, specialization, designation) VALUES ('$fid', '$hashed_password', '$fname', '$outlook', '$mnumber', '$specialization', '$designation')";
        if (mysqli_query($con, $insertquery)) {
            $_SESSION['fname'] = $fname;
            echo "<script>alert('New faculty added successfully');</script>";
        } else {
            echo "Error: " . $insertquery . "<br>" . mysqli_error($con);
        }
    }
}


    // Edit faculty details
    if (isset($_POST['editfaculty'])) {
        $fid = mysqli_real_escape_string($con, $_POST['edit_fid']);
        $password = mysqli_real_escape_string($con, $_POST['edit_password']);
        $fname = mysqli_real_escape_string($con, $_POST['edit_fname']);
        $outlook = mysqli_real_escape_string($con, $_POST['edit_outlook']);
        $mnumber = mysqli_real_escape_string($con, $_POST['edit_mnumber']);
        $specialization = mysqli_real_escape_string($con, $_POST['edit_specialization']);
        $designation = mysqli_real_escape_string($con, $_POST['edit_designation']);

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $updatequery = "UPDATE faculty SET password = ?, fname = ?, email = ?, mobile = ?, specialization = ?, designation = ? WHERE fid = ?";
        $stmt = $con->prepare($updatequery);
        $stmt->bind_param('sssssss', $hashed_password, $fname, $outlook, $mnumber, $specialization, $designation, $fid);

        if ($stmt->execute()) {
            echo "<script>alert('Faculty details updated successfully');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }


// Delete all faculty
if (isset($_POST['deleteallfaculty'])) {
    $deleteallfaculty = "DELETE FROM faculty";
    if (mysqli_query($con, $deleteallfaculty)) {
        echo "<script>alert('All faculty have been deleted successfully');</script>";
    } else {
        echo "Error: " . $deleteallfaculty . "<br>" . mysqli_error($con);
    }
}

// Delete individual faculty
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $deletequery = "DELETE FROM faculty WHERE fid='$delete_id'";

    if ($con->query($deletequery) === TRUE) {
        echo "<script>alert('Faculty deleted successfully'); window.location.href = 'adminaddfaculty.php';</script>";
    } else {
        echo "Error deleting faculty: " . $con->error;
    }
}

// Helper function
function isfidexist($fid, $con) {
    $query = "SELECT * FROM faculty WHERE fid='$fid'";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result) > 0;
}
?>



<!-- Modal -->
<div class="modal fade" id="facultyexcelupload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel"  style="font-weight:bold">Upload Faculty Excel sheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="row g-3 m-3" method="POST" enctype="multipart/form-data" action="">
    <div class="col-md-6">
        <label for="validationDefault01" class="form-label">Upload file</label>
        <input type="file" class="form-control" name="excelFile" required>
    </div>
    <h5 class="text-bold">
    Note: 
    <span>
        
            Download Excelsheet Format from here: 
            <a id="download" class=" btn-link" href="path/to/excel_file.xlsx" download>
                Download Excel File
            </a>
    
    </span>
</h5>

<div class="col-12 mt-5 d-flex justify-content-end gap-2">
    <button class="btn" id="btnorange" name="add_faculty_excel" type="submit">Save</button>
    <button type="button" class="btn" id="btnred" data-dismiss="modal">Close</button>
</div>
</form>
      </div>
    </div>
  </div>
</div>


<script>
    document.getElementById('download').addEventListener('click', function () {
      // Data for the Excel file
      const data = [
        ['Faculty Id', 'Faculty Name', 'Faculty outlook', 'Faculty mobile No', ' Faculty Specialization', 'Faculty Designation'],
        ['MUJ2021','jon', 'jon.muj2021@manipal.muj.edu', '7895645689', 'cce', 'Professor'],
        ['Remove second row and add your data; Faculty ID , Faculty Name , Faculty Outlook is Mandatory'],

      ];

      // Create a new workbook and worksheet
      const wb = XLSX.utils.book_new();
      const ws = XLSX.utils.aoa_to_sheet(data);

      // Append the worksheet to the workbook
      XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

      // Create and download the Excel file
      XLSX.writeFile(wb, 'example.xlsx');
    });
  </script>



    <div class="modal fade" id="addfacultyl" tabindex="-1" aria-labelledby="addfacultylLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center w-100" style="font-weight:bold; color: #e45f06;">
                        <i class="fas fa-folder-plus"></i> Add Faculty
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
            <form class="row g-4" method="POST">
                
                <!-- Faculty ID -->
                <div class="col-md-4">
                    <label for="facultyId" class="form-label fw-bold">Faculty ID</label>
                    <input type="text" class="form-control" id="facultyId" name="fid" placeholder="Enter Faculty ID" required>
                </div>

                <!-- Faculty Name -->
                <div class="col-md-4">
                    <label for="facultyName" class="form-label fw-bold">Faculty Name</label>
                    <input type="text" class="form-control" id="facultyName" name="fname" placeholder="Enter Faculty Name" required
                           pattern="[A-Za-z ]+" title="Only letters allowed">
                </div>

                <!-- Faculty Outlook ID -->
                <div class="col-md-4">
                    <label for="outlookId" class="form-label fw-bold">Faculty Outlook ID</label>
                    <input type="email" class="form-control" id="outlookId" name="outlook" placeholder="name.fid@muj.manipal.edu" required
                           pattern="^[A-Za-z]+\.[A-Za-z0-9]+@muj\.manipal\.edu$"
                           title="Format: name.fid@muj.manipal.edu">
                </div>

                <!-- Password -->
                <!-- <div class="col-md-4">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                </div> -->

                <!-- Faculty Mobile Number -->
                <div class="col-md-4">
                    <label for="mobileNumber" class="form-label fw-bold">Mobile Number</label>
                    <input type="text" class="form-control" id="mobileNumber" name="mnumber" placeholder="Enter 10-digit Mobile Number" required
                           pattern="\d{10}" title="Exactly 10 digits">
                </div>

                <!-- Specialization -->
                <div class="col-md-4">
                    <label for="specialization" class="form-label fw-bold">Specialization</label>
                    <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Enter Specialization" required
                           pattern="[A-Za-z ]+" title="Only letters allowed">
                </div>

                <!-- Designation -->
                <div class="col-md-4">
                    <label for="designation" class="form-label fw-bold">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation" required
                           pattern="[A-Za-z ]+" title="Only letters allowed">
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-center mt-4">
                    <button class="btn btn-primary px-4" name="addfaculty" type="submit">
                        <i class="fas fa-save me-2"></i> Save Faculty
                    </button>
                </div>

            </form>
        
</div>
</dvi>
</div>

</div>
</dvi>
</div>


<!-- Add/Edit Faculty Modal -->
<div class="modal fade" id="editfacultyModal" tabindex="-1" aria-labelledby="editfacultyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Faculty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="edit_fid" id="edit_fid">
                    <div class="form-group">
                        <label class="pb-3" for="edit_fname">Faculty Name</label>
                        <input type="text" class="form-control" id="edit_fname" name="edit_fname"   pattern="^[A-Za-z\s]+$"  title="Faculty name must contain only letters." required>
                    </div>
                    <div class="form-group">
                        <label class="pb-3" for="edit_password">Password</label>
                        <input type="text" class="form-control" id="edit_password" name="edit_password" required>
                    </div>
                    <div class="form-group">
                        <label class="pb-3" for="edit_outlook">Outlook Id</label>
                        <input type="text" class="form-control" id="edit_outlook" name="edit_outlook" required   pattern="^[A-Za-z]+\.[A-Za-z0-9]+@jaipur\.manipal\.edu$" 
                        title="outlook must follow the pattern: name.fid@muj.manipal.edu">
                    </div>
                    <div class="form-group">
                        <label class="pb-3" for="edit_mnumber">Mobile Number</label>
                        <input type="text" class="form-control" id="edit_mnumber" name="edit_mnumber"  pattern="\d{10}" title="Mobile number must be exactly 10 digits.">
                    </div>
                    <div class="form-group">
                        <label class="pb-3" for="edit_specialization">Specialization</label>
                        <input type="text" class="form-control" id="edit_specialization" name="edit_specialization">
                    </div>
                    <div class="form-group">
                        <label class="pb-3" for="edit_designation">Designation</label>
                        <input type="text" class="form-control" id="edit_designation" name="edit_designation">
                    </div>
                    <button type="submit" name="editfaculty" class="btn">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
function openEditModal(fid, name, password, outlook, mnumber, specialization) {
    document.getElementById('edit_fid').value = fid;
    document.getElementById('edit_fname').value = name;
    document.getElementById('edit_password').value = password;
    document.getElementById('edit_outlook').value = outlook;
    document.getElementById('edit_mnumber').value = mnumber;
    document.getElementById('edit_specialization').value = specialization;
    document.getElementById('edit_designation').value = specialization;
    const modal = new bootstrap.Modal(document.getElementById('editfacultyModal'));
    modal.show();
}

</script>


<!-- Faculty Table -->
<h3 class="mt-5 text-center mb-3"  style="font-weight:bold">List of Faculty</h3>

<!-- Form to handle delete all faculty request -->
<form method="POST">
    <button class="btn" name="deleteallfaculty" id="btnred" type="submit" 
            onclick="return confirm('Are you sure you want to delete all faculty records?');"> <i class="fa-solid fa-trash-can"></i>
        Delete Faculty
    </button>
</form>
<div class="card shadow">
            
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                
            <div class="d-flex align-items-center mb-2 mb-md-0">
                  
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                    <div class="d-flex gap-2">
                           <!-- Button trigger modal -->
     <button type="button" class="btn" id="btnorange" data-bs-toggle="modal" data-bs-target="#facultyexcelupload">
 Upload Excel File
</button>

                        <button onclick="exportExcelWithoutLastColumn('facultyTable')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-file-excel"></i> Excel
                        </button>
                        <button onclick="printTableWithoutLastColumn('facultyTable')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-print"></i> Print
                        </button>

                        <button type="button" class="btn" id="btnorange" data-bs-toggle="modal" data-bs-target="#addfacultyl">
       <i class="fa-solid fa-folder-plus"></i>  Add Faculty
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
                    <table id="facultyTable" class="searchtable table table-hover">
                        <thead class="table-light">
        <tr>
            <th data-sort="none" onclick="sortTableNew(0, this)" scope="col">Sr No.</th>
            <th data-sort="none" onclick="sortTableNew(1, this)" scope="col">Faculty Id</th>
            <th data-sort="none" onclick="sortTableNew(2, this)" scope="col">Faculty Name</th>
            <th data-sort="none" onclick="sortTableNew(3, this)" scope="col">Outlook Id</th>
            <th data-sort="none" onclick="sortTableNew(4, this)" scope="col">Mobile</th>
            <th data-sort="none" onclick="sortTableNew(5, this)" scope="col">Specialization</th>
            <th data-sort="none" onclick="sortTableNew(6, this)" scope="col">Designation</th>
            <th  scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php

$selectquery = "SELECT * FROM faculty";
$query = mysqli_query($con, $selectquery);

$serial_no = 1;

while ($result = mysqli_fetch_assoc($query)) {
?>
<tr>
    <td><?php echo $serial_no++; ?></td>
    <td><?php echo htmlspecialchars($result['fid']); ?></td>
    <td><?php echo htmlspecialchars($result['fname']); ?></td>
    <td><?php echo htmlspecialchars($result['email']); ?></td>
    <td><?php echo htmlspecialchars($result['mobile']); ?></td>
    <td><?php echo htmlspecialchars($result['specialization']);  ?></td>
    <td><?php echo htmlspecialchars($result['designation']);  ?></td>
    <td>
        <a href="javascript:void(0)" onclick='openEditModal(
            "<?php echo htmlspecialchars($result["fid"]); ?>", 
            "<?php echo htmlspecialchars($result["fname"]); ?>",
              "<?php echo htmlspecialchars($result["password"]); ?>",      
            "<?php echo htmlspecialchars($result["email"]); ?>",
            "<?php echo htmlspecialchars($result["mobile"]); ?>",
            "<?php echo htmlspecialchars($result["specialization"]); ?>",
               "<?php echo htmlspecialchars($result["designation"]); ?>"
        )' class='btn btn-warning'><i class="fa-solid fa-pen-to-square">
Edit</a></i>
        <a class="btn" id="btnred" href="?delete_id=<?php echo urlencode($result['fid']); ?>"
           onclick="return confirm('Are you sure you want to delete this faculty?');"> <i class="fa-solid fa-trash-can"></i> Delete</a>
    </td>
</tr>
<?php
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

