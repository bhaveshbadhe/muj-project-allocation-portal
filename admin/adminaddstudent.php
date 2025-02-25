<?php
session_start();
include('../admin/adminsidebar.php');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Function to convert Roman numeral to integer
function romanToInt($roman) {
    $romans = [
        'I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5,
        'VI' => 6, 'VII' => 7, 'VIII' => 8
    ];
    return isset($romans[trim($roman)]) ? $romans[trim($roman)] : (is_numeric($roman) ? (int)trim($roman) : null);
}

// Validate registration number (any string, no specific format)
function validateRegistrationNo($registrationNo) {
    return !empty($registrationNo); // Ensures it's not empty, no format required
}

// Validate email (must end with @muj.manipal.edu)
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@muj\.manipal\.edu$/', $email);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student_excel'])) {
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
        $fileName = $_FILES['excelFile']['tmp_name'];
        $fileType = $_FILES['excelFile']['type'];

        // Validate file type
        $validTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
            'application/vnd.ms-excel' // .xls
        ];

        if (in_array($fileType, $validTypes)) {
            try {
                $spreadsheet = IOFactory::load($fileName);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();

                $insertData = [];
                $existingFids = [];

                // Fetch existing registration_no values
                $existingQuery = "SELECT registration_no FROM student";
                $existingResult = mysqli_query($con, $existingQuery);
                while ($row = mysqli_fetch_assoc($existingResult)) {
                    $existingFids[] = $row['registration_no'];
                }

                $skippedRows = [];

                foreach ($data as $key => $row) {
                    if ($key == 0) continue; // Skip header row
                
                    // Trim spaces in values
                    $row = array_map('trim', $row);
                
                    // Log the row data for debugging purposes
                    error_log("Row $key: " . print_r($row, true)); // Log row data to check what's being passed
                
                    // Validate mandatory fields
                    if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4]) || empty($row[5])) {
                        $skippedRows[$key + 1] = "Missing required fields.";
                        continue;
                    }
                
                    // Skip existing registration_no
                    if (in_array($row[1], $existingFids)) {
                        $skippedRows[$key + 1] = "Duplicate registration number.";
                        continue;
                    }
                
                    // Validate registration number format
                    if (!validateRegistrationNo($row[1])) {
                        $skippedRows[$key + 1] = "Invalid registration number format.";
                        continue;
                    }
                
                    // Validate email format
                    if (!validateEmail($row[5])) {
                        $skippedRows[$key + 1] = "Invalid email format.";
                        continue;
                    }
                
                    // Convert semester to integer
                    $semester = romanToInt($row[4]);
                    if ($semester === null) {
                        $skippedRows[$key + 1] = "Invalid semester format.";
                        continue;
                    }
                
                    // Generate reversed registration_no as password
                    $reverse_no = strrev($row[1]);
                    $hashedPassword = password_hash($reverse_no, PASSWORD_DEFAULT);
                
                    // Add valid data to insert array
                    $insertData[] = [
                        'name' => $row[0],
                        'registration_no' => $row[1],
                        'section' => $row[2],
                        'year' => $row[3],
                        'semester' => $semester,
                        'email' => $row[5], // Outlook email
                        'password' => $hashedPassword,
                    ];
                }
                

                // Insert data in bulk
                if (!empty($insertData)) {
                    $insertQuery = "INSERT INTO student (name, registration_no, section, year, semester, email, password) VALUES ";
                    $values = [];
                    $params = [];

                    foreach ($insertData as $student) {
                        $values[] = "(?, ?, ?, ?, ?, ?, ?)";
                        $params = array_merge($params, array_values($student));
                    }

                    $stmt = mysqli_prepare($con, $insertQuery . implode(", ", $values));
                    $types = str_repeat("sssssss", count($insertData));
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    echo "<script>alert('Student data has been uploaded successfully.');</script>";
                } else {
                    echo "<script>alert('No new students were added.');</script>";
                }

                // Show message for skipped rows
                if (!empty($skippedRows)) {
                    $errorMessages = [];
                    foreach ($skippedRows as $rowNum => $reason) {
                        $errorMessages[] = "Row $rowNum: $reason";
                    }
                    echo "<script>alert('Some rows were skipped:\\n" . implode("\\n", $errorMessages) . "');</script>";
                }

            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                echo "<script>alert('Error reading Excel file: " . $e->getMessage() . "');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Please upload an Excel file.');</script>";
        }
    } else {
        echo "<script>alert('File upload error. Please try again.');</script>";
    }
}



function isRegistrationExist($registration_no, $con) {
    $query = "SELECT registration_no FROM student WHERE registration_no = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $registration_no);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

function deleteAllStudents($con, $semester) {
    $deleteQuery = "DELETE FROM student WHERE semester=?";
    $stmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "s", $semester);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('All students have been deleted successfully');</script>";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

// Handle form submission to add a new student
if (isset($_POST['addstudent'])) {
    // Sanitize and validate inputs
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $registration = mysqli_real_escape_string($con, $_POST['registration']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $section = mysqli_real_escape_string($con, $_POST['section']);

    // Generate a reverse password from the registration number
    $reverse_password = strrev($registration);

    // Hash the generated password
    $hashed_reverse_password = password_hash($reverse_password, PASSWORD_DEFAULT);
    
    // Use the user-entered password for verification
    $hashed_user_password = password_hash($password, PASSWORD_DEFAULT);

    // Validate inputs
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (isRegistrationExist($registration, $con)) {
        $errors[] = "Registration number already exists.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if (empty($semester)) {
        $errors[] = "Semester is required.";
    }
    
    // Convert Roman numeral semester to number (if necessary)
    $semester = romanToInt($semester) ?: $semester; // If Roman numeral conversion fails, retain original

    if (empty($year) || !ctype_digit($year)) {
        $errors[] = "Year must be a valid number.";
    }
    if (empty($section)) {
        $errors[] = "Section is required.";
    }

    // Check if there are errors
    if (!empty($errors)) {
        echo "<script>alert('Error: " . implode("\\n", $errors) . "');</script>";
    } else {
        // Insert into database
        $insertQuery = "INSERT INTO student (name, registration_no, password, semester, year, section, reverse_password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $registration, $hashed_reverse_password, $semester, $year, $section);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['student_name'] = $name; 
            echo "<script>alert('New student added successfully');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}


// Handle delete all students request
if (isset($_POST['deleteallstudent'])) {
    $semester = $_SESSION['semester'] ?? null;
    if ($semester) {
        deleteAllStudents($con, $semester);
    } else {
        echo "<script>alert('Semester is not set. Unable to delete students.');</script>";
    }
}

// Handle individual delete request
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    $deleteQuery = "DELETE FROM student WHERE registration_no=?";
    $stmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "s", $delete_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Student deleted successfully');</script>";
        echo "<script>window.location.href = 'adminaddstudent.php';</script>"; // Redirect after deletion
    } else {
        echo "Error deleting student: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

// Handle edit student request (assuming 'editstudent' form submission)
if (isset($_POST['editstudent'])) {
    $name = mysqli_real_escape_string($con, $_POST['edit_name']);
    $registration = mysqli_real_escape_string($con, $_POST['edit_registration_no']);
    $password = mysqli_real_escape_string($con, $_POST['edit_password']);
    $semester = mysqli_real_escape_string($con, $_POST['edit_semester']);
    $year = mysqli_real_escape_string($con, $_POST['edit_year']);
    $section = mysqli_real_escape_string($con, $_POST['edit_section']);
    $mobile = mysqli_real_escape_string($con, $_POST['edit_mobile']);
    $outlook = mysqli_real_escape_string($con, $_POST['edit_outlook']);
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Perform the update query
    $updateQuery = "UPDATE student SET 
                    name = '$name',
                    password = '$hashed_password',
                    semester = '$semester',
                    year = '$year',
                    section = '$section',
                    mobile_no = '$mobile',
                    email = '$outlook'
                    WHERE registration_no = '$registration'";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Student record updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating student: " . mysqli_error($con) . "');</script>";
    }
}


?>

<!-- Modal -->
<div class="modal fade" id="studentexcel" tabindex="-1" aria-labelledby="studentexcel" aria-hidden="true">
  <div class=" modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title" id="exampleModalLabel" style="font-weight:bold;">Upload Student Excel sheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </button>
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

  <script>
    document.getElementById('download').addEventListener('click', function () {
      // Data for the Excel file
      const data = [
        ['Student Name', 'Student Registraion_no', 'Student Section', 'Year Of Admission', 'Current Semester', 'Student Outlook'],
        ['John Doe', 219032206001, 'h', '2024', '3', 'john.219032206001@muj.manipal.edu'],
        ['Remove Second row and add your data; Student Name, All Filled is Mandatory '],

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
  


  <div class="col-12 mt-5 d-flex justify-content-end gap-2">
    <button class="btn" id="btnorange" name="add_student_excel" type="submit">Save</button>
    <button type="button" class="btn" id="btnred" data-dismiss="modal">Close</button>
</div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="main_content">

 

  <div class="modal fade" id="addstudent" tabindex="-1" aria-labelledby="addstudentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center w-100" style="font-weight:bold; color: #e45f06;">
                        <i class="fas fa-folder-plus"></i> Add Student
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
  <div class="card">
    <form class="row g-3 m-3" method="POST">
        <!-- Add student form fields -->
        <div class="col-md-4">
            <label for="studentName" class="form-label">Student Name</label>
            <input type="text" class="form-control" id="studentName" name="name" required pattern="[A-Za-z\s]+" 
                   title="Name should contain only alphabetic characters" placeholder="Enter student name">
        </div>

        <div class="col-md-4">
            <label for="registrationNo" class="form-label">Registration No</label>
            <input type="text" class="form-control" id="registrationNo" name="registration" required 
                   placeholder="Enter registration number">
        </div>

        <div class="col-md-4">
    <label for="year" class="form-label">Year</label>
    <select class="form-control" id="year" name="year" required>
        <?php
        $current_year = date('Y'); 
        for ($year = $current_year; $year >= $current_year - 10; $year--) {
            echo "<option value='$year'>$year</option>";
        }
        ?>
    </select>
</div>


        <div class="col-md-4">
            <label for="section" class="form-label">Section</label>
            <input type="text" class="form-control" id="section" name="section" required 
                   pattern="[A-Za-z]+" title="Section can contain alphanumeric characters" placeholder="Enter section">
        </div>

        <div class="col-md-4">
            <label for="semester" class="form-label">Semester</label>
            <select class="form-control" id="semester" name="semester" required>
                <option value="" disabled selected>Select semester</option>
                <?php foreach ([3, 4, 5, 6, 7, 8] as $sem) : ?>
                    <option value="<?= $sem ?>"><?= $sem ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 mt-5">
            <button class="btn btn-primary" name="addstudent" id="btnorange" type="submit">Add Student</button>
        </div>
    </form>
</div>
                </div>
                </div>
                </div>
                </div>
    

<!-- Add/Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form method="POST">
    <input type="hidden" name="edit_registration" id="edit_registration">
    
    <div class="form-group">
        <label class="pb-3" for="edit_name">Student Name</label>
        <input type="text" class="form-control" id="edit_name" name="edit_name" required pattern="[A-Za-z ]{3,50}">
    </div>
    
    <div class="form-group">
        <label class="pb-3" for="edit_registration_no">Student Registration No</label>
        <input type="text" class="form-control" id="edit_registration_no" name="edit_registration_no" required pattern="[0-9]{6,10}">
    </div>
    
    <div class="form-group">
    <div class="password-container" style="position: relative;">
        <label class="pb-3" for="edit_password">New Password</label>
        <input type="password" class="form-control" id="edit_password" name="edit_password" required pattern=".{6,}">
        <button type="button" class="toggle-password" onclick="togglePassword('edit_password')" 
                style="position: absolute; right: 10px;  background: none; border: none;">
            <i class="fa-regular fa-eye"></i>
        </button>
    </div>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

    

    <div class="form-group">
        <label class="pb-3" for="edit_year">Student Year</label>
        <input type="text" class="form-control" id="edit_year" name="edit_year" required >
    </div>

    <div class="form-group">
        <label class="pb-3" for="edit_semester">Student Semester</label>
        <input type="text" class="form-control" id="edit_semester" name="edit_semester" required>
    </div>

    <div class="form-group">
        <label class="pb-3" for="edit_section">Student Section</label>
        <input type="text" class="form-control" id="edit_section" name="edit_section"  pattern="[A-Za-z0-9]{1,5}">
    </div>

    <div class="form-group">
        <label class="pb-3" for="edit_mobile">Student Mobile</label>
        <input type="tel" class="form-control" id="edit_mobile" name="edit_mobile" pattern="[0-9]{10}" min="10" max="10" title="number must be 10 digits">
    </div>

    <div class="form-group">
        <label class="pb-3" for="edit_outlook">Student Outlook</label>
        <input type="email" class="form-control" id="edit_outlook" name="edit_outlook" >
    </div>

    <button type="submit" name="editstudent" class="btn btn-primary">Save Changes</button>
</form>

            </div>
        </div>
    </div>
</div>

<script>
function openEditModal(name, registration, year, semester, section, mobile, outlook, password) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_registration_no').value = registration;
    document.getElementById('edit_year').value = year;
    document.getElementById('edit_semester').value = semester;
    document.getElementById('edit_section').value = section;
    document.getElementById('edit_mobile').value = mobile;
    document.getElementById('edit_outlook').value = outlook;
    document.getElementById('edit_password').value = password;

    $('#editStudentModal').modal('show');
}

</script>
<!-- List of Students with Edit Button -->
<h3 class="mt-5 text-center mb-3" style="font-weight:bold">List of Students</h3>
   <!-- Form to handle delete all students request -->
   <form method="POST">
        <button class="btn" id="btnred" name="deleteallstudent"  type="submit" onclick="return confirm('Are you sure you want to delete all students?');">
          <i class="fa-solid fa-trash-can"></i>Delete All Students
        </button>
      </form>
<div class="card shadow">
            
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                
            <div class="d-flex align-items-center mb-2 mb-md-0">
                  
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                    <div class="d-flex gap-2">
             <!-- Button trigger modal -->
      <button type="button" class="btn" id="btnorange"  data-bs-toggle="modal" data-bs-target="#studentexcel">
        Upload Excel File
      </button>

                        <button onclick="exportExcelWithoutLastColumn('studentlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-file-excel"></i> Excel
                        </button>
                        <button onclick="printTableWithoutLastColumn('studentlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-print"></i> Print
                        </button>

                        <button type="button" class="btn" id="btnorange" data-bs-toggle="modal" data-bs-target="#addstudent">
       <i class="fa-solid fa-folder-plus"></i>  Add Student
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
                    <table id="studentlist" class="searchtable table table-hover">
                        <thead class="table-light">
        <tr>
            <th scope="col">Sr No.</th>
            <th scope="col">Student Name</th>
            <th scope="col">Registration No</th>
            <th scope="col">Year</th>
            <th scope="col">Semester</th>
            <th scope="col">Section</th>
            <th scope="col">Mobile</th>
            <th scope="col">Outlook Id</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$semester = $_SESSION['semester'] ?? null;

if (!$semester) {
    echo "<script>alert('Semester not set in session.'); location.href='adminlogin.php';</script>";
    exit();
}

// Adjust query based on semester selection
if ($semester === "all") {
    $selectQuery = "SELECT * FROM student"; // Select all students
    $stmt = $con->prepare($selectQuery);
} else {
    $selectQuery = "SELECT * FROM student WHERE semester = ?";
    $stmt = $con->prepare($selectQuery);
    $stmt->bind_param("s", $semester);
}

if (!$stmt) {
    die("Error preparing query: " . $con->error);
}

$stmt->execute();
$query = $stmt->get_result();
$srNo = 1;
$sections = [];

while ($result = $query->fetch_assoc()) {
    $sections[] = $result['section']; // Collect sections dynamically
    echo "<tr data-section='{$result['section']}'>
        <td>$srNo</td>
        <td>{$result['name']}</td>
        <td>{$result['registration_no']}</td>
        <td>{$result['year']}</td>
        <td>{$result['semester']}</td>
        <td>{$result['section']}</td>
        <td>{$result['mobile_no']}</td>
        <td>{$result['email']}</td>
        
        <td>
            <a href='javascript:void(0)' onclick='openEditModal(
                \"" . addslashes($result['name']) . "\", 
                \"" . addslashes($result['registration_no']) . "\", 
                \"" . addslashes($result['year']) . "\", 
                \"" . addslashes($result['semester']) . "\", 
                \"" . addslashes($result['section']) . "\", 
                \"" . addslashes($result['mobile_no']) . "\", 
                \"" . addslashes($result['email']) . "\", 
                \"" . addslashes($result['password']) . "\"
            )' class='btn btn-warning'>
                <i class='fa-solid fa-pen-to-square'></i> Edit
            </a>

            <a href='adminaddstudent.php?delete_id={$result['registration_no']}' onclick='return confirm(\"Are you sure you want to delete this student?\")' class='btn' id='btnred'>
                <i class='fa-solid fa-trash-can'></i> Delete
            </a>
        </td>
    </tr>";
    $srNo++;
}

$stmt->close();
?>

    </tbody>
</table>
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



</html>


