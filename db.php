<?php
$conn = new mysqli('localhost','root','root','onlinebookstore');
if (mysqli_connect_error()) {
 die("Database connection failed: " . mysqli_connect_error());
}
?>
