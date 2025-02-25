
<?php
session_start();
include('../connection/connection.php');

// Unset the specific session variable
unset($_SESSION['registration_no']);
// Redirect to the index page
echo "<script>location.href='../index.php';</script>";
exit;
?>
