<?php
include("connection.php");
include("log/log.php");

$email = $_POST['email'];
$password= $_POST['password'];

$sql="select * from tbl_login where email='$email' and status=1";
if($result=mysqli_query($con,$sql)){
    $row=mysqli_fetch_array($result);
    if(mysqli_num_rows($result)==1 && password_verify($password,$row['password'])){

        $login_id=$row['login_id'];
        log_activity($con,$login_id,'profile','Login Activity');

        session_start();
        $_SESSION['id']=$row['login_id'];
        header("location:mapview.php");
    }
    else{
        header("location:../index.php?err=wrong");
    }
}
else{
    echo "something went wrong";
}

?>