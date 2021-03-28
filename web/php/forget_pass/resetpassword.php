<?php
    session_start();
    if(isset($_SESSION['login'])){
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../../styles/forget_mail_style.css">
    <script>
        passw=false;
        con_pass=false;

        function email_id(id){
            elem=document.getElementById(id);
            patt=/^(?=.*[!@#$%^&*(),.?":{}|<>\ ])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if(elem.value.trim()=="" || !elem.value.match(patt))
            {   
                passw=false;
                elem.value="";
                elem.placeholder="Invalid password";
                elem.style.cssText="border: 1px solid red";
            }
            else{
                passw=true;
                elem.style.cssText="border:none";
            }
        }
        function pass_id(id){
            elem1=document.getElementById(id);
            elem2=document.getElementById("pass");
            if(elem.value.trim()=="" || elem1.value!=elem2.value)
            {   
                con_pass=false;
                elem1.value="";
                elem1.placeholder="Password dosnt match";
                elem1.style.cssText="border: 1px solid red";
            }
            else{
                con_pass=true;
                elem1.style.cssText="border:none";
            }
        }
        function submmmit(){
            if(passw ==true && con_pass==true){
                document.getElementById('frm').submit();
            }
            else{
                elem=document.getElementById('pass');
                elem2=document.getElementById('con_pass');
                elem.placeholder="invalid email";
                elem.style.cssText="border: 1px solid red";
                elem2.value="";
            }
        }

    </script>
</head>
<body>
    <center><img src="../../images/find_logo.png" alt=""></center>
    <div class="container">
        <h1>Reset Password</h1>
        <p>Enter a new password including uppercase, lowercase,numbers and special charecters with minimum of 8 length</p>
        <form action="pass_reset.php" method="POST" id="frm">
            <input type="password" id="pass" class="inputs" name="password" placeholder="New password" onblur="email_id(this.id)"/>
            <input type="password" id="con_pass" class="inputs" name="email" placeholder="Confirm password " onblur="pass_id(this.id)"/>
        </form>
        <button class="click_button" onclick="submmmit()"> Continue </button>
    </div> 
    
</body>
</html>
<?php
    }
    else{
        header("location:../forget_pass.php");
    }

?>
