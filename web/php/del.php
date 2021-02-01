<?php
include("connection.php");
session_start();
$login_id=$_SESSION['id'];
$dev_id=$_GET['id'];
$sql="select state from tbl_device WHERE login_id=$login_id and device_id=$dev_id";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
if($row['state']=='active'){
    $state="lost";
}
else{
    $state="active";
}
$sql="update tbl_device set state='$state' WHERE login_id=$login_id and device_id=$dev_id";
mysqli_query($con,$sql);
echo $state;

?>