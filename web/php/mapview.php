<?php
session_start();
if(isset($_SESSION['id'])){
    include("connection.php");
    $login_id=$_SESSION['id'];
    $sql_login="select * from tbl_login where login_id=$login_id";
    $result=mysqli_query($con,$sql_login);
    $row_login=mysqli_fetch_array($result);

    $sql_login="select * from tbl_reg where login_id=$login_id";
    $result=mysqli_query($con,$sql_login);
    $row_reg=mysqli_fetch_array($result);

    $sql_propic="select * from tbl_pic where login_id=$login_id";
    $result_pro=mysqli_query($con,$sql_propic);
    $row_propic=mysqli_fetch_array($result_pro);

    $sql_dev="select * from tbl_device where login_id=$login_id";
    $result_dev=mysqli_query($con,$sql_dev);
    $result_dev1=mysqli_query($con,$sql_dev);
    // $row_dev=mysqli_fetch_array($result_dev);

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIND</title>
    <style>
        body{
            margin:0px;
            padding:0px;
            font-family: sign;
        }
        #map{
            border:none;
            width:100vw;
            height:100vh;
            /* background-color: black; */
        }
        .user{
            position: relative;
            z-index: 1;
            width:45px;
            height:45px;
            border-radius: 50%;
            margin:20px;
            background-image: url('../images/user.png');
            background-position: center;
            background-size: 45px 50px;
            box-shadow: 5px 5px 10px 1px #0d27505d, -5px -5px 10px 1px rgba(255, 255, 255, 0.438); 
        }
        .user:hover{
            box-shadow: 5px 5px 10px 1px #0d275018, -5px -5px 10px 1px rgba(255, 255, 255, 0.15);
            box-shadow:inset 10px 10px 10px 1px #0d275009, inset -10px -10px 10px 1px rgba(255, 255, 255, 0.438); 
            cursor: pointer;
        }
        .bottom_bar{
            position: fixed;
            bottom:20px;
            left:50%;
            /* background-color:white; */
            height:auto;
            z-index:1;
            transform: translate(-50%);
        }
        .cent{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .item{
            position: relative;
            float:left;
            margin:10px;
            background-color: rgba(255, 255, 255, 0.794);
            border-radius: 10px;
            box-shadow: 5px 5px 10px 3px #0d27503b, -5px -5px 10px 1px rgba(255, 255, 255, 0.431);
            padding:5px 15px 5px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .item:hover{
            box-shadow: 5px 5px 10px 1px #0d275018, -5px -5px 10px 1px rgba(255, 255, 255, 0.15);
            box-shadow:inset 10px 10px 10px 1px #0d275009, inset -10px -10px 10px 1px rgba(255, 255, 255, 0.438); 
            cursor: pointer;
        }
        @font-face {
            font-family:sign;
            src: url(../fonts/Signika.ttf);
        }
        .item .cont,.img{
            position: relative;
            float: left;
            margin:5px;
            font-size: 13px;
        }

        /* here */
        .modal {
            display: none;         /*  here <--------------------------- change this to none before review */
            position: fixed; 
            z-index: 2;
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0, 0, 0, 0.575);
        }

        /* Modal Content/Box */
        .modal-content {
            position: relative;
            top:50%;
            left:50%;
            transform: translate(-50%,-50%);
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 50%; 
            border-radius:10px;
            /* height:50%; */
            
        }

        /* The Close Button */
        .close {
          color: #aaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
        }

        .close:hover,
        .close:focus {
          color: black;
          text-decoration: none;
          cursor: pointer;
        }

        .containers{
            position: relative;
            width:96%;
            height:500px;
            /* background-color: blue; */
        }
        .left{
            position: relative;
            float: left;
            margin:1%;
            /* background-color: yellow; */
            width:48%;
            height:95%;
        }
        .photo{
            position:relative;
            /* background-color: yellow; */
            width: 100px;
            height: 20px;
            left:30%;
        }
        .left .img{
            position: relative;
            left:35%;
            width:100px;
            height:100px;
            background-color: rgb(106, 105, 105);
            border-radius: 50%;
            cursor:pointer;
            background-image: url('../images/user.png');
            background-position: center;
            background-size: 100px 120px;
        }
        .left .img .edit{
            opacity: 0;
            position: absolute;
            top:50%;
            left:50%;
            transform: translate(-50%,-27%);
            width:50px;
            height:100px;
            text-align: center;
            font-size:15px;
            color:white;
            transition: opacity .5s ease-in;
        }
        .left .img:hover .edit{
            opacity:1;
            cursor: pointer;
        }
        .frm{
            width:100%;
            position: relative;
            /* background-color: blue; */
        }
        .frm input, button{
            font-size:16px;
            width:99%;
            height:45px;
            position: relative;
            float:left;
            border:none;
            margin-top:20px;
            background-color: none;
            border-bottom:1px solid black ;
            /* box-shadow:inset 10px 10px 10px 1px #0d27500c, inset -10px -10px 10px 1px white; */
            /* padding-left:10px; */
            transform: .5s ease-in-out;
        }
        .frm button{
            width:100%;
            height:60px;
            border:none;
            color:rgb(66, 121, 193);
            border-radius: 9px;
            border:none;
            background-color: rgb(245, 245, 245);
            box-shadow: 10px 10px 10px 1px #0d275017,-10px -10px 10px 1px white;

        }
        .frm button:hover{
            box-shadow: 5px 5px 10px 1px #0d275017, -5px -5px 10px 1px white; 
        }
        .frm #update:hover{
            background-color: rgb(66, 121, 193);
            box-shadow: 5px 5px 10px 1px rgb(66, 121, 193,0.4), -5px -5px 10px 1px white; 
            color:white;
        }
        .frm #logout:hover{
            background-color: rgba(255, 0, 0, 0.75);
            box-shadow: 5px 5px 10px 1px rgba(255, 0, 0, 0.2), -5px -5px 10px 1px white; 
            color:white;
        }

        input:focus, button:focus{
            outline:none;
        }

        .insidecontainer{
            position: relative;
            width:600px;
            height:400px;
            /* background-color:blue; */
            left:50%;
            transform: translate(-51%);
            padding:0px 40px;
            overflow:scroll;

        }
        .data_cont{
            left:0px;
            position: relative;
            width:600px;
            height:40px;
            /* background-color: green; */
            margin-top:20px;
            padding:10px;
            border-radius:9px;
            background-color: rgb(245, 245, 245);
            box-shadow: 10px 10px 10px 1px #0d275017, -10px -10px 10px 1px white;
        }
        .data_cont:hover{
            /* background-color: rgb(66, 121, 193); */
            box-shadow: 5px 5px 10px 1px rgb(245, 245, 245), -5px -5px 10px 1px white; 
            /* color:white; */
        }
        
        .data_cont  .one{
            position:relative;
            float:left;
            width:100%;
        }
        .cont_left{
            position: relative;
            left:0;
            float:left;
            width:40px;
            height:40px;
            /* background-color: blue; */
            margin-left:10px;
        }
        .cont_middle{
            position: relative;
            left:0;
            float:left;
            width:auto;
            height:auto;
            /* background-color: blue; */
            top:50%;
            transform: translate(0,50%);
            margin-left:10px;
        }
        .cont_right{
            position: relative;
            right:0;
            float:right;
            width:30px;
            height:30px;
            /* background-color: blue; */
            top:50%;
            transform: translate(0,15%);
            margin-right:10px;
            background-image: url('../images/delete.png');
            background-position: center;
            background-size: 30px 30px;
            margin-left:30px;
        }

        .one button{
            width:50px;
            height:20px;
            position:relative;
            top:-20px;
            border:1px solid green;
            background-color:white;
            border-radius:2px;
            float:left;
            font-size:10px;
            top:50%;
            transform: translate(0,-50%);
            margin-left:30px;
        }
        .bottomcontainer{
            position: relative;
            bottom:-10px;
            /* background-color:green; */
            width:520px;
            height:100px;
            left:50%;
            top:0%;
            transform: translate(-50%,10%);
        }
        .bottomcontainer button{
            float:left;
            cursor: pointer;
            width:240px;
            margin-left:20px;
            color: rgb(69, 116, 181);
            border-radius: 9px;
            border: none;
            background-color: rgb(245, 245, 245);
            box-shadow: 10px 10px 10px 1px #0d275017, -10px -10px 10px 1px white;
        }
        .bottomcontainer button:hover{
            background-color: rgb(66, 121, 193);
            box-shadow: 5px 5px 10px 1px rgb(66, 121, 193,0.4), -5px -5px 10px 1px white; 
            color:white;
        }
        .secondcontent{
            /* background-color: gray; */
            width: 95%;
            height: auto;
            position: relative;
            left:50%;
            top:45%;
            transform: translate(-45%,-50%);
        }
        .secondcontent p{
            margin-top:0px;
            margin-bottom:0px;
            text-align: center;
        }
        .secondcontent button{
            cursor: pointer;
            margin-bottom: 30px;
            margin-top: 10px;
            width:100%;
            color: rgb(129, 156, 193);
            border-radius: 9px;
            border: none;
            background-color: rgb(245, 245, 245);
            box-shadow: 10px 10px 10px 1px #0d275017, -10px -10px 10px 1px white;
        }
        .secondcontent button:hover{
            background-color: rgb(66, 121, 193);
            box-shadow: 5px 5px 10px 1px rgb(66, 121, 193,0.4), -5px -5px 10px 1px white; 
            color:white;
        }

    </style>

    <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
    <script src='../js/map.js' defer ></script>

    <script>
        var name_val=true;
        var email=true;
        var passw=true;

        function cls(){
            document.getElementById("myModal").style.display="none";   
        }
        function clsview2(){
            document.getElementById("myModal2").style.display="none";   
        }

        function popup(){
            document.getElementById("myModal").style.display= "block";
        }
        function popupview2(){
            document.getElementById("myModal2").style.display= "block";
        }

        function upload(){
            document.getElementById('upload').click();
        }
        function revok(event){
            if (event.keyCode == 13)
            {
                event.preventDefault();
            }
        }
        function check(data){
            // alert("yes");
            if (data=='form' && name_val && email &&passw){
                // alert("yes")
                document.getElementById('updat').setAttribute("action", "add.php");
            }
            else if (data=='logout'){
                document.getElementById('updat').setAttribute("action", "logout.php");
            }
            else{
                event.preventDefault();
            }
        }

        function full_name(id){
            elem=document.getElementById(id);
            patt=/^([a-zA-Z\. ]{3,})+$/;
            if(elem.value.trim()=="" || !elem.value.match(patt))
            {   
                name_val=false;
                elem.value="";
                elem.placeholder="invalid name";
                elem.style.cssText="border-bottom: 1px solid red";
            }
            else{
                name_val=true;
                elem.style.cssText="border-bottom:1px solid black ;";
            }
        }


        function email_id(id){
            elem=document.getElementById(id);
            patt=/^([A-Za-z0-9\.]{4,30})+@([a-z]{3,})+\.+([a-z\.])+$/;
            // patt=/^([A-Za-z0-9\.]{4,30})+@[a-z.]+\.+[a-z]+$/;
            if(elem.value.trim()=="" || !elem.value.match(patt))
            {   
                email=false;
                elem.value="";
                elem.placeholder="invalid email";
                elem.style.cssText="border-bottom: 1px solid red";
            }
            else{
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() 
                {
                    if (this.readyState == 4 && this.status == 200) 
                    {
                        if(this.responseText == 'false'){
                            email=false;
                            elem.value="";
                            elem.placeholder="Email already exist";
                            elem.style.cssText="border-bottom: 1px solid red";
                        }
                        else{
                            email=true;
                            elem.style.cssText="border-bottom:1px solid black ;";
                        }
                    }
                };
                xhttp.open("GET", "checkemail.php?email="+document.getElementById('email').value + "&id="+<?php echo $login_id ?>, true);
                xhttp.send();
            }
        }


        function pass(id){
            elem=document.getElementById(id);
            passone_field=elem;
            patt=/^(?=.*[!@#$%^&*(),.?":{}|<>\ ])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if(elem.value.trim()=="" || !elem.value.match(patt))
            {   
                passw=false;
                elem.value="";
                elem.placeholder="ex: !Abcdef8";
                elem.style.cssText="border-bottom: 1px solid red";
            }
            else{
                passw=true;
                elem.style.cssText="border-bottom:1px solid black ;";
            }
        } 

        function del(val) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() 
            {
                if (this.readyState == 4 && this.status == 200) 
                {
                    // alert(this.responseText);
                    if(this.responseText == 'active'){
                        document.getElementById(val).innerHTML='Lost';
                        // email_ajax=false;
                    }
                    else{
                        // email_ajax=true;
                        document.getElementById(val).innerHTML='Avtive';
                    }
                }
            };
            xhttp.open("GET", "del.php?id="+val, true);
            xhttp.send();
        }
        function openView(){
            cls();
            popupview2()
        }

    </script>
</head>

<body>

    <div id='map'>
        <div class="user" width="45px" height="45px" id="tumb" onclick="popup()">
            <?php
                if(mysqli_num_rows($result_pro)>0)
                { ?>
                    <script>document.getElementById('tumb').style.cssText="background-image: url('../images/<?php echo $row_propic['filename'] ?>');"</script><?php
                }
            ?>
        </div>

        <div class="bottom_bar">
            <center>
                <div class="cent">
                    <?php
                    if(mysqli_num_rows($result_dev1)>0){
                        while($row_dev1=mysqli_fetch_array($result_dev1)){
                            $type1=$row_dev1['type'];
                            $dname1=$row_dev1['name'];
                            $imei1=$row_dev1['imei'];
                            $dev_id1=$row_dev1['device_id'];

                            $img1="";
                            if($type1=='mobile'){
                                $img1='../images/phone.png';
                            }
                            else if($type1=='pc'){
                                $img1='../images/desktop.png';
                            }
                            else{
                                $img1='../images/ipad.png';
                            } ?>

                            <div class="item" onclick="openView()">
                                <div class="img"><img src="<?php echo $img1 ?>" width="30px" height="30px" alt=""></div>
                                <div class="cont"><?php echo $dname1 ?></div>
                            </div>

                    <?php }
                    }
                    ?>
                </div>
            </center>
        </div>
    </div>

<!-- hidden box for user updation -->
<div id="myModal" class="modal">
    <div class="modal-content">
      <span onclick="cls()" class="close">&times;</span>
        <div class="containers">
            <div class="left">
                <form method='POST' id="updat" enctype="multipart/form-data">
                        <div class="photo">
                            <div id="pro" class="img" onclick="upload()">
                                <div class="edit">Upload an image</div>
                                <?php
                                if(mysqli_num_rows($result_pro)>0){
                                    ?>
                                    <script>document.getElementById('pro').style.cssText="background-image: url('../images/<?php echo $row_propic['filename'] ?>');"</script>
                                <?php }    
                                ?>
                                <input id="upload" style="visibility:hidden;cursor:pointer" onchange="done()" type="FILE" accept="image/jpeg" name='propic'>
                            </div>
                        </div>
                    <div class="frm">
                        <input type="text" onblur="full_name(this.id)" name="name" id="nam" value="<?php echo $row_reg['name']?>" placeholder="Name" onkeypress="revok(event)">
                        <input type="text" onblur="email_id(this.id)" name="email" value="<?php echo $row_login['email']?>" id="email" placeholder="E-Mail" onkeypress="revok(event)">
                        <input type="password" onblur="pass(this.id)" name="password" id="passwrd" placeholder="Change Password" onkeypress="revok(event)">
                        <button id="update" onclick="check('form')">Update Account</button>
                        <button id="logout" onclick="check('logout')">Logout</button>
                    </div>
                </form>
            </div>
            <div class="left" >
                <div class="secondcontent">
                    <p>To view all active devices and further informations, click and view on view device button below 👇</p>
                    <button onclick="openView()">View device</button>
                    <p>However if wanted to view all your log files, click on the button below 👇</p>
                    <button onclick="location.href='pdfGenarator/pdf.php?from=view'">Generate and view logs</button>
                    <p>If in case you needed to download all your logs and informations to take it offline, the button below 👇 is the option to go.</p>
                    <button onclick="location.href='pdfGenarator/pdf.php?from=download'">Download logs file</button>
                </div>
            </div>
        </div>
      
    </div>
</div>

<!-- -------------- device view -->
<div id="myModal2" class="modal" style="display:none">
    <div class="modal-content">
      <span onclick="clsview2()" class="close">&times;</span>
        <div class="containers">
            <div class="insidecontainer">
                <?php
                    if(mysqli_num_rows($result_dev)>0){
                        while($row_dev=mysqli_fetch_array($result_dev)){
                            $type=$row_dev['type'];
                            $dname=$row_dev['name'];
                            $imei=$row_dev['imei'];
                            $dev_id=$row_dev['device_id'];

                            $img="";

                            if($type=='mobile'){
                                $img='../images/phone.png';
                            }
                            else if($type=='pc'){
                                $img='../images/desktop.png';
                            }
                            else{
                                $img='../images/ipad.png';
                            }

                            ?>
                            <div class="data_cont">
                                <div class="one">
                                    <img id="im" width="30px" height="30px" class="cont_left" src="<?php echo $img ?>">
                                    <div class="cont_middle"><?php echo $dname ?></div>
                                    <div class="cont_middle">imei :<?php echo $imei ?></div>
                                    <button id="<?php echo $dev_id ?>" onclick="del(<?php echo $dev_id ?>)">Lost</button>
                                    <a href="delete.php?id=<?php echo $dev_id ?>"><div class="cont_right"></div></a>
                                </div>          
                            </div>
                            <?php
                        }
                    }
                    ?>
            </div>
            <div class="bottomcontainer">
                <button onclick="location.href='pdfGenarator/pdf.php?from=view'">Generate and view logs</button>
                <button onclick="location.href='pdfGenarator/pdf.php?from=download'">Download logs file</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php }
else{
    header("location:../index.php");
}
?>