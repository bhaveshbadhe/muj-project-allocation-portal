<?php 
include('../student/studentsidebar.php');

?>

<body class="bg-light">
    <div class=" py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-custom-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
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
                                                <h6 class="card-title mb-0"  style="font-weight:bold">
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
        </div>
    </div>
                            </div>
                            </div>
                            </div>


    <?php

include('../student/studentfooter.php');

?>
