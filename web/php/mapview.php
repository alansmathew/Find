<?php
session_start();
if (isset($_SESSION['id'])) {
    include("connection.php");
    include("../confidential.php");
    $login_id = $_SESSION['id'];
    $sql_login = "select * from tbl_login where login_id=$login_id";
    $result = mysqli_query($con, $sql_login);
    $row_login = mysqli_fetch_array($result);

    $sql_login = "select * from tbl_reg where login_id=$login_id";
    $result = mysqli_query($con, $sql_login);
    $row_reg = mysqli_fetch_array($result);

    $sql_propic = "select * from tbl_pic where login_id=$login_id";
    $result_pro = mysqli_query($con, $sql_propic);
    $row_propic = mysqli_fetch_array($result_pro);

    $sql_dev = "select * from tbl_device where login_id=$login_id";
    $result_dev = mysqli_query($con, $sql_dev);
    $result_dev1 = mysqli_query($con, $sql_dev);
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
            body {
                margin: 0px;
                padding: 0px;
                font-family: sign;
            }

            #map {
                border: none;
                width: 100vw;
                height: 100vh;
                /* background-color: black; */
            }

            .user {
                position: relative;
                z-index: 1;
                width: 45px;
                height: 45px;
                border-radius: 50%;
                margin: 20px;
                background-image: url('../images/user.png');
                background-position: center;
                background-size: 45px 50px;
                box-shadow: 5px 5px 10px 1px #0d27505d, -5px -5px 10px 1px rgba(255, 255, 255, 0.438);
            }

            .user:hover {
                box-shadow: 5px 5px 10px 1px #0d275018, -5px -5px 10px 1px rgba(255, 255, 255, 0.15);
                box-shadow: inset 10px 10px 10px 1px #0d275009, inset -10px -10px 10px 1px rgba(255, 255, 255, 0.438);
                cursor: pointer;
            }

            .bottom_bar {
                position: fixed;
                bottom: 20px;
                left: 50%;
                /* background-color:white; */
                height: auto;
                z-index: 1;
                transform: translate(-50%);
            }

            .cent {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .item {
                position: relative;
                float: left;
                margin: 10px;
                background-color: rgba(255, 255, 255, 0.794);
                border-radius: 10px;
                box-shadow: 5px 5px 10px 3px #0d27503b, -5px -5px 10px 1px rgba(255, 255, 255, 0.431);
                padding: 5px 15px 5px 15px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .item:hover {
                box-shadow: 5px 5px 10px 1px #0d275018, -5px -5px 10px 1px rgba(255, 255, 255, 0.15);
                box-shadow: inset 10px 10px 10px 1px #0d275009, inset -10px -10px 10px 1px rgba(255, 255, 255, 0.438);
                cursor: pointer;
            }

            @font-face {
                font-family: sign;
                src: url(../fonts/Signika.ttf);
            }

            .item .cont,
            .img {
                position: relative;
                float: left;
                margin: 5px;
                font-size: 13px;
            }

            /* here */
            .modal {
                display: none;
                /*  here <--------------------------- change this to none before review */
                position: fixed;
                z-index: 2;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.575);
            }

            /* Modal Content/Box */
            .modal-content {
                position: relative;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fefefe;
                padding: 20px;
                border: 1px solid #888;
                width: 50%;
                border-radius: 10px;
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

            .containers {
                position: relative;
                width: 96%;
                height: 500px;
                /* background-color: blue; */
            }

            .left {
                position: relative;
                float: left;
                margin: 1%;
                /* background-color: yellow; */
                width: 48%;
                height: 95%;
            }

            .photo {
                position: relative;
                /* background-color: yellow; */
                width: 100px;
                height: 20px;
                left: 30%;
            }

            .left .img {
                position: relative;
                left: 35%;
                width: 100px;
                height: 100px;
                background-color: rgb(106, 105, 105);
                border-radius: 50%;
                cursor: pointer;
                background-image: url('../images/user.png');
                background-position: center;
                background-size: 100px 120px;
            }

            .left .img .edit {
                opacity: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -27%);
                width: 50px;
                height: 100px;
                text-align: center;
                font-size: 15px;
                color: white;
                transition: opacity .5s ease-in;
            }

            .left .img:hover .edit {
                opacity: 1;
                cursor: pointer;
            }

            .frm {
                width: 100%;
                position: relative;
                /* background-color: blue; */
            }

            .frm input,
            button {
                font-size: 16px;
                width: 99%;
                height: 45px;
                position: relative;
                float: left;
                border: none;
                margin-top: 20px;
                background-color: none;
                border-bottom: 1px solid black;
                /* box-shadow:inset 10px 10px 10px 1px #0d27500c, inset -10px -10px 10px 1px white; */
                /* padding-left:10px; */
                transform: .5s ease-in-out;
            }

            .frm button {
                width: 100%;
                height: 60px;
                border: none;
                color: rgb(66, 121, 193);
                border-radius: 9px;
                border: none;
                background-color: rgb(245, 245, 245);
                box-shadow: 10px 10px 10px 1px #0d275017, -10px -10px 10px 1px white;

            }

            .frm button:hover {
                box-shadow: 5px 5px 10px 1px #0d275017, -5px -5px 10px 1px white;
            }

            .frm #update:hover {
                background-color: rgb(66, 121, 193);
                box-shadow: 5px 5px 10px 1px rgb(66, 121, 193, 0.4), -5px -5px 10px 1px white;
                color: white;
            }

            .frm #logout:hover {
                background-color: rgba(255, 0, 0, 0.75);
                box-shadow: 5px 5px 10px 1px rgba(255, 0, 0, 0.2), -5px -5px 10px 1px white;
                color: white;
            }

            input:focus,
            button:focus {
                outline: none;
            }

            .insidecontainer {
                position: relative;
                width: 600px;
                height: 400px;
                /* background-color:blue; */
                left: 50%;
                transform: translate(-51%);
                padding: 0px 40px;
                overflow: scroll;
                position: relative;
                display: flex;
                flex-wrap: wrap;
                justify-content:center;
            }
/* new one */
            .devicebox{
            position: relative;
            width:250px;
            height:300px;
            margin:20px;
            /* background-color: aliceblue; */
            background-color: rgb(245, 245, 245);
            border-radius: 10px;
            box-shadow: 10px 10px 10px 1px #0d275017, -10px -10px 10px 1px white;

        }
        .heading_box{
            position: relative;
            width:220px;
            height:60px;
            margin: 15px;
            /* background-color: antiquewhite; */
        }
        .headding_content{
            float: left;
            width:170px;
            height:100%;
            /* background: beige; */
        }

        .device_image_box{
            float: right;
            width:50px;
            height: 100%;
            /* background: blueviolet; */
        }
        .device_image_box img{
            width: 100%;
            height:75%;
            object-fit: contain;
        }
        .device_name_heading{
            width: 100%;
            height:24px;
            /* background: brown; */
            font-size: 20px;
            font-family: sans-serif;
        }
        .device_address{
            padding-top: 5px;
            width:100%;
            height: 76px;
            font-size: 12px;
            color:rgb(70, 70, 70);
            font-family: sans-serif;
        }
        .devicebox .remove_button{
            position: absolute;
            bottom: 10px;
            width:100%;
            height: 30px;
            color: red;
            font-size: 17px;
            font-family: sans-serif;
            border:none;
            background-color: inherit;
            cursor: pointer;
            transition: ease-in-out .1s all;
        }
        .remove_button:hover{
            font-size: 17.5px;
        }
        .device_state_box{
            position: relative;
            width:220px;
            height:140px;
            margin: 15px;
            background-color: rgba(230, 230, 250, 0.427);
            border-radius: 10px;
        }
        .device_state_box .device_lost_class{
            position: absolute;
            width: 100%;
            font-size: 13px;
            font-family: sans-serif;
            border:none;
            padding-top: 7px;
            bottom:10px;
            height: 20px;
            color:blue;
            cursor: pointer;
            background-color: rgba(230, 230, 250, 0);
            transition: all ease-in-out .1s;
        }
        .device_lost_class:hover{
            font-size: 13.6px;
        }
        .device_state_box .heading_of_device_state{
            width: 100%;
            font-family: sans-serif;
            font-size: 14.5px;
            text-align: center;
            padding-top:10px;
            padding-bottom: 5px;
            border-bottom:1px dotted rgba(82, 82, 82, 0.125);
            border-top: none;
            border-left: none;
            border-right: none;
            /* background-color: khaki; */
        }
        .actual_adress_box{
            /* background-color: khaki; */
            font-size: 13px;
            font-family: sans-serif;
            color:rgba(53, 53, 53, 0.872);
            margin: 7px;
            height: 65px;
            overflow: scroll;
        }

  /* till herer  */

            .bottomcontainer {
                position: relative;
                bottom: -10px;
                /* background-color:green; */
                width: 520px;
                height: 100px;
                left: 50%;
                top: 0%;
                transform: translate(-50%, 10%);
            }

            .bottomcontainer button {
                float: left;
                cursor: pointer;
                width: 240px;
                margin-left: 20px;
                color: rgb(69, 116, 181);
                border-radius: 9px;
                border: none;
                background-color: rgb(245, 245, 245);
                box-shadow: 10px 10px 10px 1px #0d275017, -10px -10px 10px 1px white;
            }

            .bottomcontainer button:hover {
                background-color: rgb(66, 121, 193);
                box-shadow: 5px 5px 10px 1px rgb(66, 121, 193, 0.4), -5px -5px 10px 1px white;
                color: white;
            }

            .secondcontent {
                /* background-color: gray; */
                width: 95%;
                height: auto;
                position: relative;
                left: 50%;
                top: 45%;
                transform: translate(-45%, -50%);
            }

            .secondcontent p {
                margin-top: 0px;
                margin-bottom: 0px;
                text-align: center;
            }

            .secondcontent button {
                cursor: pointer;
                margin-bottom: 30px;
                margin-top: 10px;
                width: 100%;
                color: rgb(129, 156, 193);
                border-radius: 9px;
                border: none;
                background-color: rgb(245, 245, 245);
                box-shadow: 10px 10px 10px 1px #0d275017, -10px -10px 10px 1px white;
            }

            .secondcontent button:hover {
                background-color: rgb(66, 121, 193);
                box-shadow: 5px 5px 10px 1px rgb(66, 121, 193, 0.4), -5px -5px 10px 1px white;
                color: white;
            }

            .loading_window {
                position: absolute;
                width: 100vw;
                height: 100vh;
                z-index: 10;
                background-color: white;
                opacity: .8;
                display: none;
            }

            .loading_window img {
                position: relative;
                width: 100px;
                height: 100px;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>

        <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
        <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
        <script src='../js/map.js' defer></script>

        <script>
            var name_val = true;
            var email = true;
            var passw = true;

            function cls() {
                document.getElementById("myModal").style.display = "none";
            }

            function clsview2() {
                document.getElementById("myModal2").style.display = "none";
            }

            function popup() {
                document.getElementById("myModal").style.display = "block";
            }

            function popupview2() {
                document.getElementById("myModal2").style.display = "block";
            }

            function upload() {
                document.getElementById('upload').click();
            }

            function revok(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                }
            }

            function check(data) {
                // alert("yes");
                if (data == 'form' && name_val && email && passw) {
                    // alert("yes")
                    document.getElementById('updat').setAttribute("action", "add.php");
                } else if (data == 'logout') {
                    document.getElementById('updat').setAttribute("action", "logout.php");
                } else {
                    event.preventDefault();
                }
            }

            function full_name(id) {
                elem = document.getElementById(id);
                patt = /^([a-zA-Z\. ]{3,})+$/;
                if (elem.value.trim() == "" || !elem.value.match(patt)) {
                    name_val = false;
                    elem.value = "";
                    elem.placeholder = "invalid name";
                    elem.style.cssText = "border-bottom: 1px solid red";
                } else {
                    name_val = true;
                    elem.style.cssText = "border-bottom:1px solid black ;";
                }
            }


            function email_id(id) {
                elem = document.getElementById(id);
                patt = /^([A-Za-z0-9\.]{4,30})+@([a-z]{3,})+\.+([a-z\.])+$/;
                // patt=/^([A-Za-z0-9\.]{4,30})+@[a-z.]+\.+[a-z]+$/;
                if (elem.value.trim() == "" || !elem.value.match(patt)) {
                    email = false;
                    elem.value = "";
                    elem.placeholder = "invalid email";
                    elem.style.cssText = "border-bottom: 1px solid red";
                } else {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            if (this.responseText == 'false') {
                                email = false;
                                elem.value = "";
                                elem.placeholder = "Email already exist";
                                elem.style.cssText = "border-bottom: 1px solid red";
                            } else {
                                email = true;
                                elem.style.cssText = "border-bottom:1px solid black ;";
                            }
                        }
                    };
                    xhttp.open("GET", "checkemail.php?email=" + document.getElementById('email').value + "&id=" + <?php echo $login_id ?>, true);
                    xhttp.send();
                }
            }


            function pass(id) {
                elem = document.getElementById(id);
                passone_field = elem;
                patt = /^(?=.*[!@#$%^&*(),.?":{}|<>\ ])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
                if (elem.value.trim() == "" || !elem.value.match(patt)) {
                    passw = false;
                    elem.value = "";
                    elem.placeholder = "ex: !Abcdef8";
                    elem.style.cssText = "border-bottom: 1px solid red";
                } else {
                    passw = true;
                    elem.style.cssText = "border-bottom:1px solid black ;";
                }
            }

            function del(val) {
                lod = document.getElementById('loading_win');
                lod.style.cssText = "display:block";
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // alert(this.responseText);
                        if (this.responseText == 'active') {
                            document.getElementById("changestatusofdevice").innerHTML = 'Current status : Active';
                            document.getElementById(val).innerHTML = 'Mark as Lost';
                            lod.style.cssText = "display:none";
                            // email_ajax=false;
                        } else {
                            // email_ajax=true;
                            document.getElementById("changestatusofdevice").innerHTML = 'Current status : Lost';
                            document.getElementById(val).innerHTML = 'Mark as Active';
                            lod.style.cssText = "display:none";
                        }
                    }
                };
                xhttp.open("GET", "del.php?id=" + val, true);
                xhttp.send();
            }

            function openView() {
                cls();
                popupview2()
            }

            async function pointlocations() {
                // console.log(document.getElementsByClassName('hidden_possition')[0].innerHTML);
                number_of_devices = document.getElementsByClassName('cont').length;
                poscount = -1;
                for (i = 0; i < number_of_devices; i += 1) {
                    lat = document.getElementsByClassName('hidden_possition')[poscount + 1].innerHTML;
                    lon = document.getElementsByClassName('hidden_possition')[poscount + 2].innerHTML;
                    poscount += 2;
                    dev_name = document.getElementsByClassName('cont')[i].innerHTML;
                    new mapboxgl.Marker({
                            color: "#d92329",
                        })
                        .setLngLat([lon, lat])
                        .addTo(map)
                        .setPopup(new mapboxgl.Popup().setHTML("<h3>" + dev_name + "</h3>"));
                }
            }
        </script>
    </head>

    <body onload="pointlocations()">
        <div class="loading_window" id="loading_win">
            <!--loading window for lost and active switching -->
            <img src="../images/loading_window.gif" alt="loding window">
        </div>

        <div id='map'>
            <div class="user" width="45px" height="45px" id="tumb" onclick="popup()">
                <?php
                if (mysqli_num_rows($result_pro) > 0) { ?>
                    <script>
                        document.getElementById('tumb').style.cssText = "background-image: url('../images/<?php echo $row_propic['filename'] ?>');"
                    </script><?php
                            }
                                ?>
            </div>

            <!-- bottom bar with list of devices  -->
            <div class="bottom_bar">
                <center>
                    <div class="cent">
                        <?php
                        if (mysqli_num_rows($result_dev1) > 0) {
                            while ($row_dev1 = mysqli_fetch_array($result_dev1)) {
                                $type1 = $row_dev1['type'];
                                $dname1 = $row_dev1['name'];
                                $imei1 = $row_dev1['imei'];
                                $dev_id1 = $row_dev1['device_id'];
                                $lat = $row_dev1['lat'];
                                $lon = $row_dev1['lon'];

                                $img1 = "";
                                if ($type1 == 'mobile') {
                                    $img1 = '../images/phone.png';
                                } else if ($type1 == 'pc') {
                                    $img1 = '../images/desktop.png';
                                } else {
                                    $img1 = '../images/ipad.png';
                                } ?>

                                <div class="item" onclick="openView()">
                                    <div class="img"><img src="<?php echo $img1 ?>" width="30px" height="30px" alt=""></div>
                                    <div class="cont"><?php echo $dname1 ?></div>
                                    <div class="hidden_possition" style="display:none"><?php echo $lat ?></div>
                                    <div class="hidden_possition" style="display:none"><?php echo $lon ?></div>
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
                                    if (mysqli_num_rows($result_pro) > 0) {
                                    ?>
                                        <script>
                                            document.getElementById('pro').style.cssText = "background-image: url('../images/<?php echo $row_propic['filename'] ?>');"
                                        </script>
                                    <?php }
                                    ?>
                                    <input id="upload" style="visibility:hidden;cursor:pointer" onchange="done()" type="FILE" accept="image/jpeg" name='propic'>
                                </div>
                            </div>
                            <div class="frm">
                                <input type="text" onblur="full_name(this.id)" name="name" id="nam" value="<?php echo $row_reg['name'] ?>" placeholder="Name" onkeypress="revok(event)">
                                <input type="text" onblur="email_id(this.id)" name="email" value="<?php echo $row_login['email'] ?>" id="email" placeholder="E-Mail" onkeypress="revok(event)">
                                <input type="password" onblur="pass(this.id)" name="password" id="passwrd" placeholder="Change Password" onkeypress="revok(event)">
                                <button id="update" onclick="check('form')">Update Account</button>
                                <button id="logout" onclick="check('logout')">Logout</button>
                            </div>
                        </form>
                    </div>
                    <div class="left">
                        <div class="secondcontent">
                            <p>To view all active devices and further informations, click and view on view device button below 👇</p>
                            <button onclick="openView()">View device</button>
                            <p>However if wanted to view all your log files, click on the button below 👇</p>
                            <a href="pdfGenarator/pdf.php?from=view" target="_blank"><button>Generate and view logs</button></a>
                            <p>If in case you needed to download all your logs and informations to take it offline, the button below 👇 is the option to go.</p>
                            <a href="pdfGenarator/pdf.php?from=download" target="_blank"><button>Download logs file</button></a>
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
                        if (mysqli_num_rows($result_dev) > 0) {
                            while ($row_dev = mysqli_fetch_array($result_dev)) {
                                $type = $row_dev['type'];
                                $dname = $row_dev['name'];
                                $imei = $row_dev['imei'];
                                $dev_id = $row_dev['device_id'];
                                $newlat = $row_dev['lat'];
                                $newlon = $row_dev['lon'];
                                $time = $row_dev['time'];

                                $actualTime= new DateTime(date('h:i:s y-m-d'));
                                $difference = $actualTime->diff(new DateTime(date($time)));
                                $years=$difference->y;
                                $month=$difference->m;
                                $day=$difference->d;
                                $hours=$difference->h;
                                $min=$difference->i;
                
                                $datetimeDifference='';
                                if($years == 0 && $month == 0 && $day ==0 && $hours ==0 && $min > 0 ){
                                    $datetimeDifference = $min." min";
                                }
                                elseif($years == 0 && $month == 0 && $day ==0 && $hours > 0 ){
                                    $datetimeDifference = $hours.':'.$min." hrs";
                                }
                                elseif($years == 0 && $month == 0 && $day > 0 ){
                                    $datetimeDifference = $day.' days '.$hours.' hrs';
                                }
                                elseif($years == 0 && $month > 0 ){
                                    $datetimeDifference = $month.' months '.$day.' day';
                                }
                                elseif($years > 0 ){
                                    $datetimeDifference = $years.' year '.$month.' months';
                                }
                                else{
                                    $datetimeDifference = 'Now';
                                }


                                $img = "";

                                if ($type == 'mobile') {
                                    $img = '../images/phone.png';
                                } else if ($type == 'pc') {
                                    $img = '../images/desktop.png';
                                } else {
                                    $img = '../images/ipad.png';
                                }
                            
                                $url=$googlemapAPI.$newlat.','.$newlon;
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_POST, false); 
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch);
                                $decode = json_decode($result);
                                $deviceaddress=$decode->results[0]->formatted_address;
    

                        ?>
                            <div class="devicebox">
                                <div class="heading_box">
                                    <div class="headding_content">
                                        <div class="device_name_heading"><?php echo $dname ?></div>
                                        <div class="device_address">Last seen : <?php echo($datetimeDifference)?></div>
                                    </div>
                                    <div class="device_image_box"><img src="<?php echo $img ?>" alt=""></div>
                                </div>
                                <div class="device_state_box">
                                    <div class="heading_of_device_state" id="changestatusofdevice">Current status : Active</div>
                                    <div class="actual_adress_box">
                                        Last seen in : <div class="googledata"><?php echo($deviceaddress) ?></div>
                                    </div>
                                    <button id="<?php echo $dev_id ?>" onclick="del(<?php echo $dev_id ?>)" class="device_lost_class">Mark as 
                                        <?php
                                            if ($row_dev['state'] == 'lost') echo 'Active';
                                            else echo "Lost";
                                        ?>
                                    </button>
                                </div>
                                <a href="delete.php?id=<?php echo $dev_id ?>"><button class="remove_button">Remove</button></a>
                            </div>

                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="bottomcontainer">
                        <a href="pdfGenarator/pdf.php?from=view" target="_blank"><button>Generate and view logs</button></a>
                        <a href="pdfGenarator/pdf.php?from=download" target="_blank"><button>Download logs file</button></a>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>

<?php } else {
    header("location:../index.php");
}
?>