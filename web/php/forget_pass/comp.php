<?php
include("../dbconnection.php");

if (isset($_GET['varify'])) {
    $rand = $_GET['varify'];
    $sql = "select * from tbl_otp where otp_random='$rand'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $linktime = new DateTime(date($row['otp_time']));
        $since_start = $linktime->diff(new DateTime(date('y-m-d h:i:s')));
        if ($since_start->days == 0 && $since_start->h == 0 && $since_start->i < 3) {
            $sql = "delete from tbl_otp where otp_random='$rand'";
            mysqli_query($con, $sql);
            session_start();
            $_SESSION['login'] = $row['login_id'];
            header('Location:resetpassword.php');
        } 
        else {
            echo "link expaired !";
            $sql = "delete from tbl_otp where otp_random='$rand'";
            mysqli_query($con, $sql);
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Reset Password</title>
                <link rel="stylesheet" href="../../styles/forget_mail_style.css">
            </head>
            <body>
                <center><img src="../../images/logo.png" alt=""></center>
                    <div class="container">
                        <h1>Link invalid !</h1>
                        <p>The link you recived is either invalid for this purpose or got expaired. Please try within 3 minutes after requesting for reset password.
                            If this problem pursues, contact customer care for further clarification...
                        </p>
                        <a href="../../index.php"><button class="click_button" onclick="submmmit()"> Continue to home page </button></a>
                    </div>
                </body>
            </html>
            <?php
        }
    } 
    else {
        // echo "link invalid !";
            ?>
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Reset Password</title>
                    <link rel="stylesheet" href="../../styles/forget_mail_style.css">
                </head>
                <body>
                <center><img src="../../images/logo.png" alt=""></center>
                    <div class="container">
                        <h1>Link invalid !</h1>
                        <p>The link you received is either invalid for this purpose or got expaired. Please try within 3 minutes after requesting for reset password.
                            If this problem pursues, contact customer care for further clarification...
                        </p>
                        <a href="../../index.php"><button class="click_button" onclick="submmmit()"> Continue to home page </button></a>
                    </div>
                </body>
            </html>
        <?php
    }
} 
elseif (isset($_POST['otp'])) {
    $otp = $_POST['otp'];
    $sql = "select * from tbl_otp where otp_data='$otp'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $linktime = new DateTime(date($row['otp_time']));
        $since_start = $linktime->diff(new DateTime(date('y-m-d h:i:s')));
        if ($since_start->days == 0 && $since_start->h == 0 && $since_start->i < 3) {
            $sql = "delete from tbl_otp where otp_data='$otp'";
            mysqli_query($con, $sql);
            session_start();
            $_SESSION['login'] = $row['login_id'];
            header('Location:resetpassword.php');
        } 
        else {
            $sql = "delete from tbl_otp where otp_data='$otp'";
            mysqli_query($con, $sql);
            header('Location:varifyotp.php?err=wrong');
        }
    } 
    else {
        header('Location:varifyotp.php?err=wrong');
    }
} 
else {
    // echo "unAuthorized Access";
        ?>
         <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Reset Password</title>
                    <link rel="stylesheet" href="../../styles/forget_mail_style.css">
                </head>
                <body>

                <center><img src="../../images/logo.png" alt=""></center>
                    <div class="container">
                        <h1>Link invalid !</h1>
                        <p>The link you received is either invalid for this purpose or got expaired. Please try within 3 minutes after requesting for reset password.
                            If this problem pursues, contact customer care for further clarification...
                        </p>
                        <a href="../../index.php"><button class="click_button" onclick="submmmit()"> Continue to home page </button></a>
                    </div>
            </body>
        </html>
    <?php
}

    ?>
    <!-- web/php/forget_pass/verifyotprequest.php?varify=xUrW3nK0ZszDumkd9IMcGTj4ybtpVX52SwO8EAhgqPlYFRv71NifBeQHLo6a -->

            </body>

            </html>