
<?php
session_start();
include('../connection/connection.php');
;
unset ($_SESSION['admin_data']);
unset($_SESSION['semester']);

echo "<script>location.href='adminlogin.php';</script>";
exit;
?>
