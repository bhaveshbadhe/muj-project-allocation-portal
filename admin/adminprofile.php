<?php
// Include admin authentication check (ensure this does not close the connection)
include('../admin/adminsidebar.php');

?>
 
<!-- HTML Form Section -->
<div class="main_content">
    <div class="container mt-5">
        <h3 class="text-center m-5" style="font-weight:bold">Admin Profile</h3>
        <div class="card">
            <form class="row g-3 m-3" method="POST">
                <!-- Existing fields -->
                <div class="col-md-6">
                    <label for="validationDefault01" class="form-label">Admin ID</label>
                    <input type="text" class="form-control" id="validationDefault01" name="id" value="<?php echo htmlspecialchars($admin['id']); ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Admin Name</label>
                    <input type="text" class="form-control" id="validationDefault02" name="aname" value="<?php echo htmlspecialchars($admin['aname']); ?>" pattern="[A-Za-z ]+" title="Admin name must contain only letters." required>
                </div>

                <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Admin Outlook</label>
                    <input type="text" class="form-control" id="validationDefault02" name="aemail" value="<?php echo htmlspecialchars($admin['aemail']); ?>" pattern="^[A-Za-z]+\.[A-Za-z0-9]+@muj\.manipal\.edu$" title="Outlook must follow the pattern: name.fid@muj.manipal.edu" required>
                </div>

                <div class="col-md-6">
                    <label for="validationDefault02" class="form-label">Admin Mobile Number</label>
                    <input type="text" class="form-control" id="validationDefault02" name="amnumber" value="<?php echo htmlspecialchars($admin['amobile']); ?>" pattern="\d{10}" title="Mobile number must be 10 digits." required>
                </div>

             <!-- Work Year Selection -->
<div class="col-md-6">
    <label for="workYear" class="form-label">Work Year</label>
    <select class="form-control" id="workYear" name="work_year" required>
        <option value="ALL">All</option>
        <?php
        $current_year = date("Y"); // Get the current year
        $selected_year = isset($_SESSION['work_year']) ? $_SESSION['work_year'] : $current_year;

        for ($year = $current_year; $year >= $current_year - 10; $year--) {
            echo "<option value='$year' " . ($selected_year == $year ? "selected" : "") . ">$year</option>";
        }
        ?>
    </select>
</div>


                <div class="col-md-6">
                    <label for="validationDefault01" class="form-label">Semester</label>
                    <input type="text" class="form-control" id="workSem" name="work_sem" value="<?php echo htmlspecialchars($semester); ?>" readonly>
                </div>

                <div class="col-12 mt-5">
                    <button class="btn" name="admin_profile_update" id="btnorange" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
                    </div>
                    </div>
                    </div>
<?php
// table link 
include('../admin/adminfooter.php');
?>
