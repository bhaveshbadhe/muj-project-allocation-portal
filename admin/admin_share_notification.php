<?php 

include('../admin/adminsidebar.php');

?>

<script>
    // Function to show a JavaScript alert based on the PHP message
    function showAlert(message) {
        if (message) {
            alert(message);
        }
    }
</script>

<body onload="showAlert('<?php echo $message; ?>');">
<div class="main_content">
<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="color:#e45f06">
            <h2 style="font-weight:bold">Submit Circular Notice</h2>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Notice Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Notice Title" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Notice Share To</label>
                    <select class="form-select" id="type" name="type" required>
                        <option selected disabled>Share to</option>
                        <option value="student">Student</option>
                        <option value="faculty">Faculty</option>
                        <option value="all">All</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Notice Description" required></textarea>
                </div>
                <button type="submit" name="submit" class="btn" id="btnorange">Share Notice</button>
            </form>
        </div>
    </div>
</div>

<?php
// Fetch circular notices from the database filtered by type
$sql = "SELECT * FROM circular_notices WHERE type IN ('student', 'faculty', 'all')";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $message = "No notices found.";
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="color:#e45f06">
            <h2 style="font-weight:bold">View Circular Notices</h2>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
               

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;" class="flex-column flex-sm-row">
    <div style="display: flex; gap: 10px;" class="flex-md-row">
        <button onclick="exportExcelWithoutLastColumn('notice')" class="btn"><i class="fa-solid fa-file-excel"></i>
        Export Excel</button>
        <button onclick="printTableWithoutLastColumn('notice')" class="btn"><i class="fa-solid fa-print"></i>
        Print</button>
    </div>
    <div class="search-wrapper" style="position: relative; display: inline-block;">
        <input type="text" id="searchInput" class="search-input" placeholder="Search in all columns..." style="padding-left: 30px;">
        <i  class="fas fa-search search-icon"  style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: gray;"
        ></i>
    </div>

</div>

<div style="overflow-x: auto; width:100%;">
<table  id="notice"  class="searchtable"  class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Notice Date</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sr_no = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $sr_no++; ?></td> 
                                <td><?php echo htmlspecialchars($row['notice_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td>
                                    <div style="max-height:150px; overflow-y:auto; padding:2px font-size:16px; border-bottom:1px solid black">
                                    <?php echo htmlspecialchars($row['description']); ?>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td>
                                    <!-- Delete button for each notice -->
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                        <input type="hidden" name="delete_notice_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                        </div>
            <?php else: ?>
                <p class="text-danger">No circular notices found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Button to delete all notices by type -->
    <div class="card mt-3">
        <div class="card-body">
            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete all notices for the selected type?');">
                <label for="delete_type" class="form-label">Delete All Notices of Type</label>
                <select class="form-select" id="delete_type" name="delete_type" required>
                    <option selected disabled>Choose Type</option>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                    <option value="all">All</option>
                </select>
                <button type="submit" name="delete_all_by_type"id="btnred" class="btn mt-3"> <i class="fa-solid fa-trash-can"></i> Delete All</button>
            </form>
        </div>
    </div>
</div>
            </div>
            </div>
            </div>
            </div>

<?php

$con->close();
?>
<?php
// table link 
include('../admin/adminfooter.php');
?>

