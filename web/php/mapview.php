<?php
session_start();
if(isset($_SESSION['id'])){?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            margin:0px;
            padding:0px;
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
            font-family: sign;
            font-size: 13px;
        }

        /* here */
        .modal {
          display: none; 
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
          background-color: #fefefe;
          margin: 15% auto; /* 15% from the top and centered */
          padding: 20px;
          border: 1px solid #888;
          width: 50%; /* Could be more or less, depending on screen size */
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
    </style>
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
    <script src='../js/map.js' defer ></script>
    <script>

        function cls(){
            document.getElementById("myModal").style.display="none";   
        }

        function popup(){
            document.getElementById("myModal").style.display= "block";
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



      <p>Some text in the Modal..</p>


      
    </div>
</div>

</body>
</html>

<?php }
else{
    header("location:../index.html");
}
?>