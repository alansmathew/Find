<?php
include("connection.php");
$email=$_GET['email'];
$login_id;
$sql="select * from tbl_login where email='$email'";
if(isset($_GET['id'])){
    $login_id=$_GET['id'];
    if($login_id!=""){
        $sql="select * from tbl_login where email='$email' and login_id !=$login_id";
    }
}
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)==0){
    echo "true";
}
else{
    echo "false";
}
?>