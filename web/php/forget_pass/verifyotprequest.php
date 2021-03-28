<?php 
// $con=mysqli_connect("localhost","root","","find")or die("Couldn't connect to server");
include("../connection.php");

if(isset($_GET['varify'])){
    $rand=$_GET['varify'];
    $sql="select * from tbl_otp where otp_random='$rand'";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_array($result);
        $linktime=new DateTime(date($row['otp_time']));
        $since_start = $linktime->diff(new DateTime(date('y-m-d h:i:s')));
        if($since_start->days ==0 && $since_start->h ==0 && $since_start->i < 3 ){
            $sql="delete from tbl_otp where otp_random='$rand'";
            mysqli_query($con,$sql);
            session_start();
            $_SESSION['login']=$row['login_id'];
            header('Location:resetpassword.php');
        }
        else{
            echo "link expaired !";
            $sql="delete from tbl_otp where otp_random='$rand'";
            mysqli_query($con,$sql);
        }
    }
    else{
        echo "link invalid !";
    }
}
elseif(isset($_POST['otp'])){
    $otp=$_POST['otp'];
    $sql="select * from tbl_otp where otp_data='$otp'";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_array($result);
        $linktime=new DateTime(date($row['otp_time']));
        $since_start = $linktime->diff(new DateTime(date('y-m-d h:i:s')));
        if($since_start->days ==0 && $since_start->h ==0 && $since_start->i < 3 ){
            $sql="delete from tbl_otp where otp_data='$otp'";
            mysqli_query($con,$sql);
            session_start();
            $_SESSION['login']=$row['login_id'];
            header('Location:resetpassword.php');
        }
        else{
            $sql="delete from tbl_otp where otp_data='$otp'";
            mysqli_query($con,$sql);
            header('Location:varifyotp.php?err=wrong');
        }
    }
    else{
        header('Location:varifyotp.php?err=wrong');
    }
}
else{
    echo "unAuthorized Access";
}

?>
<!-- web/php/forget_pass/verifyotprequest.php?varify=xUrW3nK0ZszDumkd9IMcGTj4ybtpVX52SwO8EAhgqPlYFRv71NifBeQHLo6a -->