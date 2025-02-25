<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';
include('connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.history.back();</script>";
        exit;
    }

    // Check email existence
    $stmt = $con->prepare("
        SELECT 'student' as type, registration_no as id FROM student WHERE email = ? 
        UNION 
        SELECT 'faculty' as type, fid as id FROM faculty WHERE email = ? 
        UNION 
        SELECT 'admin' as type, id FROM adminlogin WHERE aemail = ?
    ");
    $stmt->bind_param("sss", $email, $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate random alphanumeric password
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $new_password = '';
        for ($i = 0; $i < 8; $i++) {
            $new_password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $row = $result->fetch_assoc();
        
        // Update password based on user type
        $update_query = match($row['type']) {
            'student' => "UPDATE student SET password = ? WHERE email = ?",
            'faculty' => "UPDATE faculty SET password = ? WHERE email = ?",
            'admin' => "UPDATE adminlogin SET apassword = ? WHERE aemail = ?",
        };
        
        $redirect_url = match($row['type']) {
            'student' => 'index.php',
            'faculty' => 'faculty/faculty_login.php',
            'admin' => 'admin/adminlogin.php',
        };

        $update_stmt = $con->prepare($update_query);
        $update_stmt->bind_param("ss", $hashed_password, $email);
    
        if ($update_stmt->execute()) {
            $mail = new PHPMailer(true);
  
if ($update_stmt->execute()) {
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mujprojectallocationsystem@gmail.com'; // Your Gmail
        $mail->Password = 'qicn zpdu mxgg pdri'; // Use App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
        $mail->Port = 587; // TLS port is 587

        $mail->setFrom('mujprojectallocationsystem@gmail.com', 'Admin');
        $mail->addAddress($email);

        // Embed the logo after initializing PHPMailer
        $mail->AddEmbeddedImage('../muj/photo/manipallogo.png', 'logo', 'manipallogo.png');

        $mail->isHTML(true);
        $mail->Subject = "Password Reset";

        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Password Reset</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 480px;
                    margin: 20px auto;
                    background-color: #ffffff;
                    padding: 25px;
                    border-radius: 6px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                .logo {
                    width: 150px;
                       height:80px;
                    margin-bottom: 15px;
                }
                .header {
                    color: #1a237e;
                    font-size: 20px;
                    margin-bottom: 15px;
                }
                .content {
                    color: #424242;
                    font-size: 14px;
                    margin-bottom: 20px;
                    text-align: left;
                    margin-top:20px;
                }
                .password-box {
                    background: #f5f5f5;
                    padding: 10px;
                    border-radius: 4px;
                    font-size: 16px;
                    font-weight: bold;
                    text-align: center;
                    margin: 10px 0;
                    color: #1a237e;
                }
                .footer {
                    color: #757575;
                    font-size: 12px;
                    text-align: center;
                    margin-top: 15px;
                    padding-top: 10px;
                    border-top: 1px solid #eeeeee;
                }
            </style>
        </head>
        <body>
            <div class='container m-5'>
                <img src='cid:logo' alt='Manipal University Jaipur' class='logo'>
                <h2 class='header'>Password Reset Notification</h2>
                <div class='content'>
                    <p>Dear User,</p>
                    <p>Your password has been reset successfully. Your temporary password is:</p>
                    <div class='password-box'>{$new_password}</div>
                    <p><strong>Next Steps:</strong></p>
                    <ul>
                        <li>Log in using this temporary password</li>
                        <li>Change your password immediately</li>
                        <li>Keep your new password secure</li>
                    </ul>
                    <p>If you didn't request this reset, please contact IT support immediately.</p>
                </div>
                <div class='footer'>
                    <p>This is an automated email. Please do not reply.</p>
                    <p>© " . date('Y') . " Manipal University Jaipur | All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";

        $mail->send();
        echo "<script>alert('New password sent to your email!'); window.location.href='$redirect_url';</script>";
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo);
        echo "<script>alert('Email sending failed. Check your email configuration.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Password update failed.'); window.history.back();</script>";
}
        }

    } else {
        echo "<script>alert('Email not found!'); window.history.back();</script>";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link rel="stylesheet" href="common-styling.css">
  
  <!-- Keep Bootstrap 5 files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
  <!------------------------------------ boostrap 5 files ---------------------->
  <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <script src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
  
  <link rel="icon" href="../muj/photo/muj-title-logo.png" type="image/png">
  
  <style>
    
 /* Base Button Styling */
 .btn {
    position: relative;
    margin: 10px;
    color: white;
    border: 2px solid rgb(255, 255, 255);
    border-radius: 50px;
    font-weight: bold;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    overflow: hidden;
    cursor: pointer;

    /* Smooth Transitions */
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), 
                transform 0.1s ease-in-out;

    /* Prevent Text Selection */
    user-select: none;
    -webkit-user-select: none;
}

/* Background Overlay Effect */
.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        120deg, 
        transparent, 
        rgba(255, 255, 255, 0.3), 
        transparent
    );
    
    transition: all 0.5s ease;
    z-index: 1;
}

/* Hover Effects */
.btn:hover {
    background-color: white;
    transform: translateY(-3px);
}

.btn:hover::before {
    left: 100%;
}

.btn:active {
    transform: translateY(1px);
    transition: all 0.1s ease;
}

.btn span {
    position: relative;
    z-index: 2;
    transition: color 0.3s ease;
}

.btn:focus {
    outline: none;
}

/* Red Button Styles */
#btnred {
    background-color: rgb(253, 10, 34); /* Red */
}

#btnred:hover {
  color: rgb(252, 4, 4);
  box-shadow: 0 5px 15px rgba(253, 10, 34, 0.85);
    background-color: rgb(242, 240, 241); /* Red */
    border:2px solid red;
}

#btnred:active {
    box-shadow: 0 2px 5px rgba(253, 10, 34, 0.2);
}

#btnred:focus {
    box-shadow: 0 0 0 3px rgb(253, 10, 34);
}

/* Orange Button Styles */
#btnorange {
    background-color: rgb(255, 87, 34); /* Orange */
}

#btnorange:hover {
    color: rgb(255, 64, 0);
    box-shadow: 0 5px 15px rgba(255, 86, 34, 0.95);
    border: 2px solid rgba(255, 86, 34, 0.95);
    background-color: rgb(247, 247, 247); /* Orange */
    
}

#btnorange:active {
    box-shadow: 0 2px 5px rgba(255, 86, 34, 0.82);
}

#btnorange:focus {
    box-shadow: 0 0 0 3px rgb(255, 87, 34);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .btn {
        padding: 10px 25px;
        font-size: 14px;
    }
}



  </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-light rounded">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Forgot Password</h3>
                    <p class="text-center text-muted mb-4">Enter your registered Outlook email below to receive a password reset link.</p>
                    
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Enter your Outlook Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="your.email@muj.manipal.edu" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="btnorange" class="btn btn-warning btn-block mt-3 px-4 py-2">
                                <i class="fas fa-envelope"></i> Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<?php

include('../muj/student/studentfooter.php');

?>

