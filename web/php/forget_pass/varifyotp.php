<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varify OTP</title>
    <link rel="stylesheet" href="../../styles/forget_mail_style.css">
    <script>
        function sub(){
            if(document.getElementById('email').value.length >0) {
                document.getElementById('frm').submit();
            }
            else{
                elem=document.getElementById('email');
                elem.placeholder="Invalid OTP";
                elem.style.cssText="border: 1px solid red";
            }
        }
    </script>
</head>
<body>
    <center><img src="../../images/find_logo.png" alt=""></center>
    <div class="container">
        <h1>Varify OTP</h1>
        <p>Enter the OTP sent to your registered email address with your Find account.</p>
        <form action="verifyotprequest.php" method="POST" id="frm">
            <?php
            if(isset($_GET['err'])){
                echo '<input type="text" id="email" class="inputs" name="otp" placeholder="Invalid OTP" />';
            }
            else{
                echo'<input type="text" id="email" class="inputs" name="otp" placeholder="OTP" />';
            }
            ?>
        </form>
        <button class="click_button" onclick="sub()"> Continue </button>
    </div> 
    
</body>
</html>