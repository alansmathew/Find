<?php
session_start();
if(isset($_SESSION['id'])){?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            src: url(fonts/Signika.ttf);
        }
        .item .cont,.img{
            position: relative;
            float: left;
            margin:5px;
            font-size: 13px;
        }

        /* here */
        .modal {
            display: block; 
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
            height:450px;
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
        .left .img{
            position: relative;
            left:35%;
            width:100px;
            height:100px;
            background-color: rgb(106, 105, 105);
            border-radius: 50%;
            cursor:pointer;
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

    </style>
    <!-- <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script> -->
    <!-- <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" /> -->
    <!-- <script src='../js/map.js' defer ></script> -->
    <script>

        function cls(){
            document.getElementById("myModal").style.display="none";   
        }

        function popup(){
            document.getElementById("myModal").style.display= "block";
        }

        function upload(){
            document.getElementById('upload').click();
        }
        function done(){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() 
            {
                if (this.readyState == 4 && this.status == 200) 
                {
                    alert(this.responseText);

                }
            };
            xhttp.open("GET","propic.php?img="+document.getElementById('upload').value, true);
            xhttp.send();
        }
    </script>
</head>

<body>

    <div id='map'>
        <img class="user" onclick="popup()" src="../images/user.png">
        <div class="bottom_bar">
            <center>
                <div class="cent">
                    <div class="item">
                        <div class="img"><img src="../images/phone.png" width="30px" height="30px" alt=""></div>
                        <div class="cont">iphone 8</div>
                    </div>
                    <div class="item">
                        <div class="img"><img src="../images/desktop.png" width="30px" height="30px" alt=""></div>
                        <div class="cont">azuse notebook</div>
                    </div>
                    <div class="item">
                        <div class="img"><img src="../images/ipad.png" width="30px" height="30px" alt=""></div>
                        <div class="cont">ipad air</div>
                    </div>
                </div>
            </center>
        </div>
    </div>

<!-- hidden box for user updation -->
<div id="myModal" class="modal">
    <div class="modal-content">
      <span onclick="cls()" class="close">&times;</span>
      <form action="add.php" method='POST' enctype="multipart/form-data">
        <div class="containers">
            <div class="left">
                <div class="img" onclick="upload()">
                    <div class="edit">Upload an image</div>
                    <input id="upload" style="visibility:hidden;cursor:pointer" onchange="done()" type="FILE" accept="image/jpeg" name='propic'>
                </div>
            </div>
            <div class="left" >
                
            </div>
        </div>
      </form>
    </div>
</div>

</body>
</html>

<?php }
else{
    header("location:../index.php");
}
?>