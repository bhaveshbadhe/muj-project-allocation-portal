<?php 
session_start();
include('../student/studentsidebar.php');



// Get the semester from the session
$semester = $_SESSION['semester'] ?? '';
// Check if the user has already submitted the form
$registration_no = $_SESSION['registration_no'];
// Function to check if registration_no is already allocated
function isRegistrationNoAllocated($con, $registration_no) {
    $query = "SELECT * FROM allocated_project WHERE registration_no = '$registration_no'";
    $result = mysqli_query($con, $query);
    $exists = mysqli_num_rows($result) > 0; // Returns true if registration_no exists
    mysqli_free_result($result); // Free result set
    return $exists;
}

// Function to fetch the selected project details
function getSelectedProjectDetails($con, $registration_no, $semester) {
    $query = "
        SELECT 
            ap.registration_no, p.p_id, p.pname, p.pdesc, p.max_student, p.no_of_student_allocated, p.semester, p.project_domain_type,
            f.fname, f.email, f.mobile, n.message, n.datetime
        FROM 
            allocated_project ap
        INNER JOIN 
            project p ON ap.p_id = p.p_id
        INNER JOIN 
            faculty f ON p.fid = f.fid
        LEFT JOIN 
            notifications n ON n.p_id = p.p_id AND n.registration_no = ap.registration_no
        WHERE 
            ap.registration_no = '$registration_no'
            AND p.semester = '$semester'"; // Filter by semester
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result); // Free result set
    return $data;
}

function getNotificationsForProject($con, $p_id, $semester, $registration_no) {
    $query = "
        SELECT * 
        FROM notifications 
        WHERE  registration_no = '$registration_no'"; // Filter by semester
    $result = mysqli_query($con, $query);
    $notifications = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }
    mysqli_free_result($result); // Free result set
    return $notifications;
}


// Function to fetch students allocated to the same project
function getStudentsInSameProject($con, $p_id, $semester) {
    $query = "
        SELECT 
            ap.registration_no, s.name, s.mobile_no, s.email
        FROM 
            allocated_project ap
        INNER JOIN 
            student s ON ap.registration_no = s.registration_no
        WHERE 
            ap.p_id = '$p_id'
            AND s.semester = '$semester'"; // Filter by semester
    $result = mysqli_query($con, $query);
    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
    mysqli_free_result($result); // Free result set
    return $students;
}


$hasSubmitted = isRegistrationNoAllocated($con, $registration_no);

// Check if form is submitted
// Fetch year and section based on registration_no
$student_query = "SELECT year, section FROM student WHERE registration_no = '$registration_no'";
$student_result = mysqli_query($con, $student_query);

if ($student_row = mysqli_fetch_assoc($student_result)) {
    $year = $student_row['year'];
    $section = $student_row['section'];
} else {
    // Handle case where student details are not found
    echo "<script>alert('Error: Unable to fetch student details.');</script>";
    $year = '';
    $section = '';
}
mysqli_free_result($student_result);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$hasSubmitted) {
    $selected_project_id = $_POST['select_project'];

    // Fetch the fid corresponding to the selected project
    $query = "SELECT fid FROM project WHERE p_id = '$selected_project_id' AND semester = '$semester'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $faculty_id = $row['fid'];
    mysqli_free_result($result);

    echo "<script>
    if (confirm('Are you sure you want to select this project? Once selected, it cannot be changed.')) {
        document.getElementById('projectForm').submit();
    }
</script>";

    // Insert the allocation into the allocated_project table
    $insert_query = "INSERT INTO allocated_project (registration_no, p_id, fid, year, semester, section) 
                     VALUES ('$registration_no', '$selected_project_id', '$faculty_id', '$year', '$semester', '$section')";

    if (mysqli_query($con, $insert_query)) {
        // Set the flag to indicate the form has been submitted
        $hasSubmitted = true;
        // Hide the radio buttons using CSS
        echo "<style>input[type='radio'] { display: none; }</style>";
        echo "<script>alert('Project selected successfully.');</script>";
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
    }
}

// Fetch the selected project details if the user has already selected a project
$selectedProject = $hasSubmitted ? getSelectedProjectDetails($con, $registration_no, $semester) : null;

// Fetch notifications for the selected project
$notifications = $selectedProject ? getNotificationsForProject($con, $selectedProject['p_id'], $semester, $registration_no) : [];



// Fetch students allocated to the same project if a project is selected
$studentsInSameProject = $selectedProject ? getStudentsInSameProject($con, $selectedProject['p_id'], $semester) : [];

?>



<div class="container-fluid dashboard-container">
    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title text-start mb-4">
                        <i data-feather="layers" class="me-2"></i>Project Hub
                    </h3>
                    <div class="nav nav-pills flex-column text-start">
                        <a class="nav-link active" data-bs-toggle="tab" href="#project-selection">
                            <i data-feather="search" class="me-2"></i>Project Selection
                        </a>
                        <a class="nav-link" data-bs-toggle="tab" href="#allocation-status">
                            <i data-feather="pie-chart" class="me-2"></i>Allocation Status
                        </a>
                        <a class="nav-link" data-bs-toggle="tab" href="#project-members">
                            <i data-feather="users" class="me-2"></i>Project Team
                        </a>
                        <a class="nav-link text-muted" data-bs-toggle="tab" href="#evaluation">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="25" height="25" fill="none" stroke="currentColor" stroke-width="2" class="me-2" >
                                <!-- Clipboard -->
                                <rect x="16" y="8" width="32" height="48" rx="4" fill="white" />
                                <rect x="20" y="12" width="24" height="6" rx="2" fill="currentColor" />
                                <!-- Lines on clipboard -->
                                <line x1="20" y1="24" x2="44" y2="24" stroke="currentColor" stroke-width="2" />
                                <line x1="20" y1="30" x2="44" y2="30" stroke="currentColor" stroke-width="2" />
                                <line x1="20" y1="36" x2="44" y2="36" stroke="currentColor" stroke-width="2" />
                                <!-- Magnifying glass -->
                                <circle cx="40" cy="40" r="8" stroke="currentColor" stroke-width="2" fill="white" />
                                <line x1="45" y1="45" x2="50" y2="50" stroke="currentColor" stroke-width="2" />
                                <!-- Checkmark -->
                                <path d="M37 38 l2 2 l3 -4" stroke="currentColor" stroke-width="2" fill="none" />
                            </svg>
                            Project Evaluation
                        </a>
                        <a class="nav-link" data-bs-toggle="tab" href="#notifications">
                            <i data-feather="bell" class="me-2"></i>Notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>

    

<!--------------------project list -------------------->
<div class="col-md-9">
    <div class="tab-content">
        <div class="tab-pane fade show active" id="project-selection">
            <div class="container-fluid">
                <div class="row mb-4 align-items-center" >
                <div class="col-md-7 m-4">
            <div class="project-heading" >
                <h3 class="display-6 d-flex align-items-center">
                    <i class="fe fe-layers project-icon text-white"></i>
                    Available Projects
                </h3>
                <p class="lead subtitle mb-0">Select your ideal project for the upcoming semester</p>
            </div>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
    <div class="search-wrapper" style="position: relative; display: inline-block;">
        <input type="text" id="searchInput" class="search-input" 
               placeholder="Search Project ..." 
              style="padding-left: 35px; border: 2px solid orange; border-radius: 5px; outline: none; background-color:white"
               aria-label="Search through project data">
        <i class="fas fa-search search-icon" 
           style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray;"></i>
    </div>
</div>
      
</div>

<form method="POST" action="" class="project-selection-form" id="projectsTable" class="searchtable">
    <div class="row g-4">
        <?php
        $semester = $_SESSION['semester'] ?? '';

        if ($semester !== '') {
            $projects_query = "
                SELECT 
                    p.p_id, 
                    p.pname, 
                    p.pdesc, 
                    f.fname, 
                    f.email, 
                    p.max_student, 
                    p.project_domain_type,
                    p.no_of_student_allocated, 
                    f.mobile,
                    f.image
                FROM 
                    project p 
                INNER JOIN 
                    faculty f ON p.fid = f.fid 
                WHERE 
                    p.no_of_student_allocated < p.max_student
                    AND p.semester = '$semester'";

            $projects_result = mysqli_query($con, $projects_query);

            if (mysqli_num_rows($projects_result) > 0) {
                while ($project = mysqli_fetch_assoc($projects_result)) : ?>
                   <div class="col-md-4 project-item" data-domain="<?= htmlspecialchars($project['project_domain_type']) ?>">
    <div class="card h-100 shadow-sm project-card">
        <!-- Project Domain Badge -->
        <div  class="domain-badge <?= strtolower(str_replace(' ', '-', $project['project_domain_type'])) ?>">
            <?= htmlspecialchars($project['project_domain_type']) ?>
        </div>
        
        <div class="card-body d-flex flex-column">
            <!-- Card Header with Project Name and Capacity -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title font-weight-bold mb-0">
                    <?= htmlspecialchars($project['pname']) ?>
                </h5>
                <div class="capacity-indicator mt-3">
                    <div class="d-flex align-items-center">
                        <i class="fe fe-users me-1"></i>
                        <span class="badge capacity-badge">
                            <?= $project['no_of_student_allocated'] ?> / <?= $project['max_student'] ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Project Description -->
            <p class="card-text description mb-4 flex-grow-1">
                <?= htmlspecialchars(substr($project['pdesc'], 0, 100)) ?>
                <?php if (strlen($project['pdesc']) > 100) : ?>
                    <span class="description-truncated">...</span>
                    <span class="description-full d-none"><?= htmlspecialchars(substr($project['pdesc'], 100)) ?></span>
                    <a href="#" class="read-more small">Read more</a>
                <?php endif; ?>
            </p>
            
            <!-- Faculty Info Block -->
            <div class="faculty-info mb-3 p-3">
                <div class="row g-2 align-items-center">
                <div class="col-auto">
    <div class="faculty-avatar">
        <img 
            src="<?php echo htmlspecialchars(!empty($project['image']) ? "../uploads/{$project['image']}" : '../photo/user_profile.jpg'); ?>" 
            alt="Faculty Image"
        />
    </div>
</div>

                    <div class="col">
                        <h6 class="faculty-name mb-1"><?= htmlspecialchars($project['fname']) ?></h6>
                        <div class="contact-info">
                            <a href="mailto:<?= htmlspecialchars($project['email']) ?>" class="text-muted small me-2">
                                <i class="fe fe-mail me-1"></i><?= htmlspecialchars($project['email']) ?>
                            </a>
                            <a href="tel:<?= htmlspecialchars($project['mobile']) ?>" class="text-muted small">
                                <i class="fe fe-phone me-1"></i><?= htmlspecialchars($project['mobile']) ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Bar with Clear Label -->
            <div class="capacity-progress mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-muted small">Capacity</span>
                    <span class="text-muted small">
                        <?= ($project['no_of_student_allocated'] / $project['max_student']) * 100 ?>% filled
                    </span>
                </div>
                <div class="progress" style="height: 6px;">
                    <div 
                        class="progress-bar" 
                        role="progressbar" 
                        style="width: <?= ($project['no_of_student_allocated'] / $project['max_student']) * 100 ?>%"
                        aria-valuenow="<?= $project['no_of_student_allocated'] ?>"
                        aria-valuemin="0"
                        aria-valuemax="<?= $project['max_student'] ?>"
                    ></div>
                </div>
            </div>
            
            <!-- Selection Controls -->
            <div class="selection-controls mt-auto">
                <div class="form-check custom-control custom-radio mb-3">
                    <input 
                        class="form-check-input custom-control-input" 
                        type="radio" 
                        name="select_project" 
                        value="<?= $project['p_id'] ?>" 
                        id="project<?= $project['p_id'] ?>" 
                        required
                    >
                    <label class="form-check-label custom-control-label" for="project<?= $project['p_id'] ?>">
                        Select this project
                    </label>
                </div>
                
                <button type="submit" class="btn w-100" id="btnorange" name="confirm_project" value="<?= $project['p_id'] ?>">
                    <i class="fe fe-check-circle me-2"></i>Confirm Selection
                </button>
            </div>
        </div>
    </div>
</div>
                <?php endwhile;
            } else {
                echo "<div class='col-12'><p class='text-danger'>No projects are currently available for your semester.</p></div>";
            }
        } else {
            echo "<div class='col-12'><p class='text-danger'>Semester information is missing. Please contact the administrator.</p></div>";
        }
        ?>
    </div>
</form>
</div>
        </div>
                    <!-- Allocation Status Tab -->
                    <div class="tab-pane fade" id="allocation-status">
                        <?php if ($hasSubmitted && $selectedProject): ?>
                        <div class="card card-custom">
                            <div class="card-body">
                                <h2 class="card-title mb-4">
                                    <i data-feather="check-circle" class="me-2 text-warning"></i>
                                    Project Allocation Details
                                </h2>
                                <div class="row" style="text-align:left">
                                    <div class="col-md-6">
                                        <h5 class="text-muted">Project Information</h5>
                                        <div class="mb-3">
                                            <strong>Project ID:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['p_id']); ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Project Name:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['pname']); ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Description:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['pdesc']); ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Project Domain Type:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['project_domain_type']); ?>
                                        </div>
                                        <div class="mb-3">
    <strong>Project Status:</strong> 
    <?php 
    echo isset($selectedProject['message']) 
        ? htmlspecialchars($selectedProject['message']) 
        : 'Pending....';
    ?>
</div>

                                 
                                    <div class="mb-3">
    <strong>DATE TIME:</strong> 
    <?php 
    echo isset($selectedProject['datetime']) 
        ? htmlspecialchars($selectedProject['datetime']) 
        : 'Pending....';
    ?>
</div>

                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="text-muted">Additional Details</h5>
                                        <div class="mb-3">
                                            <strong>Registration Number:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['registration_no']); ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Faculty Mentor:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['fname']); ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Faculty Contact No:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['mobile']); ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Faculty Outlook Id:</strong> 
                                            <?php echo htmlspecialchars($selectedProject['email']); ?>
                                        </div>
                                  
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <i data-feather="alert-triangle" class="me-2"></i>No Project Allocated Yet
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Project Members Tab -->
                    <div class="tab-pane fade" id="project-members">
                        <div class="card card-custom">
                            <div class="card-body">
                                <h2 class="card-title mb-4">
                                    <i data-feather="users" class="me-2 text-warning"></i>Project Team Members
                                </h2>
                                <?php if (!empty($studentsInSameProject)): ?>
                                <div class="row g-3">
                                    <?php foreach ($studentsInSameProject as $student): ?>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <?php echo strtoupper(substr($student['name'], 0, 1)); ?>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1"><?php echo htmlspecialchars($student['name']); ?></h5>
                                                        <small class="text-muted"><?php echo htmlspecialchars($student['registration_no']); ?></small>
                                                    </div>
                                                </div>
                                                <div class="small text-muted">
                                                    <div class="mb-1">
                                                        <i data-feather="mail" class="me-2" style="width: 14px; height: 14px;"></i>
                                                        <?php echo htmlspecialchars($student['email']); ?>
                                                    </div>
                                                    <div>
                                                        <i data-feather="phone" class="me-2" style="width: 14px; height: 14px;"></i>
                                                        <?php echo htmlspecialchars($student['mobile_no']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <i data-feather="info" class="me-2"></i>No team members found
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Tab -->
                    <div class="tab-pane fade" id="notifications">
                        <div class="card card-custom">
                            <div class="card-body">
                                <h2 class="card-title mb-4">
                                    <i data-feather="bell" class="me-2 text-warning"></i>Project Notifications
                                </h2>
                                <?php if (!empty($notifications)): ?>
                                <div class="list-group">
                                    <?php foreach ($notifications as $notification): ?>
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">Project Update</h5>
                                            <small class="text-muted">
                                                <?php echo date('F j, Y', strtotime($notification['created_at'] ?? 'now')); ?>
                                            </small>
                                        </div>
                                        <p class="mb-1 text-muted">
                                            <?php echo htmlspecialchars($notification['message']); ?>
                                        </p>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <i data-feather="info" class="me-2"></i>No notifications at this time
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                      <!-- evalutaion Tab -->
                      <div class="tab-pane fade" id="evaluation">
                        <div class="card card-custom">
                            <div class="card-body">
                                <h2 class="card-title mb-4">
                                    <i data-feather="bell" class="me-2 text-warning"></i>Project evalution coming soon 
                                </h2>
            </div>
        </div>
    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
    // Initialize Feather icons
    feather.replace();

    // Optional: Add click event to project cards for visual selection
    document.querySelectorAll('.project-selection-card').forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            document.querySelectorAll('.project-selection-card').forEach(c => c.classList.remove('selected'));
            
            // Add selected class to clicked card
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        });
    });

    // Hide the button when the form is submitted
    const form = document.querySelector('form'); // Replace with the correct form selector if necessary
    if (form) {
        form.addEventListener('submit', function(event) {
            const submitButton = document.getElementById('submit-project');
            if (submitButton) {
                submitButton.style.display = 'none'; // Hide the button
            }
        });
    }
</script>



<!-- <script>
$(document).ready(function () {
    $('#searchInput').on('input', function () {
        let searchValue = $(this).val().toLowerCase();
        
        $('.project-card').each(function () {
            let projectName = $(this).find('.card-title').text().toLowerCase();
            let facultyName = $(this).find('.project-details .col-3 small:last-child').text().toLowerCase();
            let description = $(this).find('.card-text').text().toLowerCase();
            let domainType = $(this).find('.project-details .col-4:last-child small:last-child').text().toLowerCase();

            if (projectName.includes(searchValue) || 
                facultyName.includes(searchValue) || 
                description.includes(searchValue) || 
                domainType.includes(searchValue)) {
                $(this).parent().show(); // Show the card
            } else {
                $(this).parent().hide(); // Hide the card
            }
        });
    });
});
</script> -->




<script>

    
    // Domain filtering functionality
    const createDomainFilter = () => {
        // Get all unique domains
        const domains = new Set();
        document.querySelectorAll('.project-item').forEach(item => {
            domains.add(item.dataset.domain);
        });
        
        // Create filter container
        const filterContainer = document.createElement('div');
        filterContainer.className = 'domain-filter-container d-flex flex-wrap mb-4 justify-content-center';
        
        // Add "All" button
        const allButton = document.createElement('button');
        allButton.className = 'btn btn-sm btn-outline-primary m-1 active';
        allButton.textContent = 'All Projects';
        allButton.dataset.domain = 'all';
        filterContainer.appendChild(allButton);
        
        // Add domain-specific buttons
        domains.forEach(domain => {
            if (!domain) return; // Skip empty domains
            
            const button = document.createElement('button');
            button.className = 'btn btn-sm btn-outline-primary m-1';
            button.textContent = domain;
            button.dataset.domain = domain;
            filterContainer.appendChild(button);
        });
        
        // Add filter events
        filterContainer.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                // Update active state
                filterContainer.querySelectorAll('button').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Filter projects
                const selectedDomain = this.dataset.domain;
                document.querySelectorAll('.project-item').forEach(item => {
                    if (selectedDomain === 'all' || item.dataset.domain === selectedDomain) {
                        item.style.display = 'block';
                        
                        // Reapply animation
                        item.style.animation = 'none';
                        item.offsetHeight; // Trigger reflow
                        item.style.animation = null;
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Insert filter before project list
        const projectList = document.querySelector('.project-selection-form');
        projectList.parentNode.insertBefore(filterContainer, projectList);
    };
    
    // Initialize domain filter
    createDomainFilter();
    
    // Enhance search with highlight functionality
    const enhanceSearch = () => {
        const searchInput = document.getElementById('searchInput');
        if (!searchInput) return;
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            document.querySelectorAll('.project-item').forEach(item => {
                const projectName = item.querySelector('.card-title').textContent.toLowerCase();
                const projectDesc = item.querySelector('.description').textContent.toLowerCase();
                const facultyName = item.querySelector('.faculty-name').textContent.toLowerCase();
                const projectDomain = item.dataset.domain.toLowerCase();
                
                const isMatch = projectName.includes(searchTerm) || 
                               projectDesc.includes(searchTerm) || 
                               facultyName.includes(searchTerm) ||
                               projectDomain.includes(searchTerm);
                
                if (isMatch) {
                    item.style.display = 'block';
                    
                    // Highlight matching text
                    if (searchTerm) {
                        highlightText(item.querySelector('.card-title'), searchTerm);
                        highlightText(item.querySelector('.description'), searchTerm);
                        highlightText(item.querySelector('.faculty-name'), searchTerm);
                    } else {
                        // Remove highlighting
                        removeHighlighting(item);
                    }
                } else {
                    item.style.display = 'none';
                }
            });
        });
    };
    
    // Helper function to highlight text
    function highlightText(element, term) {
        const originalContent = element.innerHTML;
        const caseSensitiveTerm = new RegExp(term, 'gi');
        
        // Skip if element contains HTML (to avoid breaking existing HTML)
        if (/<[a-z][\s\S]*>/i.test(originalContent)) return;
        
        // Apply highlighting
        const newContent = originalContent.replace(
            caseSensitiveTerm, 
            match => `<span class="search-highlight">${match}</span>`
        );
        
        element.innerHTML = newContent;
    }
    
    // Helper function to remove highlighting
    function removeHighlighting(container) {
        container.querySelectorAll('.card-title, .description, .faculty-name').forEach(element => {
            element.innerHTML = element.innerHTML.replace(/<span class="search-highlight">(.*?)<\/span>/g, '$1');
        });
    }
    
    // Initialize enhanced search
    enhanceSearch();
});
</script>



<script>
    // Load projects on scroll
document.addEventListener('DOMContentLoaded', function() {
    // Get necessary elements
    const projectsContainer = document.querySelector('.row.g-4');
    const searchInput = document.getElementById('searchInput');
    
    // Initialize variables
    let allProjects = [];
    let displayedProjects = 0;
    const projectsPerLoad = 6; // Number of projects to load each time
    let isLoading = false;
    let hasMoreProjects = true;
    
    // Function to fetch projects (simulating AJAX call)
    function fetchProjects(start, count, searchTerm = '') {
        // Show loading indicator
        showLoading(true);
        
        // Simulate AJAX request with setTimeout
        setTimeout(() => {
            // In a real implementation, this would be an AJAX call to your backend
            // For example: return fetch(`/api/projects?start=${start}&count=${count}&search=${searchTerm}`)
            
            // For demo purposes, we're working with existing projects in the DOM
            const existingProjects = document.querySelectorAll('.project-item');
            
            if (existingProjects.length === 0) {
                hasMoreProjects = false;
                showLoading(false);
                return;
            }
            
            // If this is the first load, save all projects
            if (allProjects.length === 0) {
                allProjects = Array.from(existingProjects);
                // Hide all projects initially
                allProjects.forEach(project => {
                    project.style.display = 'none';
                });
            }
            
            // Filter projects if search term provided
            let filteredProjects = allProjects;
            if (searchTerm) {
                filteredProjects = allProjects.filter(project => {
                    const projectName = project.querySelector('.card-title').textContent.toLowerCase();
                    const projectDesc = project.querySelector('.card-text.description').textContent.toLowerCase();
                    const facultyName = project.querySelector('.faculty-name').textContent.toLowerCase();
                    const projectDomain = project.dataset.domain.toLowerCase();
                    
                    return projectName.includes(searchTerm.toLowerCase()) || 
                           projectDesc.includes(searchTerm.toLowerCase()) ||
                           facultyName.includes(searchTerm.toLowerCase()) ||
                           projectDomain.includes(searchTerm.toLowerCase());
                });
            }
            
            // Calculate end index for this batch
            const endIndex = Math.min(start + count, filteredProjects.length);
            
            // Display projects for this batch
            for (let i = start; i < endIndex; i++) {
                filteredProjects[i].style.display = 'block';
                displayedProjects++;
            }
            
            // Check if we've reached the end
            if (displayedProjects >= filteredProjects.length) {
                hasMoreProjects = false;
            }
            
            // Hide loading indicator
            showLoading(false);
            isLoading = false;
            
        }, 500); // Simulate network delay
    }
    
    // Function to show/hide loading indicator
    function showLoading(show) {
        let loadingIndicator = document.getElementById('loading-indicator');
        
        if (!loadingIndicator && show) {
            loadingIndicator = document.createElement('div');
            loadingIndicator.id = 'loading-indicator';
            loadingIndicator.className = 'text-center my-4';
            loadingIndicator.innerHTML = `
                <div class="spinner-border text-warning" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading more projects...</p>
            `;
            projectsContainer.parentNode.appendChild(loadingIndicator);
        } else if (loadingIndicator && !show) {
            loadingIndicator.remove();
        }
    }
    
    // Initial load of projects
    fetchProjects(0, projectsPerLoad);
    
    // Scroll event listener
    window.addEventListener('scroll', function() {
        if (isLoading || !hasMoreProjects) return;
        
        // Check if we've scrolled to the bottom
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
            isLoading = true;
            fetchProjects(displayedProjects, projectsPerLoad, searchInput.value);
        }
    });
    
    // Search functionality
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            // Reset counters
            displayedProjects = 0;
            hasMoreProjects = true;
            
            // Hide all projects
            allProjects.forEach(project => {
                project.style.display = 'none';
            });
            
            // Fetch projects with search term
            fetchProjects(0, projectsPerLoad, this.value);
        }, 300);
    });
    
    // Function to handle "Read more" links
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('read-more')) {
            e.preventDefault();
            const descElement = e.target.closest('.description');
            const truncatedText = descElement.querySelector('.description-truncated');
            const fullText = descElement.querySelector('.description-full');
            
            truncatedText.classList.toggle('d-none');
            fullText.classList.toggle('d-none');
            
            if (e.target.textContent === 'Read more') {
                e.target.textContent = 'Read less';
            } else {
                e.target.textContent = 'Read more';
            }
        }
    });
});
</script>
<?php

include('../student/studentfooter.php');

?>
