<?php
session_start();
include('../connection/connection.php');

// Unset the specific session variable
unset($_SESSION['fid']);

// Redirect to the faculty login page
echo "<script>location.href='faculty_login.php';</script>";
exit;
?>
