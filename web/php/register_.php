<?php
include("connection.php");
include("log/log.php");
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']))
{
    $name= $_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password = password_hash($password,PASSWORD_DEFAULT); 

    $sql="insert into tbl_login (email,password) values ('$email','$password')";
    mysqli_query($con,$sql);
    $login_id=mysqli_insert_id($con);
    $sql="insert into tbl_reg (login_id,name) values($login_id,'$name')";
    if(mysqli_query($con,$sql)){
        session_start();
        $_SESSION['id']=$login_id;

        log_activity($con,$login_id,'profile','New Account Creation');

        header("Location:mapview.php");
    }else{
        echo "something went wrong";
    }
}
else{
    header("Location:../index.php");
}
?>