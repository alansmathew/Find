<?php
session_start();
require __DIR__.'/pdf/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
if(isset($_SESSION['id'])){
    include("../connection.php");
    $login_id=$_SESSION['id'];

    $sql="SELECT * FROM `tbl_pic` where login_id = $login_id";
    $res=mysqli_query($con,$sql);
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_array($res);
        $image=$row['filename']; // image file name
    }
    else{
        $image="user.png";
    }

    $sql="SELECT * FROM `tbl_reg` where login_id = $login_id";
    $row=mysqli_fetch_array(mysqli_query($con,$sql));
    $username=$row['name']; // user full name
    

    $html2pdf = new Html2Pdf();

    $url="http://localhost/Find/web/php/pdfGenarator/test.php?id=$login_id";
    // $url="https://alansmathew.000webhostapp.com/php/pdfGenarator/test.php?id=$login_id";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $div = curl_exec($ch);
    $html='

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
            <img src="../../images/'.$image.' " alt="">
            <p>'.$username.'</p>
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
                    <th class="dis">Activity<br>&nbsp;<br>&nbsp;</th>
                </tr>'.$div.'
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



';


$html2pdf->writeHTML($html);

if($_GET['from']=='view'){
    $html2pdf->output("Find_log.pdf");
}
elseif($_GET['from']=='download'){
    $html2pdf->output("Find_log.pdf","D");
}

// $html2pdf->output("Find_log.pdf","D");// to download pdf 
// $html2pdf->output("Find_log.pdf"); //to view in next page as pdf 

}
else{
    header("location:../../index.php");
}
?>