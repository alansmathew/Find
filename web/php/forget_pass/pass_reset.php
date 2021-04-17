<?php
    include("../connection.php");
    include("../log/log.php");
    session_start();
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
    <?php
        if( isset($_SESSION['login']) && isset($_POST['password'])){
            $login=$_SESSION['login'];
            $password=$_POST['password'];
            $password = password_hash($password,PASSWORD_DEFAULT); 
            $sql="UPDATE tbl_login SET password='$password' where login_id=$login";
            mysqli_query($con,$sql);

            log_activity($con,$login,'profile','Password reseted sucessfully');
            
            session_unset();
            if(session_destroy()){
                ?>
                    <center><img src="../../images/find_logo.png" alt=""></center>
                    <div class="container">
                        <h1>Reset Sucessfull </h1>
                        <p>Your password is been sucessfully reseted. You can use your new password to login to your Find account.</p>
                        <a href="../../index.php"><button class="click_button" > Continue to home page  </button></a>
                    </div> 
                <?php
                // header("location:../../index.php");
            }
        }
        else{
            header("location:../forget_pass.php");
        }
    ?>

</body>
</html>