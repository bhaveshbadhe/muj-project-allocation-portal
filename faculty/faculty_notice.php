<?php
include('../faculty/facultysidebar.php');

// Fetch Notices Based on Filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

switch ($filter) {
    case 'my':
        $sql_fetch = "SELECT * FROM circular_notices WHERE fid = '$fid' ORDER BY notice_date DESC";
        break;
    case 'admin':
        $sql_fetch = "SELECT * FROM circular_notices WHERE type = 'faculty' ORDER BY notice_date DESC";
        break;
    default:
        $sql_fetch = "SELECT * FROM circular_notices WHERE type = 'faculty' OR fid = '$fid' ORDER BY notice_date DESC";
        break;
}

// Execute Query
$result = $con->query($sql_fetch);
?>


</head>
<body class="bg-light">
    <div class=" py-4">
        <div class="row">
            <!-- Left Column - Create Notice -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                    <h5 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Create Notice
                        </h5>
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Select Semester</label>
                                <select class="form-select" name="semester">
                                    <option value="All Semesters">All Semesters</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                    <option value="7">Semester 7</option>
                                    <option value="8">Semester 8</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notice Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notice Content</label>
                                <textarea class="form-control" rows="4" name="description" required></textarea>
                            </div>
                            <button type="submit" name="submit_notice" id="btnorange" class="btn w-100">  <i class="fas fa-paper-plane me-2"></i>Post Notice</button>
                        </form>
                    </div>
                </div>
            </div>

       
            <div class="col-lg-8">
    <div class="card shadow-sm" style="font-size: 1.0rem;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="card-custom-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                    <i class="fas fa-clipboard-list  me-2"></i>Notice Board
                    </h5>
                </div>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete ALL your notices? This cannot be undone.');">
                    <button type="submit" name="delete_all_notices" class='btn' id="btnred">
                        <i class="fas fa-trash-alt me-2"></i>Delete All Notices
                    </button>
                </form>
            </div>
            
      
            <div class="row align-items-center mb-4">
    <!-- Filter Navigation -->
    <div class="col-lg-8 col-md-8">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link <?= $filter === 'all' ? 'active' : '' ?>" href="?filter=all">
                    <i class="fas fa-globe me-2"></i>All Notices
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $filter === 'my' ? 'active' : '' ?>" href="?filter=my">
                    <i class="fas fa-user-tie me-2"></i>My Notices
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $filter === 'admin' ? 'active' : '' ?>" href="?filter=admin">
                    <i class="fas fa-crown me-2"></i>Admin Notices
                </a>
            </li>
        </ul>
    </div>

    <!-- Search Input -->
    <div class="col-lg-4 col-md-4">
        <div class="search-wrapper" style="position: relative; display: inline-block; width: 100%;">
            <input 
                type="text" 
                id="searchInput" 
                class="search-input form-control" 
                placeholder="Search in all columns..." 
                style="padding-left: 35px; font-size: 0.9rem; height: 40px;"
            >
            <i 
                class="fas fa-search search-icon" 
                style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray; font-size: 1rem;"
            ></i>
        </div>
    </div>
</div>


            <div class="notice-list" id="noticeList">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="notice-card card <?= $row['type'] == 'faculty' ? 'admin-notice' : '' ?>" data-keywords="<?= htmlspecialchars(strtolower($row['title'] . ' ' . $row['description'])) ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="card-title mb-0" style="font-size: 0.9rem;">
                                        <?= htmlspecialchars($row['title']) ?>
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge <?= $row['type'] == 'faculty' ? 'bg-primary' : 'bg-warning' ?> me-2" style="font-size: 0.8rem;">
                                            <?= htmlspecialchars($row['type']) ?> Notice
                                        </span>
                                        <?php if ($row['fid'] == $fid): ?>
                                            <form method="POST" class="ms-2" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                                <input type="hidden" name="notice_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="delete_notice" class='btn' id="btnred" style="font-size: 0.8rem;">
                                                    <i class="fas fa-trash-alt"></i> Delete Notice
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <p class="card-text text-muted small mb-2" style="font-size: 0.8rem;">
                                    Posted on: <?= $row['notice_date'] ?> | 
                                    Semester: <?= htmlspecialchars($row['semester']) ?>
                                </p>
                                <p class="card-text" style="font-size: 0.9rem;">
                                    <?= htmlspecialchars($row['description']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted">No notices found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
                </div>
                </div>
                </div>
                </div>
                </div>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const notices = document.querySelectorAll('.notice-card');

        notices.forEach(function (notice) {
            const keywords = notice.getAttribute('data-keywords');
            if (keywords.includes(searchTerm)) {
                notice.style.display = 'block';
            } else {
                notice.style.display = 'none';
            }
        });
    });
</script>

    <?php
include('../faculty/facultyfooter.php');
?>
