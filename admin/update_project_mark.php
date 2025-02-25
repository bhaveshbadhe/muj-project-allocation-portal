
<?php
include('../connection/connection.php');
if (isset($_POST['enrollment']) && isset($_POST['field']) && isset($_POST['value'])) {
    $enrollment = $_POST['enrollment'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    $allowedFields = ['1_project_review', '2_project_review', '3_project_review'];
    if (in_array($field, $allowedFields)) {
        $query = "UPDATE add_project_mark SET $field = '$value' WHERE student_enrollment = '$enrollment'";
        if (mysqli_query($con, $query)) {
            echo "Success";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Invalid field";
    }
} else {
    echo "Invalid request";
}
mysqli_close($con);
?>