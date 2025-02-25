<?php
include('connection/connection.php');

// Check if token is provided in URL
if (!isset($_GET['token']) || empty($_GET['token'])) {
    echo "<script>alert('Invalid or missing token!'); window.location.href='index.php';</script>";
    exit;
}

$token = $_GET['token'];

// First, verify the token and check if it's expired
$stmt = $con->prepare("SELECT user_type, user_id, expiry_time FROM password_reset_tokens 
                      WHERE token = ? AND expiry_time > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Invalid or expired token!'); window.location.href='index.php';</script>";
    exit;
}

$row = $result->fetch_assoc();
$userType = $row['user_type'];
$userId = $row['user_id'];

// If form is submitted with new password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate passwords
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    if (empty($password) || strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Hash the new password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Update password based on user type
        switch ($userType) {
            case 'student':
                $updateQuery = "UPDATE student SET password = ? WHERE registration_no = ?";
                $redirectUrl = 'index.php';
                break;
            case 'faculty':
                $updateQuery = "UPDATE faculty SET password = ? WHERE fid = ?";
                $redirectUrl = 'faculty/faculty_login.php';
                break;
            case 'admin':
                $updateQuery = "UPDATE adminlogin SET apassword = ? WHERE id = ?";
                $redirectUrl = 'admin/adminlogin.php';
                break;
            default:
                echo "<script>alert('Invalid user type!'); window.location.href='index.php';</script>";
                exit;
        }
        
        $updateStmt = $con->prepare($updateQuery);
        $updateStmt->bind_param("si", $hashedPassword, $userId);
        
        if ($updateStmt->execute()) {
            // Delete the used token
            $deleteStmt = $con->prepare("DELETE FROM password_reset_tokens WHERE token = ?");
            $deleteStmt->bind_param("s", $token);
            $deleteStmt->execute();
            
            echo "<script>alert('Password updated successfully!'); window.location.href='{$redirectUrl}';</script>";
            exit;
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - Manipal University Jaipur</title>

<!------------------------------------ boostrap 5 files ---------------------->
<link rel="stylesheet" href="../muj/bootstrap-5.0.2-dist/css/bootstrap.min.css">
<script src="../muj/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" href="photo/muj-title-logo.png" type="image/png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  
    <!-- Icon Libraries -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/feather-icons/dist/feather.min.css">


<link rel="stylesheet" href="common-styling.css">

    <style>
    
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-header bg-white border-bottom border-light p-4 text-center">
                    <img src="photo/manipallogo.png" alt="Manipal University Jaipur" class="logo">
                        <h4 class="text-primary fw-bold mb-0">Reset Your Password</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" id="resetForm">
                            <div class="mb-3 password-container">
                                <label for="password" class="form-label fw-semibold text-secondary">New Password</label>
                                <input type="password" class="form-control form-control-lg border-secondary-subtle" id="password" name="password" required>
                                <span class="toggle-password " id="togglePassword">
                                    <i class="far fa-eye"></i>
                                </span>
                                <div class="password-strength">
                                    <div class="password-strength-bar" id="passwordStrength"></div>
                                </div>
                                <div id="passwordFeedback" class="form-text"></div>
                            </div>
                            <div class="mb-4 password-container">
                                <label for="confirm_password" class="form-label fw-semibold text-secondary">Confirm New Password</label>
                                <input type="password" class="form-control form-control-lg border-secondary-subtle" id="confirm_password" name="confirm_password" required>
                                <span class="toggle-password " id="toggleConfirmPassword">
                                    <i class="far fa-eye"></i>
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">Update Password</button>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-top border-light p-3 text-center">
                        <small class="text-muted">© <?php echo date('Y'); ?> Manipal University Jaipur | All rights reserved.</small>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none text-muted small">Need help? Contact support</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordStrength = document.getElementById('passwordStrength');
            const passwordFeedback = document.getElementById('passwordFeedback');
            
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
            
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
            
            // Password strength meter
            password.addEventListener('input', function() {
                const strength = calculatePasswordStrength(this.value);
                
                // Update strength bar
                passwordStrength.style.width = strength.score * 25 + '%';
                
                // Set color based on score
                if (strength.score === 0) {
                    passwordStrength.style.backgroundColor = '#dc3545'; // Bootstrap danger
                    passwordFeedback.innerHTML = 'Password is too weak';
                    passwordFeedback.className = 'form-text text-danger';
                } else if (strength.score === 1) {
                    passwordStrength.style.backgroundColor = '#ffc107'; // Bootstrap warning
                    passwordFeedback.innerHTML = 'Password is weak';
                    passwordFeedback.className = 'form-text text-warning';
                } else if (strength.score === 2) {
                    passwordStrength.style.backgroundColor = '#fd7e14'; // Bootstrap orange
                    passwordFeedback.innerHTML = 'Password is moderate';
                    passwordFeedback.className = 'form-text text-warning';
                } else if (strength.score === 3) {
                    passwordStrength.style.backgroundColor = '#20c997'; // Bootstrap teal
                    passwordFeedback.innerHTML = 'Password is strong';
                    passwordFeedback.className = 'form-text text-success';
                } else {
                    passwordStrength.style.backgroundColor = '#198754'; // Bootstrap success
                    passwordFeedback.innerHTML = 'Password is very strong';
                    passwordFeedback.className = 'form-text text-success';
                }
            });
            
            // Form validation with Bootstrap validation classes
            document.getElementById('resetForm').addEventListener('submit', function(e) {
                const passwordInput = document.getElementById('password');
                const confirmPasswordInput = document.getElementById('confirm_password');
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                let isValid = true;
                
                // Remove previous validation classes
                passwordInput.classList.remove('is-valid', 'is-invalid');
                confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
                
                if (password.length < 8) {
                    e.preventDefault();
                    passwordInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    passwordInput.classList.add('is-valid');
                }
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    confirmPasswordInput.classList.add('is-invalid');
                    isValid = false;
                } else if (password.length >= 8) {
                    confirmPasswordInput.classList.add('is-valid');
                }
                
                if (!isValid) {
                    // Create Bootstrap toast notification
                    const toastContainer = document.createElement('div');
                    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                    toastContainer.style.zIndex = '11';
                    
                    toastContainer.innerHTML = `
                        <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    Please correct the errors in the form.
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(toastContainer);
                    
                    const toastElement = toastContainer.querySelector('.toast');
                    const toast = new bootstrap.Toast(toastElement);
                    toast.show();
                    
                    setTimeout(() => {
                        toastContainer.remove();
                    }, 5000);
                }
            });
            
            // Simple password strength calculator
            function calculatePasswordStrength(password) {
                let score = 0;
                
                // Length
                if (password.length >= 8) score++;
                if (password.length >= 12) score++;
                
                // Complexity
                if (/[A-Z]/.test(password) && /[a-z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[^A-Za-z0-9]/.test(password)) score++;
                
                return {
                    score: Math.min(score, 4)
                };
            }
        });
    </script>
</body>
</html>