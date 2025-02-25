<?php
session_start();
include('../connection/connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Access Denied: Admin not logged in.']);
    exit;
}


$admin_id = $_SESSION['id'];
$semester = $_SESSION['semester'] ?? null;


if (!$semester) {
    echo json_encode(['status' => 'error', 'message' => 'Semester not set in session.']);
    exit;
}


if (!function_exists('getRemainingStudents')) {
    function getRemainingStudents($con, $semester) {
        try {
            $query = "SELECT registration_no, name, section, year, semester FROM student WHERE registration_no NOT IN (SELECT registration_no FROM allocated_project)";
            
            if ($semester !== "all") {
                $query .= " AND semester = ?";
            }

            $stmt = $con->prepare($query);
            if (!$stmt) {
                throw new Exception("Error preparing query: " . $con->error);
            }

            if ($semester !== "all") {
                $stmt->bind_param("s", $semester);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error executing query: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if (!$result) {
                throw new Exception("Error fetching remaining students: " . $con->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage()); // Log the error
            return ["error" => "An error occurred while fetching data. Please try again later."];
        }
    }
}


// Function to save notifications
if (!function_exists('saveNotification')) {
    function saveNotification($con, $registration_no, $p_id, $message, $semester) {
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = date('Y-m-d H:i:s');
        $checkQuery = "SELECT * FROM notifications WHERE registration_no = ? AND p_id = ? AND semester = ?";

        $stmt = $con->prepare($checkQuery);
        $stmt->bind_param("sss", $registration_no, $p_id, $semester);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        if ($checkResult->num_rows > 0) {
            $updateQuery = "UPDATE notifications SET message = ?, datetime = ? 
                            WHERE registration_no = ? AND p_id = ? AND semester = ?";
            $stmt = $con->prepare($updateQuery);
            $stmt->bind_param("sssss", $message, $currentDateTime, $registration_no, $p_id, $semester);
            $stmt->execute();
        } else {
            $insertQuery = "INSERT INTO notifications (registration_no, p_id, message, datetime, semester) 
                            VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($insertQuery);
            $stmt->bind_param("sssss", $registration_no, $p_id, $message, $currentDateTime, $semester);
            $stmt->execute();
        }
    }
}
// Function to fetch faculty who have not been assigned to a project
if (!function_exists('getFacultyNotAssignedToProject')) {
    function getFacultyNotAssignedToProject($con) {
        $query = "SELECT fid FROM faculty 
                  WHERE fid NOT IN (SELECT fid FROM project)";
        
        $stmt = $con->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparing query: " . $con->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error fetching faculty: " . $con->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Function to fetch faculty with the least assigned projects
function getFacultyWithLeastProjects($con, $semester) {
    $query = "SELECT f.fid, f.fname, COUNT(p.p_id) as project_count FROM faculty f LEFT JOIN project p ON f.fid = p.fid";
    if ($semester !== "all") {
        $query .= " AND p.semester = ?";
    }
    $query .= " GROUP BY f.fid, f.fname ORDER BY project_count ASC";
    
    $stmt = $con->prepare($query);
    if ($semester !== "all") {
        $stmt->bind_param("s", $semester);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}



// Function to generate a unique project ID
function generateUniqueProjectId($con) {
    do {
        $newProjectId = sprintf('%010d', mt_rand(1000000000, 9999999999));
        $stmt = $con->prepare("SELECT p_id FROM project WHERE p_id = ?");
        $stmt->bind_param("s", $newProjectId);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    return $newProjectId;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'random_allocation') {
    $con->begin_transaction();
    try {
        // Modify query based on semester selection
        if ($semester === 'all') {
            $projectsQuery = "SELECT * FROM project WHERE no_of_student_allocated < max_student";
            $stmt = $con->prepare($projectsQuery);
        } else {
            $projectsQuery = "SELECT * FROM project WHERE semester = ? AND no_of_student_allocated < max_student";
            $stmt = $con->prepare($projectsQuery);
            $stmt->bind_param("s", $semester);
        }
        
        $stmt->execute();
        $projectsResult = $stmt->get_result();
        
        // Get remaining students
        $remainingStudents = ($semester === 'all') ? getRemainingStudents($con, null) : getRemainingStudents($con, $semester);
        if (count($remainingStudents) == 0) {
            throw new Exception('No students available for allocation.');
        }

        $allocationCount = 0;
        
        // First pass: Allocate to existing projects
        if ($projectsResult->num_rows > 0) {
            while ($project = $projectsResult->fetch_assoc()) {
                $available_spots = $project['max_student'] - $project['no_of_student_allocated'];
                
                for ($i = 0; $i < $available_spots && !empty($remainingStudents); $i++) {
                    $student = array_shift($remainingStudents);
                    
                    $insertQuery = "INSERT INTO allocated_project 
                                  (p_id, registration_no, fid, year, semester, section, action) 
                                  VALUES (?, ?, ?, ?, ?, ?, 'Allocated')";
                    $stmt = $con->prepare($insertQuery);
                    $stmt->bind_param("ssssss", 
                        $project['p_id'],
                        $student['registration_no'],
                        $project['fid'],
                        $student['year'],
                        $student['semester'], // Use student's semester dynamically
                        $student['section']
                    );
                    $stmt->execute();
                    
                    // Update project allocation count
                    $updateQuery = "UPDATE project 
                                  SET no_of_student_allocated = no_of_student_allocated + 1 
                                  WHERE p_id = ?";
                    $updateStmt = $con->prepare($updateQuery);
                    $updateStmt->bind_param("s", $project['p_id']);
                    $updateStmt->execute();
                    
                    saveNotification(
                        $con, 
                        $student['registration_no'],
                        $project['p_id'],
                        "Admin has allocated you to project ID: " . $project['p_id'],
                        $student['semester']
                    );
                    
                    $allocationCount++;
                }
            }
        }
        
       

        
        // Second pass: Create new projects for remaining students
            
        if (!empty($remainingStudents)) {
            $facultyList = getFacultyWithLeastProjects($con, $semester);
            if (empty($facultyList)) {
                throw new Exception('No faculty available for project allocation.');
            }
            
            $facultyIndex = 0;
            foreach ($remainingStudents as $student) {
                $newProjectId = generateUniqueProjectId($con);
                $currentFaculty = $facultyList[$facultyIndex % count($facultyList)];
                
                $insertProjectQuery = "INSERT INTO project (p_id, semester, fid, no_of_student_allocated, max_student) VALUES (?, ?, ?, 1, 1)";
                $stmt = $con->prepare($insertProjectQuery);
                $stmt->bind_param("sss", $newProjectId, $student['semester'], $currentFaculty['fid']);
                $stmt->execute();
                
                $insertAllocationQuery = "INSERT INTO allocated_project (p_id, registration_no, fid, year, semester, section, action) VALUES (?, ?, ?, ?, ?, ?, 'Allocated')";
                $stmt = $con->prepare($insertAllocationQuery);
                $stmt->bind_param("ssssss", $newProjectId, $student['registration_no'], $currentFaculty['fid'], $student['year'], $student['semester'], $student['section']);
                $stmt->execute();
                
        
                saveNotification(
                    $con,
                    $student['registration_no'],
                    $newProjectId,
                    "Admin has allocated you to newly created project ID: " . $newProjectId,
                    $semester
                );
                
                $facultyIndex++;
                $allocationCount++;
            }
        }
        
        $con->commit();
        echo json_encode([
            'status' => 'success',
            'message' => "Allocation completed successfully! $allocationCount students allocated."
        ]);
        
    } catch (Exception $e) {
        $con->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>
