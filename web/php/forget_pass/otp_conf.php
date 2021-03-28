<?php
session_start();

$con=mysqli_connect("localhost","root","","find")or die("Couldn't connect to server");

$url = "http://localhost/Find/web/php/find_api.php";
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
// echo $decode->value;

if($decode->value=="yes"){
    $sql="select login_id from tbl_login where email='$email'";
    $result= mysqli_query($con,$sql);
    $row=mysqli_fetch_array($result);
    $login_id=$row['login_id'];
    $sql="select * from tbl_otp where login_id=$login_id";
    $result= mysqli_query($con,$sql);
    $row=mysqli_fetch_array($result);
    $_SESSION['rand']=$row['otp_random'];
    $_SESSION['otp_data']=$row['otp_data'];
    $_SESSION['email']=$email;
    header("location:sentmail.php");

}
else{
    header("location:../forget_pass.php?err='wrong'");
}

// $start_date = new DateTime(date('y-m-d h:i:s'));
// $since_start = $start_date->diff(new DateTime(date('y-m-d h:i:s')));
// echo $since_start->days.' days total<br>';
// echo $since_start->y.' years<br>';
// echo $since_start->m.' months<br>';
// echo $since_start->d.' days<br>';
// echo $since_start->h.' hours<br>';
// echo $since_start->i.' minutes<br>';
// echo $since_start->s.' seconds<br>';


// $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
// shuffle($seed);
// $rand = '';
// foreach (array_rand($seed, 60) as $k) $rand .= $seed[$k];
// echo $rand;

curl_close($ch);

?>
