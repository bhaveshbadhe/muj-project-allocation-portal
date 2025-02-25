<?php 

include('../faculty/facultysidebar.php');





?>


<div class="main_content">
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center w-100" style="font-weight:bold; color: #e45f06;">
                        <i class="fas fa-folder-plus"></i> Add Project
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="POST" onsubmit="return validateDescription()">
                        <div class="col-md-6">
                            <label for="validationDefault01" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="validationDefault01" name="pname" required>
                        </div>
                        <div class="col-md-6">
                            <label for="validationDefault02" class="form-label">Project Description</label>
                            <textarea class="form-control" id="validationDefault02" name="pdesc" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="validationDefault05" class="form-label">Max Number of Students</label>
                            <input type="number" class="form-control" id="validationDefault05" name="max_no_of_student" required>
                        </div>
                        <!-- <div class="col-md-6">
                            <label for="validationDefault05" class="form-label">Project Type</label>
                            <input type="text" class="form-control" id="validationDefault05" name="project_type" required>
                        </div> -->
                        <?php
                        $fetch_domains_query = "SELECT project_domain_type FROM admin_add_contain ORDER BY sr_no ASC";
                        $domains_result = mysqli_query($con, $fetch_domains_query);
                        ?>
                        <div class="col-md-6">
                            <label for="domainType" class="form-label">Select Project Domain Type</label>
                            <select name="domain_type" id="domainType" class="form-control" required>
                                <option value="" disabled selected>Select a domain</option>
                                <?php while ($row = mysqli_fetch_assoc($domains_result)): ?>
                                    <option value="<?php echo htmlspecialchars($row['project_domain_type']); ?>">
                                        <?php echo htmlspecialchars($row['project_domain_type']); ?>
                                    </option>
                                <?php endwhile; ?>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control" id="semester" name="semester" required>
                                <option value="">Select Semester</option>
                                <?php
                                $sem_labels = [
                                    3 => "PBL-1",
                                    4 => "PBL-2",
                                    5 => "PBL-3",
                                    6 => "MINOR",
                                    8 => "MAJOR-2"
                                ];
                                foreach ($sem_labels as $sem => $label) {
                                    echo "<option value='$sem'>$sem ($label)</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" id="btnorange" name="addproject" type="submit">
                                <i class="fas fa-plus-circle"></i> Add Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-5 text-center mb-3" style="font-weight:bold"><i class="fas fa-list"></i> Project Details</h3>

    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                  
                </div>
                <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                    <div class="d-flex gap-2">
                        <button onclick="exportExcelWithoutLastColumn('projectlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-file-excel"></i> Export Excel
                        </button>
                        <button onclick="printTableWithoutLastColumn('projectlist')" class="btn btn-sm btn-light">
                            <i class="fa-solid fa-print"></i> Print
                        </button>

                        <button type="button" class="btn" id="btnorange" data-bs-toggle="modal" data-bs-target="#addProjectModal">
       <i class="fa-solid fa-folder-plus"></i>  Add Project
    </button>
                    </div>
                    <div class="search-wrapper" style="position: relative; display: inline-block;">
        <input type="text" id="searchInput" class="search-input" placeholder="Search in all columns..." style="padding-left: 30px;">
        <i  class="fas fa-search search-icon"  style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray;"
        ></i>
    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="projectlist" class="searchtable table table-hover">
                        <thead  class="table-light">
                <tr>
                    <th scope="col"><i class="fas fa-hashtag"></i> Sr No.</th>
                    <th scope="col"><i class="fas fa-id-badge"></i> Project Id</th>
                    <th scope="col"><i class="fas fa-folder"></i> Name</th>
                    <th scope="col"><i class="fas fa-info-circle"></i> Description</th>
                    <!-- <th scope="col"> <i class="fas fa-cogs"></i> Type</th> -->
                    <th scope="col"><i class="fas fa-network-wired"></i> Domain</th>
                    <th scope="col"><i class="fas fa-graduation-cap"></i> Semester</th>
                    <th scope="col"><i class="fas fa-users"></i> Max Students</th>
                    <th scope="col"><i class="fas fa-user-check"></i> Allocated</th>
                    <th scope="col"><i class="fas fa-edit"></i> Action</th>
                </tr>
            </thead>
            <tbody>
<?php 
$serial_no = 1; // Initialize the serial number
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $serial_no++ . "</td>";
    echo "<td>" . htmlspecialchars($row['p_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['pname']) . "</td>";
    echo "<td>" . htmlspecialchars($row['pdesc']) . "</td>";
    // echo "<td>" . htmlspecialchars($row['project_type']) . "</td>";
    echo "<td>" . htmlspecialchars($row['project_domain_type']) . "</td>";
    echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
    echo "<td>" . htmlspecialchars($row['max_student']) . "</td>";
    echo "<td>" . htmlspecialchars($row['no_of_student_allocated']) . "</td>";
    echo "<td>
        <div style='display: flex; gap: 8px; align-items: center;'>
           <a href='#' 
               class='btn btn-warning'
               style='background-color: #ffc107; color: white;'
               onclick=\"openEditModal('" . htmlspecialchars($row['p_id']) . "', '" . htmlspecialchars($row['pname']) . "', '" . htmlspecialchars($row['pdesc']) . "', '" . htmlspecialchars($row['project_type']) . "', '" . htmlspecialchars($row['project_domain_type']) . "', '" . htmlspecialchars($row['semester']) . "', '" . htmlspecialchars($row['max_student']) . "')\">
               <i class='material-icons'>edit</i> Edit
           </a>
        </div>
    </td>";
    echo "</tr>";
}


/*  =----------------------delete button 
<form method='POST' action='faculty_addproject.php' style='margin: 0;'>
<input type='hidden' name='p_id' value='" . htmlspecialchars($row['p_id']) . "'>
<button type='submit' name='delete' class='btn btn-danger' 
        style='background-color:red; color: white;'
        onclick=\"return confirm('Are you sure you want to delete this project?');\">
    <i class='material-icons'>delete_forever</i>
</button>
</form>

*/
?>


</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
    function openEditModal(p_id, pname, pdesc, project_type, domain_type, semester, max_student) {
    // Populate the modal fields with the passed data
    document.getElementById('validationDefault01').value = pname;
    document.getElementById('validationDefault02').value = pdesc;
    // document.getElementsByName('project_type')[0].value = project_type;
    document.getElementsByName('domain_type')[0].value = domain_type;
    document.getElementById('semester').value = semester;
    document.getElementById('validationDefault05').value = max_student;

    // Add a hidden input for the project ID
    if (!document.getElementById('hiddenProjectId')) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.id = 'hiddenProjectId';
        hiddenInput.name = 'p_id';
        document.querySelector('form').appendChild(hiddenInput);
    }
    document.getElementById('hiddenProjectId').value = p_id;

    // Change the button to "Update Project"
    const submitButton = document.querySelector('#btnorange');
    submitButton.name = 'update';
    submitButton.textContent = 'Update Project';

    // Open the modal
    const modal = new bootstrap.Modal(document.getElementById('addProjectModal'));
    modal.show();
}

</script>
<script>
function validateDescription() {
    const descriptionField = document.getElementById('validationDefault02');
    const description = descriptionField.value.trim();
    const wordCount = description.split(/\s+/).length;

    if (wordCount > 150) {
        alert('Project Description exceeds 150 words. Please reduce the word count.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>


<?php
include('../faculty/facultyfooter.php');

?>
 