<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "project_management_website";

$con = mysqli_connect($server, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>
