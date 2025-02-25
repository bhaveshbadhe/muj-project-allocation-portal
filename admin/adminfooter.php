<!-- Footer -->

<?php
// table link 
include('../table_print/printjs.php');
?>


<footer class="custom-footer text-center py-4">
    <div class="container">
    <span>&copy; 2025 <a style="text-decoration:none; color:black" href="../socialmedia-handel.php">RBV</a> . All Rights Reserved.</span>
    </div>
</footer>


<!-------------------------------------------------filter by section ---------------------------------------->
<script>
document.addEventListener("DOMContentLoaded", function () {
    let sectionFilter = document.getElementById("sectionFilter");
    let tableRows = document.querySelectorAll(".searchtable tbody tr");
    let uniqueSections = new Set();

    // Collect unique sections dynamically from table rows
    tableRows.forEach(row => {
        let section = row.getAttribute("data-section");
        if (section) {
            uniqueSections.add(section.trim());
        }
    });

    // Populate section dropdown
    uniqueSections.forEach(section => {
        let option = document.createElement("option");
        option.value = section;
        option.textContent = section;
        sectionFilter.appendChild(option);
    });

    // Filter functionality
    sectionFilter.addEventListener("change", function () {
        let selectedSection = this.value.trim().toLowerCase();

        tableRows.forEach(row => {
            let rowSection = row.getAttribute("data-section") ? row.getAttribute("data-section").trim().toLowerCase() : "";
            row.style.display = selectedSection === "" || rowSection === selectedSection ? "" : "none";
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
</html>