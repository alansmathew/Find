<?php
session_start();

// $con=mysqli_connect("localhost","root","","find")or die("Couldn't connect to server");
include("../connection.php");
include("../log/log.php");

// $url = "../find_api.php";
// $url = "https://alansmathew.000webhostapp.com/php/find_api.php";
$url="http://localhost/find/web/php/find_api.php";
$ch = curl_init();
$email=$_POST['email'];
$data_array = array(
    "type" => "confirm_email",
    "email" => $email
);

$data= http_build_query($data_array);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$decode = json_decode($result);
echo $decode->value;
// echo $result;

if($decode->value=="yes"){
    // echo("yeah");
    $sql="select login_id from tbl_login where email='$email'";
    $result= mysqli_query($con,$sql);
    $row=mysqli_fetch_array($result);
    $login_id=$row['login_id'];

    log_activity($con,$login_id,'profile','Password reset attempt');

    $sql="select * from tbl_otp where login_id=$login_id";
    $result= mysqli_query($con,$sql);
    $row=mysqli_fetch_array($result);
    $_SESSION['rand']=$row['otp_random'];
    $_SESSION['otp_data']=$row['otp_data'];
    $_SESSION['email']=$email;
    // header("location:sentmail.php");

// ------ delete this after testing 
    session_unset();
    if(session_destroy()){header("location:varifyotp.php");}

}
else{
    header("location:../forget_pass.php?err='wrong'");
    // echo ("wrong email");
}
curl_close($ch);

?>
