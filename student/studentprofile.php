<?php
include('../student/studentsidebar.php');

?>
<div class="main_content">

<div class="row mt-5">
    <!-- Notice Board Section -->
    <div class="col-lg-5 mb-5">
        <div class="profile-card p-3">
            <div class="card-custom-header d-flex justify-content-between align-items-center">
                <h5 class="mb-3">
                    <i class="fas fa-sticky-note m-2"></i>Notice Board
                </h5>
            </div>
            <div class="card-body">
                <!-- Filter Options -->
                <ul class="nav nav-pills mb-4">
                    <li class="nav-item">
                        <a class="nav-link <?= $filter === 'all' ? 'active' : '' ?>" href="?filter=all">
                            <i class="fas fa-globe me-2"></i>All Notices
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $filter === 'faculty' ? 'active' : '' ?>" href="?filter=faculty">
                            <i class="fas fa-user-tie me-2"></i>Faculty Notices
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $filter === 'admin' ? 'active' : '' ?>" href="?filter=admin">
                            <i class="fas fa-crown me-2"></i>Admin Notices
                        </a>
                    </li>
                </ul>

                <div class="notice-list">
                    <?php if (!empty($notifications)): ?>
                        <?php foreach ($notifications as $row): ?>
                            <div class="notice-card card <?= isset($row['type']) && $row['type'] == 'faculty' ? 'faculty-notice' : 'admin-notice' ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="card-title mb-0" style="font-weight:bold">
                                            <?= isset($row['title']) ? htmlspecialchars($row['title']) : 'No Title' ?>
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <span class="badge <?= isset($row['type']) && $row['type'] == 'faculty' ? 'bg-primary' : 'bg-danger' ?> me-2">
                                                <?= isset($row['type']) ? htmlspecialchars($row['type']) : 'No Type' ?> Notice
                                            </span>
                                        </div>
                                    </div>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        Posted on: <?= isset($row['notice_date']) ? $row['notice_date'] : 'No Date' ?>
                                    </p>
                                    <p class="card-text" style="font-weight:bold">
                                        <?= isset($row['description']) ? htmlspecialchars($row['description']) : 'No Description' ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>No notices found.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Profile Section -->
    <div class="col-lg-7">
        <div class="profile-card">
            <h5 style="font-weight:bold; color: rgb(236, 76, 8); text-align: left;">Student Profile</h5><br>

            <img 
  src="<?php echo htmlspecialchars(!empty($student['image']) ? "../uploads/$image" : '../photo/user_profile.jpg'); ?>" 
  style="margin-top:50px" 
  width="150" 
  height="150"
/>

            <form class="row g-3 m-3" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="col-md-6">
                    <label for="registration_no" class="form-label">Registration No</label>
                    <input type="text" class="form-control" id="registration_no" name="registration_no" value="<?php echo htmlspecialchars($registration_no); ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Student Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required onkeyup="validateName()">
                    <small id="nameError" class="text-danger"></small>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Student Outlook Id</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required onkeyup="validateEmail()" readonly>
                    <small id="emailError" class="text-danger"></small>
                </div>
                <div class="col-md-6">
                    <label for="mobile" class="form-label">Student Mobile Number</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required onkeyup="validateMobile()">
                    <small id="mobileError" class="text-danger"></small>
                </div>
                <div class="col-md-6">
                    <label for="section" class="form-label">Student Section</label>
                    <input type="text" class="form-control" id="section" name="section" value="<?php echo htmlspecialchars($section); ?>" readonly required>
                </div>
                <div class="col-md-6">
                    <label for="year" class="form-label">Student Year</label>
                    <input type="text" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>" readonly required>
                </div>
                <div class="col-md-6">
                    <label for="sem" class="form-label">Student Semester</label>
                    <input type="text" class="form-control" id="semester" name="s" value="<?php echo htmlspecialchars($semester); ?>" readonly required>
                </div>
                <div class="col-md-12">
                    <label for="image" class="form-label">Upload Profile Image (PNG, JPG only)</label>
                    <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png">
                </div>
                <div class="col-12 mt-5">
                    <button class="btn" style="width:200px" id="btnorange" name="updateStudent" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- End of row -->
</div>
                    </div>
                    </div>
                    </div>     



<script>
// Real-time validation for the Name field
function validateName() {
    const name = document.getElementById('name').value;
    const namePattern = /^[a-zA-Z\s]+$/;
    const nameError = document.getElementById('nameError');

    if (!name.match(namePattern)) {
        nameError.textContent = 'Name should only contain characters.';
    } else {
        nameError.textContent = '';
    }
}

// Real-time validation for the Email field
function validateEmail() {
    const email = document.getElementById('email').value;
    const emailPattern = /^[a-zA-Z]+\.\d+@muj\.manipal\.edu$/;
    const emailError = document.getElementById('emailError');

    if (!email.match(emailPattern)) {
        emailError.textContent = 'Invalid Outlook ID format. Use name.enrollment_no@muj.manipal.edu';
    } else {
        emailError.textContent = '';
    }
}

// Real-time validation for the Mobile field
function validateMobile() {
    const mobile = document.getElementById('mobile').value;
    const mobilePattern = /^\d{10}$/;
    const mobileError = document.getElementById('mobileError');

    if (!mobile.match(mobilePattern)) {
        mobileError.textContent = 'Mobile number should be exactly 10 digits.';
    } else {
        mobileError.textContent = '';
    }
}

// Final form validation on submit
function validateForm() {
    validateName();
    validateEmail();
    validateMobile();

    // Ensure no error messages are displayed
    if (document.getElementById('nameError').textContent || 
        document.getElementById('emailError').textContent || 
        document.getElementById('mobileError').textContent) {
        return false;
    }
    return true;
}
</script>

<script>
// Existing 3D card movement script
document.addEventListener('mousemove', (e) => {
    const card = document.querySelector('.profile-card');
    const { clientX: x, clientY: y } = e;

    const cardRect = card.getBoundingClientRect();
    const cardX = cardRect.left + cardRect.width / 2;
    const cardY = cardRect.top + cardRect.height / 2;

    const angleX = ((x - cardX) / cardRect.width) * 10;
    const angleY = ((y - cardY) / cardRect.height) * -10;

    card.style.transform = `rotateY(${angleX}deg) rotateX(${angleY}deg)`;
});
</script>




<?php

include('../student/studentfooter.php');

?>
