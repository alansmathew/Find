<?php
include("../connection.php");
session_start();
if( isset($_SESSION['login']) && isset($_POST['password'])){
    $login=$_SESSION['login'];
    $password=$_POST['password'];
    $password = password_hash($password,PASSWORD_DEFAULT); 
    $sql="UPDATE tbl_login SET password='$password' where login_id=$login";
    mysqli_query($con,$sql);
    session_unset();
    if(session_destroy()){header("location:../../index.php");}
}
else{
    header("location:../forget_pass.php");
}
?>