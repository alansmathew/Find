<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Assistance</title>
    <link rel="stylesheet" href="../styles/forget_mail_style.css">
    <script>
        email=false;

        function email_id(id){
            elem=document.getElementById(id);
            patt=/^([A-Za-z0-9\.]{4,30})+@([a-z]{3,})+\.+([a-z\.])+$/;
            // patt=/^([A-Za-z0-9\.]{4,30})+@[a-z.]+\.+[a-z]+$/;
            if(elem.value.trim()=="" || !elem.value.match(patt))
            {   
                email=false;
                elem.value="";
                elem.placeholder="invalid email";
                elem.style.cssText="border: 1px solid red";
            }
            else{
                email=true;
                elem.style.cssText="border:none";
            }
        }
        function sub(){
            
            if(email==true){
                document.getElementById("senting").style.display="block";
                document.getElementById('frm').submit();
            }
            else{
                elem=document.getElementById('email');
                elem.placeholder="invalid email";
                elem.style.cssText="border: 1px solid red";
            }
        }

    </script>
    <style>
        .sentingani{
            background-color:rgb(248,248,248);
            width:100vw;
            height:100vh;
            z-index:2;
            position: absolute;
            opacity:.86;
            transition: 0.6s ease-in;
        }
        .sentingani img{
            position:relative;
            top:50%;
            left:50%;
            transform: translate(-50%,-80%);
            width:450px;
            height:300px;
        }
    </style>
</head>
<body>
    <div class="sentingani" id="senting" style="display:none">
        <img src="../images/mail.gif" alt="senting_mail...">
    </div>
    <center><img src="../images/find_logo.png" alt=""></center>
    <div class="container">
        <h1>Password assistance</h1>
        <p>Enter the email address that you used to login to your Find account.</p>
        <form action="forget_pass/otp_conf.php" method="POST" id="frm">
            <?php
            if(isset($_GET['err'])){
                echo '<input type="text" id="email" class="inputs" name="email" placeholder="Invalid email" onblur="email_id(this.id)"/>';
            }
            else{
                echo'<input type="text" id="email" class="inputs" name="email" placeholder="E-Mail" onblur="email_id(this.id)"/>';
            }
            ?>
        </form>
        <button class="click_button" onclick="sub()"> Continue </button>
    </div> 
    
</body>
</html>