<?php
session_start();
include('../admin/adminsidebar.php');
?>

<div class="main_content">
    <h1>List of Project Selected</h1>
    <div class="container mt-5">
        <?php
    
        $query = "SELECT * FROM add_project_mark ORDER BY student_enrollment";
        $result = mysqli_query($con, $query);
        if (!$result) {
            die("Query Failed: " . mysqli_error($con));
        }
        ?>

<table border="1" class="table table-bordered" id="example">
            <thead class="bg-dark text-light">
                <tr>
                    <th>Student Name</th>
                    <th>Student Enrollment No</th>
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
                    echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['student_enrollment']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['project_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['project_title']) . "</td>";
                    echo "<td><input type='number' class='review-mark' data-enrollment='" . $row['student_enrollment'] . "' data-field='1_project_review' value='" . htmlspecialchars($row['1_project_review']) . "'></td>";
                    echo "<td><input type='number' class='review-mark' data-enrollment='" . $row['student_enrollment'] . "' data-field='2_project_review' value='" . htmlspecialchars($row['2_project_review']) . "'></td>";
                    echo "<td><input type='number' class='review-mark' data-enrollment='" . $row['student_enrollment'] . "' data-field='3_project_review' value='" . htmlspecialchars($row['3_project_review']) . "'></td>";
                    echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.review-mark').on('change', function() {
            var enrollment = $(this).data('enrollment');
            var field = $(this).data('field');
            var value = $(this).val();
            $.ajax({
                url: 'update_project_mark.php',
                method: 'POST',
                data: {
                    enrollment: enrollment,
                    field: field,
                    value: value
                },
                success: function(response) {
                    console.log('Data updated successfully');
                  
                },
                error: function(xhr, status, error) {
                    console.error('Error in updating data: ' + error);
                }
            });
        });
    });
</script>
</body>
</html>
<?php

mysqli_close($con);
?>
