<?php
include('../connection/connection.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    echo "<script>location.href='adminlogin.php';</script>";
    exit();
}

$admin_id = $_SESSION['id'];

function fetchAdminData($con, $admin_id) {
    $sql = "SELECT * FROM adminlogin WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
    
    return $admin;
}

function fetchSemester($con, $admin_id) {
    $sql = "SELECT semester FROM adminlogin WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
    
    return $admin['semester'] ?? null;
}


function updateAdminProfile($con, $admin_id, $aname, $aemail, $amnumber) {
    $update_sql = "UPDATE adminlogin SET aname = ?, aemail = ?, amobile = ? WHERE id = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("ssss", $aname, $aemail, $amnumber, $admin_id);
    return $update_stmt->execute();
}

function changeAdminPassword($con, $admin_id, $current_password, $new_password) {
    global $admin;
    if (!password_verify($current_password, $admin['apassword'])) {
        return "Current password is incorrect!";
    } elseif ($new_password !== $_POST['confirm_password']) {
        return "New passwords do not match!";
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE adminlogin SET apassword = ? WHERE id = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("ss", $hashed_password, $admin_id);
    
    if ($update_stmt->execute()) {
        return "Password changed successfully!";
    } else {
        return "Failed to update password. Please try again.";
    }
}

function insertNotice($con, $title, $description, $type) {
    $notice_date = date("Y-m-d");
    $sql = "INSERT INTO circular_notices (notice_date, title, description, type) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $notice_date, $title, $description, $type);
    return $stmt->execute();
}

function deleteNotice($con, $delete_notice_id) {
    $delete_sql = "DELETE FROM circular_notices WHERE id = ?";
    $stmt = $con->prepare($delete_sql);
    $stmt->bind_param("s", $delete_notice_id);
    return $stmt->execute();
}

function deleteNoticesByType($con, $type_to_delete) {
    $delete_all_sql = "DELETE FROM circular_notices WHERE type = ?";
    $stmt = $con->prepare($delete_all_sql);
    $stmt->bind_param("s", $type_to_delete);
    return $stmt->execute();
}

// Fetch and store semester if not already stored
if (!isset($_SESSION['semester'])) {
    $_SESSION['semester'] = fetchSemester($con, $admin_id);
}

// Fetch admin data if not already stored
if (!isset($_SESSION['admin_data'])) {
    $_SESSION['admin_data'] = fetchAdminData($con, $admin_id);
}

$admin = $_SESSION['admin_data'];
$semester = $_SESSION['semester'] ?? '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_profile_update'])) {
    $aname = trim($_POST['aname']);
    $aemail = trim($_POST['aemail']);
    $amnumber = trim($_POST['amnumber']);
    $work_year = $_POST['work_year'];

    $_SESSION['work_year'] = $work_year;

    // Validate inputs
    $errors = [];
    if (!preg_match("/^[A-Za-z ]+$/", $aname)) $errors[] = "Admin name must contain only letters and spaces.";
    if (!preg_match("/^[A-Za-z]+\.[A-Za-z0-9]+@muj\.manipal\.edu$/", $aemail)) $errors[] = "Email must follow the pattern: name.fid@muj.manipal.edu";
    if (!preg_match("/^\d{10,12}$/", $amnumber)) $errors[] = "Mobile number must be between 10 to 12 digits.";

    if (empty($errors)) {
        if (updateAdminProfile($con, $admin_id, $aname, $aemail, $amnumber)) {
            $_SESSION['admin_data']['aname'] = $aname;
            $_SESSION['admin_data']['aemail'] = $aemail;
            $_SESSION['admin_data']['amobile'] = $amnumber; 
            $success_message = "Profile updated successfully!";
        } else {
            $error_message = "Failed to update profile: " . $con->error;
        }
    } else {
        $error_message = implode("<br>", $errors);
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    $password_message = changeAdminPassword($con, $admin_id, $current_password, $new_password);
    if ($password_message !== "Password changed successfully!") {
        $error_message = $password_message;
    } else {
        $success_message = $password_message;
    }
}

// Handle notice actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['type'])) {
            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $type = htmlspecialchars($_POST['type']);

            if (insertNotice($con, $title, $description, $type)) {
                $message = "Circular notice submitted successfully!";
            } else {
                $message = "Error: " . $con->error;
            }
        } else {
            $message = "All fields are required.";
        }
    }

    if (isset($_POST['delete_notice_id'])) {
        $delete_notice_id = $_POST['delete_notice_id'];
        if (deleteNotice($con, $delete_notice_id)) {
            $message = "Notice deleted successfully!";
        } else {
            $message = "Error deleting notice: " . $con->error;
        }
    }

    if (isset($_POST['delete_all_by_type'])) {
        $type_to_delete = $_POST['delete_type'];
        if (deleteNoticesByType($con, $type_to_delete)) {
            $message = "All notices for type '$type_to_delete' deleted successfully!";
        } else {
            $message = "Error deleting all notices: " . $con->error;
        }
    }
}







// ---------------------------------------feedback logic ---------------------------------------------
// Initialize messages
$successMessage = '';
$errorMessage = '';
$warningMessage = '';

// Get data from session
$aname = isset($_SESSION['admin_data']['aname']) ? $_SESSION['admin_data']['aname'] : '';
$aemail = isset($_SESSION['admin_data']['aemail']) ? $_SESSION['admin_data']['aemail'] : '';

// Handle feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) {
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $ticket_id = random_int(1000000000, 9999999999);
    
    if (!empty($aname) && !empty($aemail) && !empty($message)) {
        $stmt = $con->prepare("INSERT INTO feedback (name, email, message, ticket_id, fid) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $aname, $aemail, $message, $ticket_id, $admin_id);
        
        if ($stmt->execute()) {
            $successMessage = 'Feedback submitted successfully! Ticket ID: ' . $ticket_id;
        } else {
            $errorMessage = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $warningMessage = 'Please fill in all fields.';
    }
}

// Handle status update
if (isset($_POST['update_status'])) {
    $ticket_id = $_POST['ticket_id'];
    $stmt = $con->prepare("UPDATE feedback SET status = 'Solved' WHERE ticket_id = ?");
    $stmt->bind_param("s", $ticket_id);
    
    if ($stmt->execute()) {
        $successMessage = 'Status updated successfully!';
    } else {
        $errorMessage = 'Error updating status.';
    }
    $stmt->close();
}

// Handle feedback deletion
if (isset($_POST['delete_feedback'])) {
    $ticket_id = $_POST['ticket_id'];
    $stmt = $con->prepare("DELETE FROM feedback WHERE ticket_id = ?");
    $stmt->bind_param("s", $ticket_id);
    
    if ($stmt->execute()) {
        $successMessage = 'Feedback deleted successfully!';
    } else {
        $errorMessage = 'Error deleting feedback.';
    }
    $stmt->close();
}

// Handle delete all feedback
if (isset($_POST['delete_all_feedback'])) {
    $stmt = $con->prepare("DELETE FROM feedback");
    
    if ($stmt->execute()) {
        $successMessage = 'All feedback deleted successfully!';
    } else {
        $errorMessage = 'Error deleting all feedback.';
    }
    $stmt->close();
}
?>
