<?php
// -------------------- Include Necessary Files ------------------------------
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('../connection/connection.php');


// Check if the registration number is set in the session
if (!isset($_SESSION['registration_no'])) {
    echo '<script>location.href="../index.php";</script>';
    exit();
}

$registration_no = $_SESSION['registration_no'];

// Fetch student data
$student = fetchStudentData($con, $registration_no);

// Check if student data exists
if (!$student) {
    echo "<script>alert('No student found with this registration number'); location.href='../index.php';</script>";
    exit();
}

// Set semester session if not already set
if (!isset($_SESSION['semester'])) {
    $_SESSION['semester'] = $student['semester'] ?? '1'; // Use the student's semester or default to '1'
}

// Now, you can safely use the semester session value
$semester = $_SESSION['semester'];

// Extract student data
$name = htmlspecialchars($student['name']);
$email = htmlspecialchars($student['email']);
$mobile = htmlspecialchars($student['mobile_no']);
$section = htmlspecialchars($student['section']);
$year = htmlspecialchars($student['year']);
$image = !empty($student['image']) ? htmlspecialchars($student['image']) : 'default.png'; // Fallback to default image

// -------------------- Functions ------------------------------
function fetchStudentData($con, $registration_no) {
    $sql = "SELECT * FROM student WHERE registration_no = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $registration_no);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateStudentDetails($con, $data) {
    $sql = "UPDATE student SET name = ?, email = ?, mobile_no = ?, section = ?, image = ? WHERE registration_no = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        "ssssss",
        $data['name'],
        $data['email'],
        $data['mobile_no'],
        $data['section'],
        $data['image'],
        $data['registration_no']
    );
    return $stmt->execute();
}

function handleImageUpload($file, $target_dir) {
    if ($file['error'] === 0) {
        $image_name = basename($file['name']);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                return $image_name;
            }
        }
    }
    return null;
}

// -------------------- Profile Update Logic ------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateStudent'])) {
    $data = [
        'name' => mysqli_real_escape_string($con, $_POST['name']),
        'email' => mysqli_real_escape_string($con, $_POST['email']),
        'mobile_no' => mysqli_real_escape_string($con, $_POST['mobile']),
        'section' => mysqli_real_escape_string($con, $_POST['section']),
        'registration_no' => $registration_no,
        'image' => $image // Default to existing image
    ];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploaded_image = handleImageUpload($_FILES['image'], '../uploads/');
        if ($uploaded_image) {
            $data['image'] = $uploaded_image;
        }
    }

    // Update student details
    if (updateStudentDetails($con, $data)) {
        echo "<script>alert('Student details updated successfully'); window.location.href = 'studentprofile.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update student details');</script>";
        exit();
    }
}

function updatePassword($con, $registration_no, $new_password) {
    $sql = "UPDATE student SET password = ? WHERE registration_no = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $new_password, $registration_no);
    return $stmt->execute();
}

function fetchNotifications($con, $registration_no, $semester, $filter) {
    $query = "";

    if ($filter === 'faculty') {
        $query = "
            SELECT cn.notice_date, cn.title, cn.description, cn.type
            FROM circular_notices cn
            INNER JOIN allocated_project ap ON cn.fid = ap.fid
            WHERE ap.registration_no = ?
        ";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $registration_no);
    } elseif ($filter === 'admin') {
        $query = "
            SELECT notice_date, title, description, type
            FROM circular_notices
            WHERE type = 'all'
        ";
        $stmt = $con->prepare($query);
    } else { // Default case for 'all'
        $query = "
            SELECT DISTINCT cn.notice_date, cn.title, cn.description, cn.type
            FROM circular_notices cn
            LEFT JOIN allocated_project ap ON cn.fid = ap.fid
            WHERE (ap.registration_no = ? AND ap.semester = ?) 
            OR cn.type = 'all'
        ";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $registration_no, $semester);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    return $notifications;
}

// -------------------- Password Change Logic ------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $student = fetchStudentData($con, $registration_no);

    if (!$student || !password_verify($current_password, $student['password'])) {
        $error_message = "Current password is incorrect!";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        if (updatePassword($con, $registration_no, $hashed_password)) {
            $success_message = "Password changed successfully!";
        } else {
            $error_message = "Failed to update password. Please try again.";
        }
    }
}

// -------------------- Notification Fetch Logic ------------------------------
$filter = isset($_GET['filter']) ? htmlspecialchars($_GET['filter']) : 'all';
$notifications = fetchNotifications($con, $registration_no, $_SESSION['semester'], $filter);



// ------------------------------------------ feedback logic -----------------------------------------
$successMessage = '';
$errorMessage = '';
$warningMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $registration_no = isset($_POST['registration_no']) ? trim($_POST['registration_no']) : '';
    
    $ticket_id = random_int(1000000000, 9999999999);
    
    if (!empty($name) && !empty($email) && !empty($message) && !empty($registration_no)) {
        $stmt = $con->prepare("INSERT INTO feedback (name, email, message, ticket_id, registration_no) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $message, $ticket_id, $registration_no);
        
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
    
    $delete_stmt = $con->prepare("DELETE FROM feedback WHERE ticket_id = ? AND registration_no = ?");
    $delete_stmt->bind_param("ss", $ticket_id_to_delete, $registration_no);
    
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
