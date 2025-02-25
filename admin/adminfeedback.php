<?php
include('../admin/adminsidebar.php');


?>

<div class="main_content">
    <div class="d-flex justify-content-between align-items-center m-5">
        <h3 style="font-weight:bold">Feedback Management</h3> 
        <button class="btn" id="btnorange" style="min-width:150px" data-bs-toggle="modal" data-bs-target="#feedbackModal">
            Create Feedback
        </button>
    </div>

    <!-- Alert Messages -->
    <div id="alertMessages">
        <?php
        if ($successMessage) echo "<div class='alert alert-success'>$successMessage</div>";
        if ($errorMessage) echo "<div class='alert alert-danger'>$errorMessage</div>";
        if ($warningMessage) echo "<div class='alert alert-warning'>$warningMessage</div>";
        ?>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Feedback Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="feedbackForm" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control" name="aname" required 
                                   value="<?php echo htmlspecialchars($aname ?? ''); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="aemail" required 
                                   value="<?php echo htmlspecialchars($aemail ?? ''); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Your Feedback:</label>
                            <textarea name="message" class="form-control" required 
                                      placeholder="Please share your thoughts with us..."></textarea>
                        </div>
                    </div>
              
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn" id="btnorange" name="feedback">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Feedback Table -->
    <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$semester = $_SESSION['semester'] ?? null;

// Display Feedback History card only if semester is "All"
if ($semester === "all") :
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Feedback History</h4>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete ALL feedback?');">
            <button type="submit" name="delete_all_feedback" id="btnred" class="btn btn-danger">Delete All Feedback</button>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM feedback ORDER BY id DESC";
                    $result = $con->query($query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ticket_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['submitted_at']) . "</td>";

                        // Status with update button
                        $status = $row['status'] ?? 'Pending';
                        $statusClass = $status === 'Solved' ? 'bg-success' : 'bg-warning text-dark';
                        echo "<td>";
                        if ($status !== 'Solved') {
                            echo "<form method='POST' style='display: inline;'>
                                    <input type='hidden' name='ticket_id' value='" . htmlspecialchars($row['ticket_id']) . "'>
                                    <button type='submit' name='update_status' id='btnorange' style='min-width:190px' class='btn btn-sm'>
                                        Mark as Solved
                                    </button>
                                  </form>";
                        } else {
                            echo "<span class='badge $statusClass'>$status</span>";
                        }
                        echo "</td>";

                        // Actions
                        echo "<td>
                                <form method='POST' style='display: inline;' onsubmit='return confirm(\"Are you sure you want to delete this feedback?\");'>
                                    <input type='hidden' name='ticket_id' value='" . htmlspecialchars($row['ticket_id']) . "'>
                                    <button type='submit' name='delete_feedback' id='btnred' class='btn btn-sm btn-danger'>
                                        Delete
                                    </button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }

                    if ($result->num_rows == 0) {
                        echo "<tr><td colspan='6' class='text-center'>No feedback submissions found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; // End of conditional check ?>
                </div>
                    </div>
                    </div>
                    </div>

<script>
// Show feedback modal if there was a submission error
<?php if ($errorMessage || $warningMessage): ?>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('feedbackModal')).show();
    });
<?php endif; ?>

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000);
});
</script>

<?php include('../admin/adminfooter.php'); ?>