<?php
session_start();
if(isset($_SESSION['id'])){
    include("../connection.php");
    $login_id=$_SESSION['id'];
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 750px width for pdf file in A4 -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            margin: 0px;
            padding:0px;
            
        }
        .container{
            width:750px;
            height:300px;
            
        }
        .left{
            position: relative;
            float: left;
            width:200px;
            height:150px;
            
        }
        .left img{
            width:100px;
            height: 100px;
            position: relative;
        }
        .right{
            position: absolute;
            right:0px;
            top:19px;
            width:200px;
            height:150px;
            text-align: center;
        }
        .right img{
            width: 70px;
            height:70px;
            border-radius: 50%; 
        }
        .sessions{
            float:left;
            width:730px;
            display: block;
            background-color: rgb(243, 249, 252);
            padding:10px;
            border-radius: 20px;
            margin-bottom:20px;
        }
        .sessions h4{
            float:left;
            font-size: 15px;
            color:gray;
        }
        .device{
            float:left;
            width: 30px;
            height: 30px; 
            margin-top:10px;
            margin-right: 20px;
        }
        hr{
            border: 1px solid gray;
            float: left;
            width: 730px;
            margin-top: 0px;
        }
        .container p{
            font-style: italic;
            text-align:center;
            line-height: 20px;
        }
        table{
            text-align:center;
        }
        table .date{
            width:70px;
        }
        table .dis{
            width:590px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <img src="../../images/find_logo.png" alt="">
        </div>
        
        <div class="right">
            <img src="../../images/IMG_1527.jpeg" alt="">
            <p>Alan S Mathew</p>
        </div>
         <h2>Activities :</h2>
        
        <div class="sessions"> <!--  profile activities -->
            <img src="../../images/settings.png" class="device" alt="">
            <h4>Profile logs:</h4>
            <hr>
            <table>
                <tr>
                    <th class="date">Time</th>
                    <th class="date">Date</th>
                    <th class="dis">Activity<br>&nbsp;</th>
                </tr>
                <?php
                    $sql="select * from tbl_log where login_id='$login_id' and type='profile' ORDER BY datetime desc";
                    $result=mysqli_query($con,$sql);
                    while($row=mysqli_fetch_array($result))
                    {
                        echo "
                                <tr > 
                                    <td>".$row['date']."</td>
                                    <td>".$row['time']."</td>
                                    <td>".$row['dis']."<br>&nbsp;</td>
                                </tr>
                            ";
                    }
                ?>
            </table>
        </div>

        <div class="sessions">
            <img src="../../images/device.png" class="device" alt="">
            <h4>Device logs:</h4>
            <hr>
        </div>
        <p>
            All the information above is server automated according to the logs and activites done by the user. Alla these datas can only be accessed by you and you only.
            None of these data is exposed to any other users. If there is any unrelated access or suspecious activities, please reset your password to a secure one and never
            share it to someone else.
        </p>
    </div>
</body>
</html>

<?php
}
else{
    header("location:../../index.php");
}
?>