<?php
session_start(); // Start the session
require '../vendor/autoload.php';

$fid = $_SESSION['fid']; // Assuming 'fid' is stored in session when faculty logs in

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "project_management_website";

$con = mysqli_connect($server, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_FILES['excelFile'])) {
    $fileName = $_FILES['excelFile']['tmp_name'];

    // Load the Excel file
    $spreadsheet = IOFactory::load($fileName);

    // Get the active sheet (first sheet)
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    // Prepare the SQL insert statement
    $stmt = $con->prepare("INSERT INTO student (name, registration_no, password, fid) VALUES (?, ?, ?, ?)");

    // Iterate over each row of the Excel file
    foreach ($data as $row) {
        // Check if any required field is empty
        if (!empty($row[1]) && !empty($row[2]) && !empty($row[3])) {
            // Bind the Excel data to the SQL statement
            $stmt->bind_param("ssss", $row[1], $row[2], $row[3], $fid);

            // Execute the SQL statement
            $stmt->execute();
        }
    }

    $stmt->close();
    $con->close();

    echo "Data has been uploaded successfully!";
} else {
    echo "Please upload an Excel file.";
}
?>
