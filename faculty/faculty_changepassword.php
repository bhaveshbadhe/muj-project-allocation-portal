<?php 


include('../faculty/facultysidebar.php');

// Fetch faculty data based on fid stored in the session
$fid = $_SESSION['fid'];
$error_message = '';
$success_message = '';

// Fetch faculty data
$sql = "SELECT * FROM faculty WHERE fid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $fid);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc(); // Store faculty data correctly

if (!$faculty) {
    echo "<script>alert('Failed to fetch faculty data');</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate current password
    if (!password_verify($current_password, $faculty['password'])) {
        $error_message = "Current password is incorrect!";
    } 
    // Validate new password match
    elseif ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match!";
    }
    // Process password change
    else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE faculty SET password = ? WHERE fid = ?";
        $update_stmt = $con->prepare($update_sql);
        $update_stmt->bind_param("ss", $hashed_password, $fid);

        if ($update_stmt->execute()) {
            $success_message = "Password changed successfully!";
        } else {
            $error_message = "Failed to update password. Please try again.";
        }
    }
}

$con->close();
?>


    <div class="main_content">

        <h3 class="text-center m-5" style="font-weight:bold">Change Password</h3>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" id="passwordForm" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="password-container">
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('current_password')">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="password-container">
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('new_password')">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <div class="password-container">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('confirm_password')">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                    <button class="btn"  name="change_password" id="btnorange" type="submit">Change Password</button>
                     
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            Passwords do not match!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.querySelector('.card').insertAdjacentElement('beforebegin', alertDiv);
    }
});

// Auto-dismiss alerts after 5 seconds
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(function(alert) {
        bootstrap.Alert.getOrCreateInstance(alert).close();
    });
}, 5000);
</script>



<?php
include('../faculty/facultyfooter.php');

?>