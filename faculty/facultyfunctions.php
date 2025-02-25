<?php
session_start();
include('../connection/connection.php');

if (!isset($_SESSION['fid'])) {
    echo "<script>location.href='faculty_login.php';</script>";
    exit;
}

$fid = $_SESSION['fid'];
require_once('../faculty/facultyfunctions.php');


// Fetch faculty details from the database
$sql = "SELECT * FROM faculty WHERE fid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $fid);
$stmt->execute();
$result = $stmt->get_result();

// Check if faculty data is found
if ($result->num_rows > 0) {
    $faculty = $result->fetch_assoc();
} else {
    echo "<script>alert('No faculty data found for this faculty ID');</script>";
    exit();
}

// Now, you can safely access $faculty's properties
$image_name = $faculty['image'] ?? ''; // Safe access to 'image', defaulting to an empty string if not set


// Helper function to handle image upload
function handleImageUpload($existingImage) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                return $image_name;
            } else {
                echo "<script>alert('Failed to upload image');</script>";
                return $existingImage;
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, and PNG files are allowed');</script>";
            return $existingImage;
        }
    }
    return $existingImage;
}

// Update faculty profile
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['faculty_profile_update'])) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $mnumber = $_POST['mnumber'];
    $specialization = $_POST['specialization'];
    $work_year = $_POST['work_year'];
    $work_sem = $_POST['work_sem'];

    $_SESSION['work_year'] = $work_year;
    $_SESSION['work_sem'] = $work_sem;


  // Fetch existing data
$sql = "SELECT * FROM faculty WHERE fid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $fid);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc();

// Check if faculty data is found
if (!$faculty) {
    echo "<script>alert('No faculty data found for this faculty ID');</script>";
    exit();  // Stop further processing if no faculty data is found
}

// Image upload handling
$image_name = !empty($faculty['image']) ? handleImageUpload($faculty['image']) : handleImageUpload('');


    // Update query
    $update_sql = "UPDATE faculty SET fname = ?, email = ?, mobile = ?, specialization = ?, image = ? WHERE fid = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("ssssss", $fname, $email, $mnumber, $specialization, $image_name, $fid);

    if ($update_stmt->execute()) {
        echo "<script>alert('Faculty profile updated successfully'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update faculty profile');</script>";
    }
}

// Function to generate a unique 15-digit project ID
function generateUniqueProjectId($con) {
    do {
        $p_id = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
        $check_sql = "SELECT `p_id` FROM `project` WHERE `p_id` = '$p_id'";
        $result = $con->query($check_sql);
    } while ($result->num_rows > 0);

    return $p_id;
}

// Add project
if (isset($_POST['addproject'])) {
    $p_id = generateUniqueProjectId($con);
    $pname = $_POST['pname'];
    $pdesc = $_POST['pdesc'];
    $fid = $_SESSION['fid'];
    $max_student = intval($_POST['max_no_of_student']);
    $semester = $_POST['semester'];
    $domain_type = $_POST['domain_type'];

    $project_type = $_POST['project_type'] ?? null;
    if (!$project_type) {
        echo "<script>alert('Please select a project type.'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO project (p_id, pname, pdesc, fid, max_student, no_of_student_allocated, project_type, semester, project_domain_type)
            VALUES ('$p_id', '$pname', '$pdesc', '$fid', '$max_student', 0, '$project_type', '$semester', '$domain_type')";

    if ($con->query($sql)) {
        echo "<script>alert('New project added successfully'); window.location.href = 'faculty_addproject.php';</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "'); window.location.href = 'faculty_addproject.php';</script>";
    }
}

// Delete project
if (isset($_POST['delete'])) {
    $p_id_to_delete = $_POST['p_id'];

    $con->begin_transaction();

    try {
        $delete_allocated_sql = "DELETE FROM allocated_project WHERE p_id = '$p_id_to_delete'";
        if (!$con->query($delete_allocated_sql)) {
            throw new Exception("Error deleting from allocated_project: " . $con->error);
        }

        $delete_project_sql = "DELETE FROM project WHERE p_id = '$p_id_to_delete'";
        if (!$con->query($delete_project_sql)) {
            throw new Exception("Error deleting from project: " . $con->error);
        }

        $con->commit();
        echo "<script>alert('Project and associated allocations deleted successfully'); window.location.href = 'faculty_addproject.php';</script>";
    } catch (Exception $e) {
        $con->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Update project
if (isset($_POST['update'])) {
    $p_id = $_POST['p_id'];
    $pname = $_POST['pname'];
    $pdesc = $_POST['pdesc'];
    $project_type = $_POST['project_type'];
    $domain_type = $_POST['domain_type'];
    $semester = $_POST['semester'];
    $max_no_of_student = $_POST['max_no_of_student'];

    $update_query = "UPDATE project SET pname = '$pname', pdesc = '$pdesc', project_type = '$project_type', project_domain_type = '$domain_type', semester = '$semester', max_student = '$max_no_of_student' WHERE p_id = '$p_id'";

    if ($con->query($update_query)) {
        echo "<script>alert('Project updated successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }
}

// Insert notice
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_notice'])) {
    $notice_date = date("Y-m-d");
    $title = $con->real_escape_string($_POST['title']);
    $description = $con->real_escape_string($_POST['description']);
    $semester = $con->real_escape_string($_POST['semester']);

    $sql = "INSERT INTO circular_notices (fid, notice_date, title, description, semester) 
            VALUES ('$fid', '$notice_date', '$title', '$description', '$semester')";

    if ($con->query($sql)) {
        echo "<script>alert('Notice successfully posted!');</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }
}

// Delete notice
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_notice'])) {
    $notice_id = $con->real_escape_string($_POST['notice_id']);
    $delete_sql = "DELETE FROM circular_notices WHERE id = '$notice_id' AND fid = '$fid'";
    if ($con->query($delete_sql)) {
        echo "<script>alert('Notice deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting notice: " . $con->error . "');</script>";
    }
}

// Delete all notices for faculty
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_all_notices'])) {
    $delete_all_sql = "DELETE FROM circular_notices WHERE fid = '$fid'";
    if ($con->query($delete_all_sql)) {
        echo "<script>alert('All notices deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting notices: " . $con->error . "');</script>";
    }
}

// Fetch and display projects for faculty
$query = "SELECT * FROM project WHERE fid = '$fid'";
$result = $con->query($query);
if (!$result) {
    die("Query Failed: " . $con->error);
}

$editMode = isset($_GET['edit']);
$projectToEdit = null;
if ($editMode) {
    $p_id_to_edit = $_GET['edit'];
    $edit_query = "SELECT * FROM project WHERE p_id = '$p_id_to_edit'";
    $edit_result = $con->query($edit_query);
    $projectToEdit = $edit_result->fetch_assoc();
}


// ------------------------------ feedback logic ------------------------------
$successMessage = '';
$errorMessage = '';
$warningMessage = '';

// Handle feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) {
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    $ticket_id = random_int(1000000000, 9999999999);
    
    if (!empty($fname) && !empty($email) && !empty($message)) {
        // Insert feedback into database
        $stmt = $con->prepare("INSERT INTO feedback (name, email, message, ticket_id, fid) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fname, $email, $message, $ticket_id, $fid);
        
        if ($stmt->execute()) {
            $successMessage = '<div class="alert alert-success mt-3" role="alert">
                    Thank you for your feedback! Your Ticket ID is <strong>' . $ticket_id . '</strong>.
                  </div>';
        } else {
            $errorMessage = '<div class="alert alert-danger" role="alert">
                    Error: ' . $stmt->error . '
                  </div>';
        }
        
        $stmt->close();
    } else {
        $warningMessage = '<div class="alert alert-warning" role="alert">
                Please fill in all fields.
              </div>';
    }
}

// Handle feedback deletion
if (isset($_POST['delete_feedback'])) {
    $ticket_id_to_delete = $_POST['ticket_id'];

    $delete_stmt = $con->prepare("DELETE FROM feedback WHERE ticket_id = ? AND fid = ?");
    $delete_stmt->bind_param("ss", $ticket_id_to_delete, $fid);
    
    if ($delete_stmt->execute()) {
        $successMessage = '<div class="alert alert-success mt-3" role="alert">
                Feedback successfully deleted.
              </div>';
    } else {
        $errorMessage = '<div class="alert alert-danger" role="alert">
                Error deleting feedback.
              </div>';
    }
    $delete_stmt->close();
}

?>
