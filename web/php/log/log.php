<?php

function log_activity(mysqli $con,$login_id,$type,$dis){
    date_default_timezone_set("Asia/Kolkata");
    $date=date('d-m-y');
    $time=date('h:i:s');
    $datetime=date('h:i:s d-m-y');
    $sql="INSERT INTO tbl_log (login_id,`type`, `dis`, `date`, `time`,`datetime`) VALUES ($login_id,'$type','$dis','$date','$time','$datetime')"; 
    // if(mysqli_query($con,$sql)){
    //     echo "log sucessfull";
    // }
    // else{
    //     echo"failed";
    // }
    mysqli_query($con,$sql);
}

// log_activity(12,'device','device location changed');

?>