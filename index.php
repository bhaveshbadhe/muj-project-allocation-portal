<?php
include('connection/connection.php');

session_start();


$lock_until_timestamp = isset($_SESSION['lock_until']) ? $_SESSION['lock_until'] : null;



// Function to sanitize input (in case you need additional sanitation)
function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

if (isset($_POST['login'])) {
    // Retrieve registration_no and password from form
    $registration_no = sanitize_input($_POST['registration_no']);
    $password = sanitize_input($_POST['password']);

    // SQL query with prepared statement to prevent SQL injection
    $sql = "SELECT * FROM `student` WHERE registration_no=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $registration_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // registration_no does not exist
        echo "<script>alert('Registration number does not exist. Please try again.');</script>";
    } else {
        $row = $result->fetch_assoc();
        $current_time = new DateTime();
        $lock_until = new DateTime($row['lock_until']);
        $is_locked_out = ($row['failed_attempts'] >= 5 && $current_time < $lock_until);

        if ($is_locked_out) {
            // User is locked out for 30 minutes
            $remaining_time = $lock_until->getTimestamp() - $current_time->getTimestamp();
            echo "<script>alert('You are locked out. Please try again in " . gmdate("i:s", $remaining_time) . " minutes.');</script>";
        } else {
            // Verify the hashed password
            if (password_verify($password, $row['password'])) {
                // Successful login, reset failed attempts
                $_SESSION['is_login'] = true;
                $_SESSION['registration_no'] = $registration_no;

                // Regenerate session ID for security
                session_regenerate_id(true);

                // Reset failed attempts and lock_until
                $sql_reset_attempts = "UPDATE student SET failed_attempts = 0, lock_until = NULL WHERE registration_no = ?";
                $stmt_reset = $con->prepare($sql_reset_attempts);
                $stmt_reset->bind_param("s", $registration_no);
                $stmt_reset->execute();

                header("Location: student/studentprofile.php");
                exit();
            } else {
                // Incorrect password: increment failed attempts
                $failed_attempts = $row['failed_attempts'] + 1;
                $lock_until_time = null;

                if ($failed_attempts >= 5) {
                    // Lock the user for 30 minutes
                    $lock_until_time = (new DateTime())->modify('+30 minutes')->format('Y-m-d H:i:s');
                    echo "<script>alert('You have reached 5 failed attempts. Your account is locked for 30 minutes.');</script>";
                } else {
                    echo "<script>alert('Password is incorrect. You have $failed_attempts out of 5 attempts left.');</script>";
                }

                // Update the database with the new failed attempts and lock_until time (if applicable)
                $sql_update_attempts = "UPDATE student SET failed_attempts = ?, lock_until = ? WHERE registration_no = ?";
                $stmt_update = $con->prepare($sql_update_attempts);
                $stmt_update->bind_param("iss", $failed_attempts, $lock_until_time, $registration_no);
                $stmt_update->execute();
            }
        }
    }

    $stmt->close();
}

$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>

<meta name="title" content="Muj Project Allocation" />
    <meta name="description" content="The MUJ Project Allocation Portal is a dynamic project management system designed for Manipal University Jaipur (MUJ) students and faculty. It enables students to select projects, view notifications, manage project partners, and track project progress. Faculty members can manage student project allocations through manual entries or by uploading an Excel file containing student details. The admin has an overseeing role, managing both student and faculty records and overseeing all project allocation activities" />
    <meta property="og:image" content="https://upload.wikimedia.org/wikipedia/en/1/1f/Manipal_University_Jaipur_logo.png" />  
    
    <meta property="instagram:url" content="https://www.instagram.com/rakesh.mali03/" />
    <meta property="linkedin:url" content="https://www.linkedin.com/in/rakesh-mali-a15082229/" />
    <meta property="linkedin:url" content="https://www.linkedin.com/in/bhavesh-badhe/" />

    <meta property="linkedin:url" content="https://www.linkedin.com/in/vighnesh-nikam-162371221/" />
  

  <meta charset="UTF-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login</title>
  <link rel="icon" href="../muj/photo/muj-title-logo.png" type="image/png">


<link rel="stylesheet" href="common-styling.css">
  

<!------------------------------------ boostrap 5 files ---------------------->
<link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
<script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>


<!------------------------------tables tinks-------------------------------->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

<style>
 
/* Form and floating labels */
.form-control {
  border: none;
  border-bottom: 3px solid orange;
  background: transparent;
}

label {
  font-size: 20px;
  font-weight: bold;
  color: rgb(236, 76, 8);
  text-shadow: 2px 2px 2px white;
  transition: all 0.3s ease;
}

.form-group {
  position: relative;
  margin-top: 40px;
}

.form-group label {
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-100%);
  font-size: 18px;
  pointer-events: none;
}

.form-control:focus + label,
.form-control:not(:placeholder-shown) + label {
  top: -10px;
  left: 0;
  font-size: 18px;
  color: rgb(236, 76, 8);
}

/* Make the label stay at the top */
.label-fixed {
  top: -20px;
  font-size: 18px;
  color: rgb(236, 76, 8);
}



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




<style>


  </style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center" style="height: 100vh; max-width: 1000px; margin: auto;">

  <div class="row g-0 container m-5" style="" id="border">
    
    <div class="col-md-6" id="bg-logo">
    <div class="card-body-img"  id="backgroundmujlogo" style="background-color:white" >
    <div class="card-body">
   

      <a href="admin/adminlogin.php">
    <img src="photo/logo-4.png" alt="Project Management Portal Logo" class="mujlogo m-2">
    </a>

    <h4 class="text-center m-2">Welcome to Project Allocation Portal</h4>
      
                <!-- Lockout timer -->
                <p id="lockout-timer" style="color: red; font-weight: bold;"></p>
        <!-- <h4 class="card-title mt-3 text-center">Welcome To Project Allocation Portal</h4> -->

        <h3 class="card-title mt-3 text-center" style="color:rgb(236, 76, 8); font-weight:bold">Student Login</h3>

        <form method="POST">
  <div class="form-group">
    <input type="text" name="registration_no" class="form-control" id="exampleInputEmail1" required placeholder=" ">
    <label for="exampleInputEmail1">Registration No.</label>
  </div>

  <div class="form-group">
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" required placeholder=" ">
    <label for="exampleInputPassword1">Password</label>
  </div>

  <!-- Adjust the Forget Password link to be aligned to the right -->
  <div class="form-group">
    <a href="forgot_password.php" class="">Forgot Password?</a>
  </div>

  <div class="form-group mt-3">
    <button type="submit" name="login" class="btn" id="btnorange">Student Login</button>
    <a class="btn ml-4" id="btnorange" href="faculty/faculty_login.php">Faculty Login</a>
  </div>
</form>
        
      </div>

    </div>
</div>
    <div class="col-md-6">
    <img src="./photo/309265193_632350475267681_7312101025959226612_n.jpg" 
         class="img-fluid fade-in" 
         alt="Manipal University Image" 
         style="max-width: 100%; height: 100%;">

</div>

  </div>

</div>

<!-- JavaScript to fix floating labels -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const formGroups = document.querySelectorAll('.form-group');

    formGroups.forEach(function(group) {
      const input = group.querySelector('.form-control');
      const label = group.querySelector('label');

      input.addEventListener('focus', function() {
        label.classList.add('label-fixed');
      });

      input.addEventListener('blur', function() {
        if (!input.value) {
          label.classList.remove('label-fixed');
        }
      });

      if (input.value) {
        label.classList.add('label-fixed');
      }
    });
  });
</script>
<!-- JavaScript for Lockout Timer -->
<script>
   document.addEventListener("DOMContentLoaded", function() {
    // PHP lockout time passed as JavaScript variable
    var lockUntil = <?php echo !empty($lock_until_timestamp) ? $lock_until_timestamp : 'null'; ?>;
    
    if (lockUntil) {
        startCountdown(lockUntil);
    }

    // Function to handle password attempts
    function handlePasswordAttempt(isCorrect) {
        if (!isCorrect) {
            attempts++;
            if (attempts >= 5) {
                // Lockout logic
                var currentTime = Math.floor(Date.now() / 1000);
                lockUntil = currentTime + lockoutDuration; // Set the lockout time in seconds
                document.getElementById('lockout-timer').textContent = 'You are locked out. Try again in 30 minutes.';
                startCountdown(lockUntil);
            }
        } else {
            // Reset attempts if the password is correct
            attempts = 0;
            document.getElementById('lockout-timer').textContent = ''; // Clear the message
        }
    }

    // Function to start the countdown
    function startCountdown(lockUntil) {
        var countdownInterval = setInterval(function() {
            var currentTime = Math.floor(Date.now() / 1000); // Current time in seconds
            var remainingTime = lockUntil - currentTime; // Time left in seconds

            if (remainingTime > 0) {
                var minutes = Math.floor(remainingTime / 60);
                var seconds = remainingTime % 60;
                document.getElementById('lockout-timer').textContent = 
                    'You are locked out. Try again in ' + minutes + ' minutes and ' + (seconds < 10 ? '0' : '') + seconds + ' seconds.';
            } else {
                // Clear the timer once the lockout period is over
                clearInterval(countdownInterval);
                document.getElementById('lockout-timer').textContent = ''; // Clear the message after countdown finishes
                attempts = 0; // Reset attempts after lockout
            }
        }, 1000); // Update the timer every second
    }
});
</script>

</body>
</html>


 

