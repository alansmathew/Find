<?php
include("connection.php");

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
    header("Location:..\mapview.html");
}else{
    echo "something went wrong";
}
?>