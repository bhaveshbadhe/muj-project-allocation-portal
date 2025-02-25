<?php 
session_start(); 


include('../faculty/facultysidebar.php');

$fid = $_SESSION['fid']; 

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student_excel'])) {

    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
        $fileName = $_FILES['excelFile']['tmp_name'];

        try {
       
            $spreadsheet = IOFactory::load($fileName);
        
            // Get the active sheet (first sheet)
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Prepare the SQL insert statement
            $stmt = $con->prepare("INSERT INTO student (name, registration_no, password, fid, section) VALUES (?, ?, ?, ?,?)");

            // Iterate over each row of the Excel file
            foreach ($data as $key => $row) {
                // Skip the header row if it exists
                if ($key == 0) continue;

                // Check if any required field is empty
                if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
          
                    $check_sql = "SELECT * FROM student WHERE registration_no = ?";
                    $check_stmt = $con->prepare($check_sql);
                    $check_stmt->bind_param("s", $row[1]);
                    $check_stmt->execute();
                    $result = $check_stmt->get_result();

                    if ($result->num_rows > 0) {
                 
                        echo "<script>alert('Registration number {$row[1]} already exists in the database. Skipping this entry.');</script>";
                    } else {
                        // If registration_no does not exist, bind and execute the insert statement
                        $stmt->bind_param("sssss", $row[0], $row[1], $row[2], $fid, $row[4]);
                        $stmt->execute();
                    }

                    $check_stmt->close();
                } else {
                    echo "<script>alert('Empty fields found in the Excel sheet. Please check the data.')</script>";
                }
            }

            $stmt->close();
            echo "<script>alert('Data has been uploaded successfully!')</script>";

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            echo "<script>alert('Error loading file: ".$e->getMessage()."')</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid Excel file.')</script>";
    }
}




// Function to check if registration number already exists
function isRegistrationexist($registration, $con) {
    $query = "SELECT * FROM student WHERE registration_no='$registration'";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result) > 0;
}

// Function to delete all students
function deleteAllStudents($con) {
    $deleteallstudent = "DELETE FROM `student`"; // Corrected SQL query
    if (mysqli_query($con, $deleteallstudent)) {
        echo "<script>alert('All students have been deleted successfully');</script>";
    } else {
        echo "Error: " . $deleteallstudent . "<br>" . mysqli_error($con);
    }
}

// Handle form submission to add a new student
if (isset($_POST['addproject'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $registration = mysqli_real_escape_string($con, $_POST['registration']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $fid = $_SESSION['fid']; 
 
    if (empty($name)) {
        echo "<script>alert('Please enter student name');</script>";
    } elseif (!ctype_digit($registration)) {
        echo "<script>alert('Registration number should be digits only');</script>";
    } elseif (isRegistrationexist($registration, $con)) {
        echo "<script>alert('Registration number already exists');</script>";
    } else {
        $insertquery = "INSERT INTO student (name, registration_no, password, fid, section) VALUES ('$name', '$registration', '$password' , '$fid', '$section')";
        
        if (mysqli_query($con, $insertquery)) {
            $_SESSION['student_name'] = $name; 
            echo "<script>alert('New student added successfully');</script>";
        } else {
            echo "Error: " . $insertquery . "<br>" . mysqli_error($con);
        }
    }
}

// Handle delete all students request
if (isset($_POST['deleteallstudent'])) {
    deleteAllStudents($con); 
}

// Handle individual delete request
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    
    $deletequery = "DELETE FROM student WHERE registration_no='$delete_id'";
    
    if ($con->query($deletequery) === TRUE) {
        ?>
        <script>
            alert('Student deleted successfully');
            window.location.href = 'addstudent.php'; 
        </script>
        <?php
    } else {
        echo "Error deleting student: " . $con->error;
    }
}
?>


<!-- Modal -->
<div class="modal fade" id="studentexcel" tabindex="-1" aria-labelledby="studentexcel" aria-hidden="true">
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
           <h5 class="text-bold">Note: <span> <u>Formate of Excel Should Be Name,Registraion_no, Password, section</u></span></h5>
                <div class="col-12 mt-5">
                    <button class="btn btn-primary" name="add_student_excel" type="submit">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           
        </form>
      </div>
    </div>
  </div>
</div>


</div>




<div class="main_content">
<div class="container mt-5">


    <h3 class="mt-5 text-center" style="font-weight:bold">Add Student</h3>

    <div class="d-flex justify-content-end mb-3">
       
 
       <!-- Button trigger modal -->
       <button type="button" class="btn btn-success" data-toggle="modal" data-target="#studentexcel">
       <i class="fas fa-plus"></i> Import Excel
       </button>
           </div>

    <div class="card">
        <form class="row g-3 m-3" method="POST">
            <!-- Add student form fields -->
            <div class="col-md-6">
                <label for="validationDefault01" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="validationDefault01" name="name" required pattern="[A-Z a-z]+" title="Name should contain only alphabetic characters">
            </div>
            <div class="col-md-6">
                <label for="validationDefault01" class="form-label">Student Section</label>
                <input type="text" class="form-control" id="validationDefault01" name="section" required >
            </div>


            <div class="col-md-6">
                <label for="validationDefault02" class="form-label">Registration No</label>
                <input type="text" class="form-control" id="validationDefault02" name="registration" required>
            </div>
            <div class="col-md-6">
                <label for="validationDefault04" class="form-label">Password</label>
                <input type="text" class="form-control" id="validationDefault05" name="password" required>
            </div>
            <div class="col-12 mt-5">
                <button class="btn btn-primary" name="addproject" type="submit">Add Student</button>
            
            </div>
        </form>
    </div>
</div>


    <h3 class="mt-5 text-center mb-3" style="font-weight:bold">List of Students</h3>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div style="display: flex; gap: 10px;">
        <button onclick="exportTable()" class="btn">Export to Excel</button>
        <button onclick="printTable()" class="btn">Print Table</button>
    </div>
    <div class="search-wrapper" style="position: relative; display: inline-block;">
        <input type="text" id="searchInput" class="search-input" placeholder="Search in all columns..." style="padding-left: 30px;">
        <i  class="fas fa-search search-icon"  style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray;"
        ></i>
    </div>
</div>
</div>

<table  id="myTable" class="table table-bordered text-center">
        <thead class="text-light" style="background-color:black">
            <tr>
                <th scope="col">Sr No.</th>
                <th scope="col">Student Name</th>
                <th scope="col">Student Registration No</th>
                <th scope="col">Student Section</th>
                <th scope="col">Password</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fid = $_SESSION['fid'];
            $selectquery = "SELECT * FROM student WHERE fid = '$fid'";
            $query = mysqli_query($con, $selectquery);

            $serial_no = 1; 

            while ($result = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $serial_no++; ?></td>
                <td><?php echo $result['name']; ?></td>
                <td><?php echo $result['registration_no']; ?></td>
                <td><?php echo $result['section']; ?></td>
                <td><?php echo $result['password']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td><?php echo $result['mobile_no']; ?></td>
                <td>
                    <a class="btn btn-danger" href="?delete_id=<?php echo $result['registration_no']; ?>"
                       onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

    <form method="POST">
            <button class="btn btn-danger" name="deleteallstudent" type="submit" onclick="return confirm('Are you sure you want to delete all students?');">Delete All Students</button>
        </form>

        
        <?php
include('../faculty/facultyfooter.php')

?>
 
</body>
</html>
