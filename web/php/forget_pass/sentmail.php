<?php
session_start();
require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");
require("../../../../confidential.php");

// function sentmail($otp_data,$rand,$email){
if(isset($_SESSION['email']) && isset($_SESSION['rand']) && isset($_SESSION['otp_data'])){
    $email=$_SESSION['email'];
    $otp_data=$_SESSION['otp_data'];
    $rand=$_SESSION['rand'];
        
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->isSMTP();                                    
        $mail->Host       = 'smtp.gmail.com';                 
        $mail->SMTPAuth   = true;                   
        $mail->Username   = 'alansmathew008@gmail.com';       
        $mail->Password   = $password;                               
        $mail->Port       = 587;                                   

        //Recipients
        $mail->setFrom('alansmathew008@gmail.com', 'Mailer');
        $mail->addAddress($email); 

        //Content
        $mail->isHTML(true); 
        $mail->Subject = 'Reset your password for Find';
        $mail->Body    = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    body{
                        background-color: white;
                        margin: 0;
                        padding: 0;
                    }
                    .container{
                        margin-top: 20px;
                        position: relative;
                        left:50%;
                        transform: translate(-50%);
                        background-color: white;
                        width:400px;
                    }
                    .container img{
                        width:100px;
                        height:100px;
                    }
                    .container h1{
                        font-family: sans-serif;
                        font-size: 36px;
                        color:rgba(0, 0, 0, 0.835);
                    }
                    .container p{
                        font-family: sans-serif;
                        font-size: 15px;
                        color:rgba(0, 0, 0, 0.774);
                        margin:10px 20px 20px 3px;
                        line-height: 23px;
                    }
                    .container a{
                        text-decoration: none;
                        font-size: 15px;
                        color: rgba(47, 154, 241, 0.753);
                        font-family: sans-serif;
                        margin-bottom: 10px;
                        margin:3px 20px 10px 3px;
                    }

                </style>
            </head>
            <body>
                <div class="container">
                    <img src="../../images/find_logo.png" alt=""/>
                    <center><h1>Hello.</h1></center>
                    <p>No need to worry, you can reset your Find password by clicking the link below or entering the OTP:</p>
                    <a href="">Reset Password</a>
                    <p>OTP : <b>'.$otp_data.'</b> </p>
                    <p>For security reasons this link and OTP will only be active for 3 minuties. If you didnt request a password reset, feel free to delete this email and carry on enjoying !</p>
                    <p style="margin:0;">All the best</p>
                    <p style="margin:0;">The Find Team</p>
                </div>
            </body>
            </html>
        ';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo 'Message has been sent';
        session_unset();
        if(session_destroy()){header("location:varifyotp.php");}
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
else{
    // header("location:../forget_pass.php?err='wrong'");
}
?>