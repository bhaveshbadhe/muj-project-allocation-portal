<?php 

include('../faculty/facultysidebar.php');

?>

<div class="container">
    <h3 class="text-center m-3" style="font-weight:bold; color: rgb(236, 76, 8);">Faculty Profile</h3>
    <div class="profile-card" id="backgroundmujlogo">

<img 
  src="<?php echo htmlspecialchars(!empty($faculty['image']) ? "../uploads/{$faculty['image']}" : '../photo/user_profile.jpg'); ?>" 
  alt="Faculty Image" 
  style="margin-top:50px" 
  width="150" 
  height="150"
/>


        <form class="row g-3 m-3" method="POST" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="fid" class="form-label">Faculty Id</label>
                <input type="text" class="form-control" id="fid" name="fid" value="<?php echo htmlspecialchars($faculty['fid']); ?>" readonly>
            </div>

            <div class="col-md-6">
                <label for="fname" class="form-label">Faculty Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo htmlspecialchars($faculty['fname']); ?>" required>
            </div>

            <input type="text" class="form-control" id="email" name="email" 
       value="<?php echo htmlspecialchars($faculty['email']); ?>" 
       pattern="^[A-Za-z]+\.[A-Za-z0-9]+@jaipur\.manipal\.edu$" 
       title="Outlook must follow the pattern: name.fid@jaipur.manipal.edu" required>


<div class="col-md-6">
    <label for="mnumber" class="form-label">Faculty Mobile Number</label>
    <input  type="text" class="form-control"  id="mnumber"  name="mnumber"  value="<?php echo htmlspecialchars($faculty['mobile']); ?>"   pattern="^[0-9]{10}$" title="Mobile number must be exactly 10 digits."  required>
</div>


            <div class="col-md-6">
                <label for="specialization" class="form-label">Faculty Specialization</label>
                <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($faculty['specialization']); ?>" required>
            </div>
                           <!-- Work Year Selection -->
<div class="col-md-6">
    <label for="workYear" class="form-label">Work Year</label>
    <select class="form-control" id="workYear" name="work_year" required>
    <option value="ALL">All</option> <!-- Add the 'All' option -->
    <?php
    $current_year = date('Y'); // Get the current year dynamically
    $selected_year = isset($_SESSION['work_year']) ? $_SESSION['work_year'] : '';
    
    for ($year = $current_year; $year >= $current_year - 10; $year--) {
        echo "<option value='$year' " . ($selected_year == $year ? "selected" : "") . ">$year</option>";
    }
    ?>
</select>

</div>

<!-- Work Semester Selection -->
<div class="col-md-6">
    <label for="workSem" class="form-label">Work Semester</label>
    <select class="form-control" id="workSem" name="work_sem" required>
        <option value="ALL">All</option> <!-- Add the 'All' option -->
        <?php
        $current_sem = isset($_SESSION['work_sem']) ? $_SESSION['work_sem'] : '';
        foreach ([3, 4, 5, 6, 7, 8] as $sem) {
            echo "<option value='$sem' " . ($current_sem == $sem ? "selected" : "") . ">$sem</option>";
        }
        ?>
    </select>
</div>


            <div class="col-md-12">
                <label for="image" class="form-label">Upload Profile Image (PNG, JPG only)</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png">
            </div>

            <div class="col-12 mt-5" >
                <button class="btn" id="btnorange" name="faculty_profile_update" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
    </div>
    </div>
    </div>


<?php
include('../faculty/facultyfooter.php');
?>