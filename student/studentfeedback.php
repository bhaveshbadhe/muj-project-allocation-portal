<?php 
include('../student/studentsidebar.php');


?>

<div class="main_content">
    <h3 class="text-center m-5" style="font-weight:bold">Submit Your Feedback</h3>
    
    <!-- Feedback Submission Form -->
    <div class="card mb-5">
        <div class="card-body">
            <?php
            if ($successMessage) echo $successMessage;
            if ($errorMessage) echo $errorMessage;
            if ($warningMessage) echo $warningMessage;
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="mb-4">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" required 
                           value="<?php echo htmlspecialchars($student['name']); ?>" readonly>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" required 
                           value="<?php echo htmlspecialchars($email); ?>" readonly>
                </div>

                <div class="mb-4">
                    <label class="form-label">Registration No:</label>
                    <input type="text" class="form-control" name="registration_no" required 
                           value="<?php echo htmlspecialchars($registration_no); ?>" readonly>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Your Feedback:</label>
                    <textarea name="message" class="form-control" required 
                              placeholder="Please share your thoughts with us..."></textarea>
                </div>
                
                <div class="text-center">
                    <button class="btn" style="width:200px" id="btnorange" 
                            name="feedback" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Feedback History Table -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="m-3">Your Feedback History</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Name</th>
                            <th>Registration No</th>
                            <th>Message</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch feedback entries for the current student using registration_no
                        $query = "SELECT * FROM feedback WHERE registration_no = ? ORDER BY id DESC";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("s", $registration_no);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ticket_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['registration_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['submitted_at']) . "</td>";
                            
                            // Show status (Default: Pending)
                            $status = !empty($row['status']) ? htmlspecialchars($row['status']) : "Pending";
                            echo "<td><span class='badge bg-warning text-dark'>" . $status . "</span></td>";

                            echo "<td>
                                    <form method='POST' style='display: inline;' 
                                          onsubmit='return confirm(\"Are you sure you want to delete this feedback?\");'>
                                        <input type='hidden' name='ticket_id' 
                                               value='" . htmlspecialchars($row['ticket_id']) . "'>
                                        <button type='submit' name='delete_feedback' 
                                                id='btnred' class='btn btn-sm'>
                                            Delete
                                        </button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        $stmt->close();

                        if ($result->num_rows == 0) {
                            echo "<tr><td colspan='7' class='text-center'>No feedback submissions found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                    </div>
                    </div>
                    </div>
<?php include('../student/studentfooter.php'); ?>