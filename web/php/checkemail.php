<?php
include("connection.php");
$email=$_GET['email'];
$sql="select * from tbl_login where email='$email'";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)==0){
    echo "true";
}
else{
    echo "false";
}
?>