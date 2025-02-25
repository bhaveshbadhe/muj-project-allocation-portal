<?php
session_start();
include('../student/studentsidebar.php');

// Retrieve student enrollment from the session
$studentEnrollment = $_SESSION['enrollmentno'];

// Query to fetch data from add_project_mark table for the current student
$query = "SELECT * FROM add_project_mark WHERE student_enrollment = '$studentEnrollment'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}
?>

<div class="main_content">
    <h3 class="mt-5">Show Mark</h3>
    
    <div class="container mt-5"> 
        <table border="1" class="table table-bordered" id="example">
            <thead class="bg-dark text-light">
                <tr>
                    <th>Project Id</th>
                    <th>Project Title</th>
                    <th>1 Project Review Mark</th>
                    <th>2 Project Review Mark</th>
                    <th>3 Project Review Mark</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['project_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['project_title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['1_project_review']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['2_project_review']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['3_project_review']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
