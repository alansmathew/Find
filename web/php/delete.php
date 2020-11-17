<?php
include("connection.php");
session_start();
$login_id=$_SESSION['id'];
$dev_id=$_GET['id'];
$sql="DELETE FROM tbl_device WHERE login_id=$login_id and device_id=$dev_id";
mysqli_query($con,$sql);
header("Location:mapview.php");
?>